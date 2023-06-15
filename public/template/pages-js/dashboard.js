function adminDashboard() {
    return {
        // PROPERTIES
        employeeData    :   [],
        current         :   {
            recordId                :   0,
            lastName                :   '',
            firstName               :   '',
            middleName              :   '',
            gender                  :   '',
            maidenName              :   '',
            position                :   '',
            lastPromotion           :   '',
            stationCode             :   '',
            controlNumber           :   '',
            employeeNumber          :   '',
            schoolCode              :   '',
            itemNumber              :   '',
            employeeStatus          :   '',
            salaryGrade             :   '',
            dateHired               :   '',
            sss                     :   '',
            pagIbig                 :   '',
            philHealth              :   '',
            name                    :   '',
            email                   :   '',
            password                :   '',
            confirmPassword         :   '',
            userId                  :   '',
        },

        disableFields       : [
            'last_name',
            'first_name',
            'middle_name',
            'gender',
            'maiden_name',
            'position',
            'last_promotion',
            'station_code',
            'control_number',
            'employee_number',
            'school_code',
            'item_number',
            'employment_status',
            'salary_grade',
            'date_hired',
            'sss_benefits',
            'pagibig_benefits',
            'phil_health_benefits'
        ],

        leaveData       :   [],
        currentLeave    :   {
            leaveRecordId   :   0,
            leaveDate       :   '',
            leaveType       :   '',
            dayType         :   '',
            reason          :   '',
        },

        leaveIsLoading          :   false,
        timeLoading             :   false,
        isDisabled              :   false,
        inputTimer              :   null,
        isLoading               :   false,
        currentDate             :   '',
        currentTime             :   '',
        searchName              :   '',
        filter                  :   'all',
        filterName              :   '',
        pagination              :   10,
        page                    :   1,
        employeeCount           :   0,
        leaveCount              :   0,   
        overAllLeaveCount       :   0,   
        leaveModal              :   '#request-leave-modal',
        modal                   :   '#employee-modal',
        leaveReqForm            :   '#leaveRequestForm',
        employeeForm            :   '#employeeForm',
        passwordField           :   '.real-password',
        togglePassword          :   '.toggle-password',
        confirmPasswordField    :   '.confirm-password',
        confirmTogglePassword   :   '.toggle-confirm-password',
        csrfToken               :   $('meta[name="csrf-token"]').attr('content'),

        

        // METHODS
        init() {
            this.getEmployeeData();
            this.paginationPage();
            this.startClock();
            this.getLeaveRequest();
        },

        // CREATE FUNCTION EMPLOYEE
        create : function () {
            $(this.modal).modal({
                        backdrop: 'static',
                        keyboard: false
                        });
            this.current    =  {
                recordId        :   0,
                lastName        :   '',
                firstName       :   '',
                middleName      :   '',
                gender          :   '',
                maidenName      :   '',
                position        :   '',
                lastPromotion   :   '',
                stationCode     :   '',
                controlNumber   :   '',
                employeeNumber  :   '',
                schoolCode      :   '',
                itemNumber      :   '',
                employeeStatus  :   '',
                salaryGrade     :   '',
                dateHired       :   '',
                sss             :   '',
                pagIbig         :   '',
                philHealth      :   '',
                name            :   '',
                email           :   '',
                password        :   '',
            };

            this.disableFields.forEach(function(field) {
                $('input[name="' + field + '"]', this.modal).removeAttr('disabled');
                $('select[name="' + field + '"]', this.modal).removeAttr('disabled');
            });
    
            $('.submit-btn').removeAttr('hidden');

            $(this.passwordField).attr("type", "password");
            $(this.togglePassword).html('<i class="fa fa-eye-slash"></i>');
            $(this.confirmPasswordField).attr("type", "password");
            $(this.confirmTogglePassword).html('<i class="fa fa-eye-slash"></i>');
            $(this.employeeForm, this.modal).removeClass('was-validated');
            $(this.employeeForm)[0].reset();
            $(this.employeeForm, this.modal).removeClass('was-validated');
            $(this.modal).modal('show');
        },

        // EDIT | VIEW FUNCTION EMPLOYEE DATA
        edit : function (index, type) {
            $(this.modal).modal({
                backdrop: 'static',
                keyboard: false
                });
            this.current    =  {
                recordId                :   this.employeeData[index].id,
                lastName                :   this.employeeData[index].last_name,
                firstName               :   this.employeeData[index].first_name,
                middleName              :   this.employeeData[index].middle_name,
                gender                  :   this.employeeData[index].gender,
                maidenName              :   this.employeeData[index].maiden_name,
                position                :   this.employeeData[index].position,
                lastPromotion           :   this.employeeData[index].last_promotion,
                stationCode             :   this.employeeData[index].station_code,
                controlNumber           :   this.employeeData[index].control_no,
                employeeNumber          :   this.employeeData[index].employee_no,
                schoolCode              :   this.employeeData[index].school_code,
                itemNumber              :   this.employeeData[index].item_number,
                employeeStatus          :   this.employeeData[index].employment_status,
                salaryGrade             :   this.employeeData[index].salary_grade,
                dateHired               :   this.employeeData[index].date_hired,
                sss                     :   this.employeeData[index].sss,
                pagIbig                 :   this.employeeData[index].pag_ibig,
                philHealth              :   this.employeeData[index].phil_health,
                name                    :   this.employeeData[index].name,
                email                   :   this.employeeData[index].email,
                password                :   this.employeeData[index].password,
                confirmPassword         :   this.employeeData[index].password,
                userId                  :   this.employeeData[index].user_id,

            };

            // DISABLE FIELDS WHEN USER WANTS ONLY VIEW FUNCTIONALITIES
            if (type === 'view') {
                this.disableFields.forEach(function(field) {
                    $('input[name="' + field + '"]', this.modal).attr('disabled', true);
                    $('select[name="' + field + '"]', this.modal).attr('disabled', true);
                });
        
                $('.submit-btn').attr('hidden', true);
            } else {
                this.disableFields.forEach(function(field) {
                    $('input[name="' + field + '"]', this.modal).removeAttr('disabled');
                    $('select[name="' + field + '"]', this.modal).removeAttr('disabled');
                });
        
                $('.submit-btn').removeAttr('hidden');
            };

        $(this.passwordField).attr("type", "password");
        $(this.togglePassword).html('<i class="fa fa-eye-slash"></i>');
        $(this.confirmPasswordField).attr("type", "password");
        $(this.confirmTogglePassword).html('<i class="fa fa-eye-slash"></i>');
        $(this.employeeForm, this.modal).removeClass('was-validated');
        $(this.modal).modal('show');
        },

        // DELETE OR REMOVE EMPLOYEE DATA
        remove : function (index) {
            Swal.fire({
                title               :   "Are you sure?",
                text                :   "Employee Number: " + this.employeeData[index].employee_no,
                icon                :   "warning",
                showCancelButton    :   !0,
                confirmButtonColor  :   "#28bb4b",
                cancelButtonColor   :   "#f34e4e",
                confirmButtonText   :   "Yes, delete it!",
                customClass: {
                    icon: 'custom-swal-icon' // Apply custom class to the icon
                  }
              }).then(result => {
                  if(result.isConfirmed){
                      this.isLoading = true;
                      $.ajax({
                        type      :   "POST",
                        url       :   route('employee.delete'),
                        data      :   {
                            _token: this.csrfToken,
                            id: this.employeeData[index].id, 
                            userId: this.employeeData[index].user_id
                        },
                      }).then((data) => {
                        Swal.fire({
                                  title               : data.message,
                                  icon                : 'success',
                                  timer               : 1000,
                                  showConfirmButton   : false,
                              });
                        
                        this.getEmployeeData();
                      }).catch(err => {
                        this.isLoading = false;
                        Swal.fire('Delete Failed. Please refresh the page and try again.','error');
                    })
                  }
              });

              $('.custom-swal-icon').css('margin-top', '20px');
        },
        
        // FORM ON SUBMIT EITHER STORE | UPDATE EMPLOYEE DATA
        submit : function () {
            const employeeForm = $('#employeeForm', this.modal)[0];
            $(employeeForm).removeClass('was-validated').addClass('was-validated');

            if (employeeForm.checkValidity()) {
                this.isDisabled = true;
                var email = this.current.email;

                $.ajax({
                    type: "POST",
                    url: route("employee.store"),
                    data: {
                        _token: this.csrfToken,
                        ...this.current
                    },
                }).then((response) => {
                    Swal.fire({
                        title: response.message,
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false,
                    });
                    this.isDisabled = true;
                    $(this.modal).modal('hide');
                    this.getEmployeeData();
                }).catch((error) => {
                    if (error.responseJSON && error.responseJSON.error) {
                        // var errorMessage = error.responseJSON.error;
                        Swal.fire({
                            title: 'Saving Failed!',
                            html: 'Username: <b>' + email + '</b> already exist.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    } else {
                        // Handle other error scenarios
                        // ...
                    }
                });
            }
        },

        // FETCH DATA ON DATABASE AND DISPLAY ON TABLE EMPLOYEE DATA
        getEmployeeData : function () {
            this.isLoading    = true;
            $('ul.pagination').empty();

            $('input[name="name"]'          ).val(this.searchName);
            $('input[name="status"]'        ).val(this.filter);
            $('input[name="pagination"]'    ).val(this.pagination);
            $('input[name="page"]'          ).val(this.page);
            
            $.ajax({
                type        :   "GET",
                url         :   route("employee.show"),
                data        :   $('#users-search-form').serializeArray(),
            }).then((response) => {
                var data = response.users;
                var users = data['data'],
					navlinks = data['links'];

                    if (data['total']) {
                        // pagination links
                        $.each(navlinks, function (i, link) {
                            var nav = '';

                            nav += '<li class="page-item' + (link['active'] ? ' active' : '') + (!link['url'] ? ' disabled' : '') + '">';
                            nav += '<a class="page-link" href="' + link['url'] + '">' + link['label'] + '</a>';
                            nav += '</li>';

                            $('ul.pagination').append(nav);
                        });

                        if (data['from']) {

                            $('#user-counter').text('Showing ' + data['from'] + ' to ' + data['to'] + ' of ' + data['total'] + ' Account/s');

                        } else {
                            $('.pagination a[href="' + data['first_page_url'] + '"]').trigger('click');
                        }

                        // return;
                    } else {
                        $('#user-counter').text('No Accounts Found!');
                    }


                this.isLoading    = false;
                this.employeeData   = users;
                this.employeeCount  = response.count;
            }).catch((error) => {
            })
        },

        // PAGINATION PAGE ON THE TABLE EMPLOYEE DATA
        paginationPage : function () {
            var component = this;

            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
            
                component.page = page;
            
                // Call the getEmployeeData method using the component reference
                component.getEmployeeData();
            });
        },

        // FRONT END VALIDATION ON CONFIRM PASSWORD EMPLOYEE DATA
        validatePasswordConfirmation : function() {
            if (this.current.confirmPassword !== '' && this.current.password !== this.current.confirmPassword) {
                // Show the error message
                this.$refs.errorMessage.style.display = 'block';
                this.isDisabled = true;
            } else {
                // Hide the error message
                this.$refs.errorMessage.style.display = 'none';
                this.isDisabled = false;
            }
        },

        // SEARCH SPECIFIC NAME OF EMPLOYEE ON EMPLOYEE TABLE
        inputSearch: function(event) {
            clearTimeout(this.inputTimer);
                if (event.code === 'Enter') {
                    // this.disableInput();
                    this.updateSearchInput();
                    this.triggerSearch();
                } else {
                    this.inputTimer = setTimeout(() => {
                        this.updateSearchInput();
                        this.getEmployeeData();
                    }, 1000);
                }
        },

        // TRIGGER SEARCH WHEN ON THE BUTTON WHEN CLICK ENTER
        triggerSearch: function() {
            this.$refs.usersSearchButton.click();
        },

        // UPDATE NAME VALUE OF THE NAME
        updateSearchInput: function() {
            this.$refs.nameInput.value = this.searchName;
        },

        // SEE PASSWORD ON ADMIN SIDE
        seePassword : function (type) {
            if (type === 'password') {
                if ($(this.passwordField).attr("type") === "password") {
                    $(this.passwordField).attr("type", "text");
                    $(this.togglePassword).html('<i class="fa fa-eye"></i>');
                } else {
                    $(this.passwordField).attr("type", "password");
                    $(this.togglePassword).html('<i class="fa fa-eye-slash"></i>');
                }
            } else if (type === 'confirmPassword') {
                if ($(this.confirmPasswordField).attr("type") === "password") {
                    $(this.confirmPasswordField).attr("type", "text");
                    $(this.confirmTogglePassword).html('<i class="fa fa-eye"></i>');
                } else {
                    $(this.confirmPasswordField).attr("type", "password");
                    $(this.confirmTogglePassword).html('<i class="fa fa-eye-slash"></i>');
                }
            }
            
        },

        // FOR DATE AND TIME SHOW (USER/EMPLOYEE VIEW)
        startClock: function() {
            this.timeLoading = true;
            setInterval(() => {
                const now = new Date();
                this.currentDate = now.toISOString().slice(0, 10);
                this.currentTime = now.toTimeString().slice(0, 8);
                this.timeLoading = false;
            }, 1000);
        },

        // CREATE LEAVE REQUEST (USER/EMPLOYEE VIEW)
        createRequest : function() {
            $(this.leaveModal).modal({
                backdrop: 'static',
                keyboard: false
                });

            $(this.leaveReqForm)[0].reset();
            $(this.leaveReqForm, this.leaveModal).removeClass('was-validated');
            $(this.leaveModal).modal('show');
        },

        // EDIT LEAVE REQUEST (USER/EMPLOYEE VIEW)
        editLeaveRequest : function (index) {
            $(this.leaveModal).modal({
                backdrop: 'static',
                keyboard: false
                });

            this.currentLeave    =   {
                leaveRecordId   :   this.leaveData[index].id,
                leaveDate       :   this.leaveData[index].leave_date,
                leaveType       :   this.leaveData[index].leave_type,
                dayType         :   this.leaveData[index].day_type,
                reason          :   this.leaveData[index].reason,
            };
            
            $(this.leaveReqForm, this.leaveModal).removeClass('was-validated');
            $(this.leaveModal).modal('show');
        },

        // REMOVE LEAVE REQUEST (USER/EMPLOYEE VIEW)
        removeLeaveRequest : function (index) {
            Swal.fire({
                title               :   "Are you sure?",
                html                :   "Delete this leave request : <b>" + this.leaveData[index].leave_type + "</b>",
                icon                :   "warning",
                showCancelButton    :   !0,
                confirmButtonColor  :   "#28bb4b",
                cancelButtonColor   :   "#f34e4e",
                confirmButtonText   :   "Yes, delete it!",
                customClass: {
                    icon: 'custom-swal-icon' // Apply custom class to the icon
                  }
              }).then(result => {
                  if(result.isConfirmed){
                      this.isLoading = true;
                      $.ajax({
                        type      :   "POST",
                        url       :   route('leave.delete'),
                        data      :   {
                            _token: this.csrfToken,
                            id: this.leaveData[index].id, 
                        },
                      }).then((data) => {
                        Swal.fire({
                                  title               : data.message,
                                  icon                : 'success',
                                  timer               : 1000,
                                  showConfirmButton   : false,
                              });
                        
                        this.getLeaveRequest();
                      }).catch(err => {
                        this.isLoading = false;
                        Swal.fire('Delete Failed. Please refresh the page and try again.','error');
                    })
                  }
              });

              $('.custom-swal-icon').css('margin-top', '20px');
        },

        // ON SUBMIT FORM LEAVE REQUEST (USER/EMPLOYEE VIEW)
        submitRequest : function() {
            const leaveRequestForm = $('#leaveRequestForm', this.leaveModal)[0];
            $(leaveRequestForm).removeClass('was-validated').addClass('was-validated');

            if (leaveRequestForm.checkValidity()) {

                $.ajax({
                    type: "POST",
                    url: route("leave.store"),
                    data: {
                        _token: this.csrfToken,
                        ...this.currentLeave
                    },
                }).then((response) => {
                    Swal.fire({
                        title: response.message,
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false,
                    });
                    this.getLeaveRequest();
                    $(this.leaveModal).modal('hide');
                }).catch((error) => {
                    // if (error.responseJSON && error.responseJSON.error) {
                    //     // var errorMessage = error.responseJSON.error;
                    //     Swal.fire({
                    //         title: 'Saving Failed!',
                    //         html: 'Username: <b>' + email + '</b> already exist.',
                    //         icon: 'error',
                    //         timer: 2000,
                    //         showConfirmButton: false,
                    //     });
                    // } else {
                    //     // Handle other error scenarios
                    //     // ...
                    // }
                });
            }
        },

        // GET EMPLOYEE LEAVE REQUEST
        getLeaveRequest : function() {
            this.leaveIsLoading = true;
            
            $.ajax({
                type        :   "GET",
                url         :   route("leave.show"),
                data        :   $('#users-search-form').serializeArray(),
            }).then((response) => {
                this.overAllLeaveCount = response.overAll;
                this.leaveData = response.data;
                this.leaveCount = response.count;
                this.leaveIsLoading = false;

            }).catch((error) => {

            })
        },








    }
}