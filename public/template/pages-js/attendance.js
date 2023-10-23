'use strict';

function attendance() {
    return {
        attendanceData      :       [],

        currentSearchName               :   '',
        currentPagination               :   5,
        currentPage                     :   1,
        attendanceInputTimer            :   null,
        attendanceModal                 :   '#attendance-filter-modal',
        attendanceFilterFrom            :   '',
        attendanceFilterTo              :   '',
        attendanceLoading               :   false,




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
                        component.attendanceData[i].clock_in    = component.attendanceData[i].clock_in  ? component.attendanceConvert24hrTo12hr(component.attendanceData[i].clock_in)   : '';
                        component.attendanceData[i].break_out   = component.attendanceData[i].break_out ? component.attendanceConvert24hrTo12hr(component.attendanceData[i].break_out)  : '';
                        component.attendanceData[i].break_in    = component.attendanceData[i].break_in  ? component.attendanceConvert24hrTo12hr(component.attendanceData[i].break_in)   : '';
                        component.attendanceData[i].clock_out   = component.attendanceData[i].clock_out ? component.attendanceConvert24hrTo12hr(component.attendanceData[i].clock_out)  : '';
                    });
                    $(component.attendanceModal).modal('hide');
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
            // Assuming timeData is in the format "HH:mm:ss"
            const [hours, minutes, seconds] = time.split(':').map(Number);

            // Create a Date object and set hours, minutes, and seconds
            const date = new Date();
            date.setHours(hours);
            date.setMinutes(minutes);
            date.setSeconds(seconds);

            // Format as 12-hour time with AM/PM
            const formattedTime = date.toLocaleString('en-US', {
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true,
            });

            return formattedTime;
        },
    }
}
