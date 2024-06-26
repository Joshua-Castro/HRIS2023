'use strict';

function generatedPayroll() {
    return {
        // PROPERTIES
        inputTimer                          :   null,
        searchEmployee                      :   '',
        employeeId                          :   '',
        payrollData                         :   [],
        csrfToken                           :   $('meta[name="csrf-token"]').attr('content'),
        
        // METHOD
        init () {
            // SHOW WARNING ON CONSOLE
            if (window.console && window.console.log) {
                console.log("%cWHAT YOU DOING? STOP THAT SH!T"                                          , "color: red; font-size: 72px; font-weight: bold;");
                console.log("%cThis is a browser feature intended for developers. Not for users!"       , "font-size: 32px;");
                console.log("%cIf someone told you to copy and paste something here, it's a scam."      , "font-size: 32px;");
                console.log("%cWe can also get your IP, and will come back for revenge."                , "font-size: 32px;");
            }
            console.log('GENERATED PAYROLL JS');
            this.getAll();
        },

        getAll : function () {
            $.ajax({
                type      :   "GET",
                url       :   route('payroll.all-payroll'),
                data      :   {
                    _token     : this.csrfToken,
                },
            }).then((response) => {
                this.payrollData = response;
                console.log(response)
            }).catch((xhr) => {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '<ul>';

                    $.each(errors, function(key, value) {
                        $.each(value, function(index, message) {
                            errorMessages += '<li class="text-start">' + message + '</li>';
                        });
                    });

                    errorMessages += '</ul>';

                    Swal.fire({
                        title   : 'Invalid data.',
                        html    : errorMessages,
                        icon    : 'error',
                        customClass: {
                            icon: 'custom-swal-icon'
                        }
                    });
                    $('.custom-swal-icon').css('margin-top', '20px');
                } else {
                    Swal.fire('Something went wrong. Please refresh the page and try again.', 'error');
                }
            });
        },

    }
}
