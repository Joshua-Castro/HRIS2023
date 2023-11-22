'use strict';

function attendance() {
    return {
        attendanceData      :       [],
        currentAttendanceData : {
            employeeId          :   '',
            attendanceId        :   '',
            attendanceDate      :   '',
            clockIn             :   '',
            breakOut            :   '',
            breakIn             :   '',
            clockOut            :   '',
        },

        attendanceEmployeeName          :   '',
        employeeAttendanceDate          :   '',
        currentSearchName               :   '',
        currentPagination               :   5,
        currentPage                     :   1,
        attendanceInputTimer            :   null,
        attendanceModal                 :   '#attendance-filter-modal',
        editAttendanceModal             :   '#edit-attendance-modal',
        attendanceFilterFrom            :   '',
        attendanceFilterTo              :   '',
        attendanceLoading               :   false,
        csrfToken                       :   $('meta[name="csrf-token"]').attr('content'),

        // METHOD
        init () {
            $('#attendance-date-from', this.attendanceModal).datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            }).attr("readonly", "readonly");

            $('#attendance-date-to', this.attendanceModal).datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            }).attr("readonly", "readonly");

            // EDIT TIME TIME START AND END INITIALIZATION
            $('.attendance-time').datetimepicker({
                useCurrent: false,
                format: "hh:mm:ss A"
            });

            this.attendancePaginationPage();
            this.getAllAttendance();
        },

        // OPEN MODAL FOR FILTERING. FILTERING BUTTON ON THE ATTENDANCE TABLE
        filtering : function () {
            $(this.attendanceModal).modal({
                backdrop: 'static',
                keyboard: false
            });

            $(this.attendanceModal).modal('show');
        },

        // SEARCH SPECIFIC EMPLOYEE NUMBER ON ATTENDANCE TABLE
        inputAttendanceSearch : function (event) {
            clearTimeout(this.attendanceInputTimer);
                if (event.code === 'Enter') {
                    // this.disableInput();
                    this.updateAttendanceSearchInput();
                    this.triggerAttendanceSearch();
                } else {
                    this.attendanceInputTimer = setTimeout(() => {
                        this.updateAttendanceSearchInput();
                        this.getAllAttendance();
                    }, 1000);
                }
        },

        // UPDATE NAME VALUE OF THE NAME
        updateAttendanceSearchInput : function () {
            this.$refs.employeeNumberInput.value = this.currentSearchName;
        },

        // TRIGGER SEARCH WHEN THE BUTTON WHEN CLICK ENTER
        triggerAttendanceSearch : function () {
            this.$refs.attendanceSearchButton.click();
        },

        // GET ALL ATTENDANCE DATA ON TABLE TO SHOW IN UI
        getAllAttendance : function () {
            this.attendanceLoading   = true;
            $('ul.pagination').empty();

            this.currentSearchName      = $('input[id="attendance-search-keyword"]'   ,this.attendanceModal).val() ? $('input[id="attendance-search-keyword"]'    ,this.attendanceModal).val() : '';
            this.attendanceFilterFrom   = $('input[name="attendance-date-from"]'      ,this.attendanceModal).val() ? $('input[name="attendance-date-from"]'       ,this.attendanceModal).val() : '';
            this.attendanceFilterTo     = $('input[name="attendance-date-to"]'        ,this.attendanceModal).val() ? $('input[name="attendance-date-to"]'         ,this.attendanceModal).val() : '';

            $('input[name="employee-number-hidden"]'         ).val(this.currentSearchName);
            $('input[name="attendance-pagination-hidden"]'   ).val(this.currentPagination);
            $('input[name="date-from"]'                      ).val(this.attendanceFilterFrom);
            $('input[name="date-to"]'                        ).val(this.attendanceFilterTo);
            $('input[name="page"]'                           ).val(this.currentPage);

            $.ajax({
                type        :   "GET",
                url         :   route("attendance.all"),
                data        :   $('#attendance-search-form').serializeArray(),
            }).then((response) => {
                $(this.attendanceModal).modal({
                    backdrop: 'static',
                    keyboard: false
                });

                var data = response.attendance;
                var attendanceData = data['data'],
                    navlinks = data['links'];

                let component = this;
                    if (data['total']) {
                        // PAGINATION LINKS
                        $.each(navlinks, function (i, link) {
                            var nav = '';

                            nav += '<li class="page-item' + (link['active'] ? ' active' : '') + (!link['url'] ? ' disabled' : '') + '">';
                            nav += '<a class="page-link" href="' + link['url'] + '">' + link['label'] + '</a>';
                            nav += '</li>';

                            $('ul.pagination').append(nav);
                        });

                        if (data['from']) {

                            $('#attendance-counter').text('Showing ' + data['from'] + ' to ' + data['to'] + ' of ' + data['total'] + ' Attendance/s');

                        } else {
                            $('.pagination a[href="' + data['first_page_url'] + '"]').trigger('click');
                        }
                    } else {
                        $('#attendance-counter').text('No Attendance Found!');
                    }


                    this.attendanceLoading      = false;
                    this.attendanceData    = attendanceData;
                    $.each(this.attendanceData, function (i, row) {
                        component.attendanceData[i].clock_in    = component.attendanceData[i].clock_in  ? component.attendanceConvert24hrTo12hr(component.attendanceData[i].clock_in)   : '----:----:----';
                        component.attendanceData[i].break_out   = component.attendanceData[i].break_out ? component.attendanceConvert24hrTo12hr(component.attendanceData[i].break_out)  : '----:----:----';
                        component.attendanceData[i].break_in    = component.attendanceData[i].break_in  ? component.attendanceConvert24hrTo12hr(component.attendanceData[i].break_in)   : '----:----:----';
                        component.attendanceData[i].clock_out   = component.attendanceData[i].clock_out ? component.attendanceConvert24hrTo12hr(component.attendanceData[i].clock_out)  : '----:----:----';
                    });
                    $(component.attendanceModal).modal('hide');
                    console.log(this.attendanceData);
            }).catch((error) => {
                console.log(error);
                if (error.responseJSON && error.responseJSON.errors) {
                    if (error.responseJSON.errors['date-to']) {
                        Swal.fire({
                            title                   :   'ERROR DATE RANGE FORMAT',
                            html                    :   'The <b class="text-decoration-underline">Date To: </b> field must be a date after or equal to <b class="text-decoration-underline">Date From: </b>',
                            icon                    :   'error',
                            timer                   :   5000,
                            showConfirmButton       :   false,
                            allowEscapeKey          :   false,
                            allowOutsideClick       :   false,
                        });
                        this.attendanceLoading      = false;
                    }
                } else {
                    // Handle other error scenarios
                    // ...
                }
            });
        },

        // PAGINATION PAGE ON THE TABLE ATTENDANCE DATA
        attendancePaginationPage : function () {
            let component = this;

            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                component.currentPage = page;

                // CALL THE getAllAttendance METHOD USING THE COMPONENT REFERENCE OR THIS
                component.getAllAttendance();
            });
        },

        // CONVERT 24 HOUR FORMAT TO 12 HOUR FORMAT
        attendanceConvert24hrTo12hr : function(time) {
            // THE TIMEDATA MUST IN THE FORMAT OF : "HH:mm:ss"
            const [hours, minutes, seconds] = time.split(':').map(Number);

            // CREATE A DATE OBJECT AND SET HOURS, MINS AND SECS
            const date = new Date();
            date.setHours(hours);
            date.setMinutes(minutes);
            date.setSeconds(seconds);

            // FORMAT AS 12HOUR TIME WITH AM/PM
            const formattedTime = date.toLocaleString('en-US', {
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true,
            });

            return formattedTime;
        },

        // CONVERT 12 HOUR FORMAT TO 24 HOUR FORMAT
        attendanceConvert12hrTo24hr: function (time) {
            // THE TIMEDATA MUST BE IN THE FORMAT OF: "hh:mm:ss AM/PM"
            const [timePart, period] = time.split(' ');
            const [hours, minutes, seconds] = timePart.split(':').map(Number);

            // CONVERT TO 24-HOUR FORMAT
            let convertedHours = hours % 12;
            convertedHours = period === 'PM' ? convertedHours + 12 : convertedHours;

            // ADD LEADING ZEROS IF NEEDED
            const formattedTime = `${convertedHours.toString().padStart(2, '0')}:${minutes}:${seconds}`;

            return formattedTime;
        },

        // EDIT ATTENDANCE OF SPECIFIC EMPLOYEE,
        // OPEN MODAL AND INITIATE THE VALUE BASED ON THE SELECTED EMPLOYEE'S ATTENDANCE
        editEmployeeAttendance : function (index) {
            $(this.editAttendanceModal).modal({
                backdrop: 'static',
                keyboard: false
            });

            this.attendanceEmployeeName = this.attendanceData[index] ? this.attendanceData[index].first_name + ' ' + (this.attendanceData[index].middle_name ? this.attendanceData[index].middle_name + ' ' : ' ') + this.attendanceData[index].last_name : "";
            this.employeeAttendanceDate = this.attendanceData[index] ? this.attendanceData[index].attendance_date : '';

            this.currentAttendanceData = {
                employeeId          :   this.attendanceData[index].employee_id          ?   this.attendanceData[index].employee_id          :   '',
                attendanceId        :   this.attendanceData[index].attendance_id        ?   this.attendanceData[index].attendance_id        :   '',
                attendanceDate      :   this.attendanceData[index].attendance_date      ?   this.attendanceData[index].attendance_date      :   '',
                clockIn             :   this.attendanceData[index].clock_in             ?   moment(this.attendanceData[index].clock_in      ,'h:mm:ss A').format('hh:mm:ss A')  :   '----:----:----',
                breakOut            :   this.attendanceData[index].break_out            ?   moment(this.attendanceData[index].break_out     ,'h:mm:ss A').format('hh:mm:ss A')  :   '----:----:----',
                breakIn             :   this.attendanceData[index].break_in             ?   moment(this.attendanceData[index].break_in      ,'h:mm:ss A').format('hh:mm:ss A')  :   '----:----:----',
                clockOut            :   this.attendanceData[index].clock_out            ?   moment(this.attendanceData[index].clock_out     ,'h:mm:ss A').format('hh:mm:ss A')  :   '----:----:----',
            };

            $('input[name="edit-clock-in"]'     ).val(this.currentAttendanceData.clockIn);
            $('input[name="edit-break-out"]'    ).val(this.currentAttendanceData.breakOut);
            $('input[name="edit-break-in"]'     ).val(this.currentAttendanceData.breakIn);
            $('input[name="edit-clock-out"]'    ).val(this.currentAttendanceData.clockOut);

            $(this.editAttendanceModal).modal('show');
        },

        // SEND THE UPDATED VALUE TO THE BACKEND
        updateEmployeeAttendance : function () {
            this.currentAttendanceData.clockIn      =   $('input[name="edit-clock-in"]'  ).val() ? this.attendanceConvert12hrTo24hr($('input[name="edit-clock-in"]'  ).val()) : '';
            this.currentAttendanceData.breakOut     =   $('input[name="edit-break-out"]' ).val() ? this.attendanceConvert12hrTo24hr($('input[name="edit-break-out"]' ).val()) : '';
            this.currentAttendanceData.breakIn      =   $('input[name="edit-break-in"]'  ).val() ? this.attendanceConvert12hrTo24hr($('input[name="edit-break-in"]'  ).val()) : '';
            this.currentAttendanceData.clockOut     =   $('input[name="edit-clock-out"]' ).val() ? this.attendanceConvert12hrTo24hr($('input[name="edit-clock-out"]' ).val()) : '';

            $.ajax({
                type : "POST",
                url : route("attendance.update"),
                data : this.currentAttendanceData,
                headers     : {
                    'X-CSRF-TOKEN' : this.csrfToken
                },
            }).then((response) => {
                $(this.editAttendanceModal).modal('hide');
                Swal.fire({
                    title               : response.message,
                    icon                : 'success',
                    timer               : 1000,
                    showConfirmButton   : false,
                });
                console.log(response);
                this.getAllAttendance();
            }).catch((error) => {

            });
        },

    }
}
