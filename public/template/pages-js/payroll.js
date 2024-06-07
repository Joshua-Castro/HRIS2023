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
        otHours                             :   0,
        hourlyRate                          :   0,
        employeeName                        :   '',
        employeeNo                          :   '',
        employeeSalary                      :   '',
        employeeDateHired                   :   '',
        employeePosition                    :   '',
        employeeStatus                      :   '',
        totalRegularEarnings                :   0,
        netPay                              :   0,
        roundedHourlyRate                   :   0,
        roundedTotal                        :   0,
        dateFrom                            :   '#payroll-date-from',
        dateTo                              :   '#payroll-date-to',
        generatePayrollModal                :   '#generate-payroll-modal',
        dateFromVal                         :   '',
        dateToVal                           :   '',
        deductions                          :   {
            sss                   :    0,
            pagIbig               :    0,
            philHealth            :    0,
            withHoldingTax        :    0,
            absences              :    0
        },
        totalDeduction                      :   0,

        // METHOD
        init () {
            // SHOW WARNING ON CONSOLE
            if (window.console && window.console.log) {
                console.log("%cWHAT YOU DOING? STOP THAT SH!T"                                          , "color: red; font-size: 72px; font-weight: bold;");
                console.log("%cThis is a browser feature intended for developers. Not for users!"       , "font-size: 32px;");
                console.log("%cIf someone told you to copy and paste something here, it's a scam."      , "font-size: 32px;");
                console.log("%cWe can also get your IP, and will come back for revenge."                , "font-size: 32px;");
            }

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

            // FOR DEDUCTIONS SOLVING
            var component = this;
            $('.deduction-input').on('input', function () {
                var inputId = $(this).attr('id');
                component.deductions[inputId] = $(this).val();

                component.updateTotalDeduction();
                component.deductionOnchange();
            });

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

        // PAGINATION PAGE ON THE TABLE ATTENDANCE DATA
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
            const currentMonth              =   new Date().getMonth() + 1;
            this.employeeName               =   this.employeePayrollData[index] ? this.employeePayrollData[index].first_name + ' ' + (this.employeePayrollData[index].middle_name ? this.employeePayrollData[index].middle_name + ' ' : ' ') + this.employeePayrollData[index].last_name : "";
            this.employeeNo                 =   this.employeePayrollData[index] ? this.employeePayrollData[index].employee_no                :     "";
            this.employeeDateHired          =   this.employeePayrollData[index] ? this.employeePayrollData[index].date_hired                 :     "";
            this.employeePosition           =   this.employeePayrollData[index] ? this.employeePayrollData[index].position                   :     "";
            this.employeeStatus             =   this.employeePayrollData[index] ? this.employeePayrollData[index].employment_status          :     "";
            var salary                      =   this.employeePayrollData[index] ? parseFloat(this.employeePayrollData[index].salary) : 0;
            this.employeeSalary             =   salary.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            const totalWorkingDays          =   this.getWorkingDaysInMonth(currentMonth);
            const totalWorkingHours         =   8;
            const totalDivide               =   totalWorkingDays * totalWorkingHours;
            this.hourlyRate                 =   salary / totalDivide;
            this.roundedHourlyRate          =   this.hourlyRate.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            if (this.employeeId != employeeId) {
                this.totalHours = '';
                this.getAttendanceDetails(employeeId);

                // SCROLL TO THE BOTTOM
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 500); // ADJUST THE ANIMATION SPEED HERE
            }
        },

        // GETTING THE WORKING DAYS IN A MONTH
        getWorkingDaysInMonth : function (month) {
            const currentDate   =   new Date();
            const year          =   currentDate.getFullYear();
            const start         =   new Date(year, month - 1, 1);
            const end           =   new Date(year, month, 0);
            let count           =   0;

            for (let day = start; day <= end; day.setDate(day.getDate() + 1)) {
                if (day.getDay() !== 0 && day.getDay() !== 6) {
                    count++;
                }
            }

            return count;
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

            // SCROLL TO THE BOTTOM
            $('html, body').animate({
                scrollTop: $(document).height()
            }, 300); // ADJUST THE ANIMATION SPEED HERE
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
                        component.totalRegularEarnings      = 0;
                        component.totalHours                = 0;
                        component.regularHours              = 0;
                        component.otHours                   = 0;
                        this.attendancePayrollData.forEach(function (employee) {
                            component.totalHours    += parseFloat(employee.total_hours) || 0; // ENSURE THE VALUE IS A NUMBER
                            component.regularHours  += employee.regular_hours || 0;
                            component.otHours       += parseFloat(employee.total_overtime_hours) || 0;
                        });

                        component.totalHours            = parseFloat(component.totalHours.toFixed(2));
                        component.totalRegularEarnings  = component.hourlyRate * component.regularHours;
                        component.roundedTotal          = component.totalRegularEarnings.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    } else {
                        component.totalHours            = 0;
                        component.regularHours          = 0;
                        component.totalRegularEarnings  = 0;
                        component.roundedTotal          = 0;

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

        // CLICK THE GENERATE AND WILL SHOW THE GENERATE MODAL AS WELL AS THE SAMPLE COMPUTATION FOR THAT PAYROLL
        showPayrollComputation : function () {
            $(this.generatePayrollModal).modal({
                backdrop: 'static',
                keyboard: false
            });
            $('.deduction-input').val('');
            this.totalDeduction     =   0;
            this.deductions         =   {
                sss                   :    0,
                pagIbig               :    0,
                philHealth            :    0,
                withHoldingTax        :    0,
                absences              :    0
            };
            var totalNetPay = this.totalRegularEarnings - this.totalDeduction;
            this.netPay = totalNetPay.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            $(this.generatePayrollModal).modal('show');
        },

        // FUNCTION TO AUTOMATICALLY UPDATE THE TOTAL DEDUCTION
        updateTotalDeduction : function () {
            this.totalDeduction = 0;

            // LOOP THROUGH EACH DEDUCTION AND ADD IT TO THE TOTAL
            for (var key in this.deductions) {
                if (this.deductions.hasOwnProperty(key)) {
                    this.totalDeduction += parseFloat(this.deductions[key]) || 0;
                }
            }
        },

        // TOTAL DEDUCTIONS ON CHANGE, NETPAY WILL CHANGE TOO
        deductionOnchange : function () {
            var totalNetPay = this.totalRegularEarnings - this.totalDeduction;
            this.netPay = totalNetPay.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        },

        // SUBMIT THE GENERATED PAYROLL
        submitGeneratedPayroll : function () {
            const isDeductionsEmpty = Object.values(this.deductions).every(value => value === 0 || value === '0.00' || value === '');

            if (isDeductionsEmpty) {
                Swal.fire({
                    title               :   "Are you sure?",
                    text                :   "Are you sure this employee doesn\'t have any deductions?",
                    icon                :   "warning",
                    showCancelButton    :   !0,
                    confirmButtonColor  :   "#28bb4b",
                    cancelButtonColor   :   "#f34e4e",
                    confirmButtonText   :   "Yes",
                    customClass: {
                        icon: 'custom-swal-icon'
                      }
                  }).then(result => {
                        if(result.isConfirmed){
                            var items = [
                                this.roundedHourlyRate,
                                this.employeeId,
                                this.deductions,
                                this.totalDeduction.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
                                this.netPay,
                                'SUBMITTING'
                            ];
                            $.each(items, function(index, value) {
                                console.log(index + ": " + value);
                                if (typeof value === "string") {
                                    console.log(index + ": " + value);
                                } else if (typeof element === "object") {
                                    console.log(index + ": " + JSON.stringify(value));
                                }
                            });
                            Swal.fire({
                                title               : 'Successfully Published!',
                                icon                : 'success',
                                timer               : 1000,
                                showConfirmButton   : false,
                            });
                        }
                  });
            } else {
                Swal.fire({
                    title               : 'Successfully Published!',
                    icon                : 'success',
                    timer               : 1000,
                    showConfirmButton   : false,
                });
            }
            $('.custom-swal-icon').css('margin-top', '20px');
        },
    }
}
