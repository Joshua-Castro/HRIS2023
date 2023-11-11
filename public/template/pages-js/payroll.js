'use strict';

function payroll() {
    return {
        // PROPERTIES
        payrollData      :       [],
        inputTimer                      :   null,
        searchEmployee                  :   '',
        employeePayrollData             :   [],
        filter                          :   'all',
        pagination                      :   5,
        page                            :   1,
        loadingPayroll                  :   false,

        // METHOD
        init () {
            var today = new Date();

            var fromDate = new Date();
            fromDate.setDate(today.getDate() - 14);

            $('#payroll-date-from').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            }).attr("readonly", "readonly").datepicker("setDate", fromDate);

            $('#payroll-date-to').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            }).attr("readonly", "readonly").datepicker("setDate", today);

            this.getEmployeeDataPayroll();
            this.paginationPage();
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
            $('ul.employee-payroll').empty();

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

        // GENERATE PAYROLL
        generatePayroll : function (index, employeeId) {
            console.log(index + " " + employeeId);
        },

    }
}
