'use strict';

function payroll() {
    return {
        // PROPERTIES
        inputTimer                          :   null,
        searchEmployee                      :   '',
        employeeId                          :   '',
        employeePayrollData                 :   [],
        attendancePayrollData               :   [],
        filter                              :   'all',
        pagination                          :   5,
        page                                :   1,
        attendancePage                      :   1,
        loadingPayroll                      :   false,
        attendanceDetailsLoading            :   false,
        totalHours                          :   0,
        regularHours                        :   0,
        employeeName                        :   '',
        dateFrom                            :   '#payroll-date-from',
        dateTo                              :   '#payroll-date-to',
        dateFromVal                         :   '',
        dateToVal                           :   '',

        // METHOD
        init () {
            var today = new Date();

            var fromDate = new Date();
            fromDate.setDate(today.getDate() - 14);

            $(this.dateFrom).datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            }).attr("readonly", "readonly").datepicker("setDate", fromDate);

            $(this.dateTo).datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            }).attr("readonly", "readonly").datepicker("setDate", today);

            this.dateFromVal    = $(this.dateFrom).val();
            this.dateToVal      = $(this.dateTo).val();

            let here = this;
            // WHEN THE HR OR ADMIN CHANGE THE DATE FOR ATTENDANCE DETAILS CREATE A CUSTOM EVENT AND INITIALIZE THE METHOD
            // TO RE-FETCH THE ATTENDANCE DETAILS BASE ON THE NEW VALUE OF DATE FROM AND DATE TO
            $(this.dateFrom).on('change', function() {
                // GET THE CHANGED OR NEW DATE VALUE FROM THE DATE TIME PICKER
                const dateFrom = $(this).val();
                here.dateFromVal      = dateFrom;

                // TRIGGER THE CUSTOM EVENT WITH THE NEW VALUE
                this.dispatchEvent(new CustomEvent('date-from-changed',
                    {
                        bubbles : true
                    }
                ));
            });

            $(this.dateTo).on('change', function() {
                // GET THE CHANGED OR NEW DATE VALUE FROM THE DATE TIME PICKER
                const dateTo = $(this).val();
                here.dateToVal      = dateTo;

                // TRIGGER THE CUSTOM EVENT WITH THE NEW VALUE
                this.dispatchEvent(new CustomEvent('date-to-changed',
                    {
                        bubbles : true
                    }
                ));
            });

            this.getEmployeeDataPayroll();
            this.paginationPage();
            this.paginationPageAttendance();
        },

        // SEARCH SPECIFIC NAME OF EMPLOYEE ON EMPLOYEE TABLE
        employeeSearchPayroll : function (event) {
            clearTimeout(this.inputTimer);
                if (event.code === 'Enter') {
                    // this.disableInput();
                    this.updateSearchInput();
                    this.triggerSearch();
                } else {
                    this.inputTimer = setTimeout(() => {
                        this.updateSearchInput();
                        this.getEmployeeDataPayroll();
                    }, 1000);
                }
        },

        // TRIGGER SEARCH WHEN THE BUTTON WHEN CLICK ENTER
        triggerSearch : function () {
            this.$refs.usersSearchButton.click();
        },

        // UPDATE NAME VALUE OF THE NAME
        updateSearchInput : function () {
            this.$refs.employeeInput.value = this.searchEmployee;
        },

        // FETCH DATA ON DATABASE AND DISPLAY ON TABLE EMPLOYEE DATA
        getEmployeeDataPayroll : function () {
            this.loadingPayroll = true;
            $('ul.employee-payroll-pagination').empty();

            $('input[name="name"]'          ).val(this.searchEmployee);
            $('input[name="status"]'        ).val(this.filter);
            $('input[name="pagination"]'    ).val(this.pagination);
            $('input[name="page"]'          ).val(this.page);

            $.ajax({
                type        :   "GET",
                url         :   route("employee.show"),
                data        :   $('#users-search-form').serializeArray(),
            }).then((response) => {
                const usersData     =   Object.keys(response)[0];
                var data = response[usersData] ? JSON.parse(atob(response[usersData])) : "";
                var users = data['data'],
                    navlinks = data['links'];

                    if (data['total']) {
                        // PAGINATION LINKS
                        $.each(navlinks, function (i, link) {
                            var nav = '';

                            nav += '<li class="page-item' + (link['active'] ? ' active' : '') + (!link['url'] ? ' disabled' : '') + '">';
                            nav += '<a class="page-link" href="' + link['url'] + '">' + link['label'] + '</a>';
                            nav += '</li>';

                            $('ul.employee-payroll-pagination').append(nav);
                        });

                        if (data['from']) {

                            $('#employee-counter').text('Showing ' + data['from'] + ' to ' + data['to'] + ' of ' + data['total'] + ' Account/s');

                        } else {
                            $('.employee-payroll-pagination a[href="' + data['first_page_url'] + '"]').trigger('click');
                        }
                    } else {
                        $('#employee-counter').text('No Accounts Found!');
                    }

                this.employeePayrollData    = users;
                this.loadingPayroll         = false;
                console.log(this.employeePayrollData);
                console.log(this.employeeName);
            }).catch((error) => {

            })
        },

        // PAGINATION PAGE ON THE TABLE EMPLOYEE DATA
        paginationPage : function () {
            var component = this;

            $(document).on('click', '.employee-payroll-pagination a', function (e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];

                component.page = page;

                // Call the getEmployeeDataPayroll method using the component reference
                component.getEmployeeDataPayroll();
            });
        },

        // PAGINATION PAGE ON THE TABLE EMPLOYEE DATA
        paginationPageAttendance : function () {
            var component = this;

            $(document).on('click', '.attendance-payroll-pagination a', function (e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];

                component.attendancePage = page;

                // Call the getAttendanceDetails method using the component reference
                component.getAttendanceDetails(component.employeeId);
            });
        },

        // GENERATE PAYROLL
        generatePayroll : function (employeeId, index) {
            $('.payroll-row').removeClass('d-none');
            this.employeeName = this.employeePayrollData[index] ? this.employeePayrollData[index].first_name + ' ' + (this.employeePayrollData[index].middle_name ? this.employeePayrollData[index].middle_name + ' ' : ' ') + this.employeePayrollData[index].last_name : "";
            if (this.employeeId != employeeId) {
                this.totalHours = '';
                this.getAttendanceDetails(employeeId);

                // SCROLL TO THE BOTTOM
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 500); // ADJUST THE ANIMATION SPEED HERE
            }
        },

        // GET THE ATTENDANCE OF THE EMPLOYEE TO GENERATE ITS PAYROLL
        getAttendanceDetails : function (employeeId) {
            $('ul.attendance-payroll-pagination').empty();
            this.employeeId = employeeId;
            this.attendanceDetailsLoading = true;
            var component = this;

            $('input[name="attendance-page"]'           ).val(this.attendancePage);
            $('input[name="dateFrom"]'                  ).val($(this.dateFrom).val());
            $('input[name="dateTo"]'                    ).val($(this.dateTo).val());
            $('input[name="employeeId"]'                ).val(employeeId);

            $.ajax({
                type        :   "GET",
                url         :   route("payroll.employee.attendance"),
                data        :   $('#payroll-attendance-form').serializeArray(),
            }).then((response) => {
                const attendanceDataKey     =   Object.keys(response)[0];
                var data                    =   response[attendanceDataKey] ? JSON.parse(atob(response[attendanceDataKey])) : "";
                var attendanceData          =   data['data'],
                    navlinks                =   data['links'];

                    if (data['total']) {
                        // PAGINATION LINKS
                        $.each(navlinks, function (i, link) {
                            var nav = '';

                            nav += '<li class="page-item' + (link['active'] ? ' active' : '') + (!link['url'] ? ' disabled' : '') + '">';
                            nav += '<a class="page-link" href="' + link['url'] + '">' + link['label'] + '</a>';
                            nav += '</li>';

                            $('ul.attendance-payroll-pagination').append(nav);
                        });

                        if (data['from']) {

                            $('#attendance-payroll-counter').text('Showing ' + data['from'] + ' to ' + data['to'] + ' of ' + data['total'] + ' Attendance/s');

                        } else {
                            $('.attendance-payroll-pagination a[href="' + data['first_page_url'] + '"]').trigger('click');
                        }
                    } else {
                        $('#attendance-payroll-counter').text('No Attendance Found!');
                    }

                    this.attendancePayrollData      =   attendanceData;
                    if (this.attendancePayrollData.length > 0) {
                        component.totalHours    = 0;
                        component.regularHours  = 0;
                        this.attendancePayrollData.forEach(function (employee) {
                            component.totalHours += parseFloat(employee.total_hours) || 0; // ENSURE THE VALUE IS A NUMBER
                            component.regularHours += employee.regular_hours || 0;
                        });

                        component.totalHours    = parseFloat(component.totalHours.toFixed(2));
                    } else {
                        component.totalHours    = 0;
                        component.regularHours  = 0;
                    }
                    this.attendanceDetailsLoading   =   false;
            }).catch((error) => {
                if (error.responseJSON && error.responseJSON.errors) {

                } else {
                    // Handle other error scenarios
                    // ...
                }
            });
        },

        // WHEN USER CHANGED THE ATTENDANCE DATE RE-FETCH THE
        filterAttendanceDetails : function () {
            this.getAttendanceDetails(this.employeeId);

        },

    }
}
