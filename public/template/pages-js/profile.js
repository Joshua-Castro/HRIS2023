'use strict';

function profile(userId) {
    return {
        // PROPERTIES
        profileData             :   [],
        userId                  :   userId,
        csrfToken               :   $('meta[name="csrf-token"]').attr('content'),
        passwordModal           :   "#employee-update-profile-modal",
        fullName                :   "",
        profileLoading          :   false,
        userEmail               :   "",
        userPassword            :   "",
        confirmPassword         :   "",
        inputBehavior           :   true,
        accountInfoForm         :   "#update-profile-form",
        submitBtn               :   true,
        editBtn                 :   false,


        // METHODS
        init () {
            this.getProfileData();
        },

        // OPEN MODAL WHEN EDITING OR UPDATING THE USER'S DATA
        updateUserData : function () {
            $(this.passwordModal).modal({
                backdrop: 'static',
                keyboard: false
            });

            this.confirmPassword = "";
            $(this.passwordModal).modal('show');
        },

        // CONFIRM OLD PASSWORD. WILL OPEN MODAL AND VALIDATE
        confirmPasswordValidate : function () {
            if(this.confirmPassword == this.userPassword) {
                this.inputBehavior = false;
                $(this.passwordModal).modal('hide');
                this.submitBtn = false;
                this.editBtn = true;
            } else {
                Swal.fire({
                    title               : "ERROR!",
                    text                : "Wrong Password. Please try again",
                    icon                : 'error',
                    timer               : 1000,
                    showConfirmButton   : false,
                });
            }
        },

        // SUBMIT UPDATED PASSWORD
        submitUpdatePassword : function () {
            // this.profileLoading = true;
            const profileForm = $(this.accountInfoForm)[0];
            $(profileForm).removeClass('was-validated').addClass('was-validated');

            if (profileForm.checkValidity()) {
                $.ajax({
                    type: "POST",
                    url: route("profile.update.info"),
                    headers     : {
                        'X-CSRF-TOKEN': this.csrfToken
                    },
                    data: {
                        user_id     : this.userId,
                        username    : this.userEmail,
                        password    : this.userPassword
                    },
                }).then((response) => {
                    this.inputBehavior      =   true;
                    this.submitBtn          =   true;
                    this.editBtn            =   false;
                    $(profileForm).removeClass('was-validated').addClass('was-validated');

                    Swal.fire({
                        title: response.message,
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false,
                    });

                }).catch((error) => {
                    if (error.responseJSON && error.responseJSON.error) {
                        // var errorMessage = error.responseJSON.error;
                        Swal.fire({
                            title: 'Saving Failed!',
                            html: 'Error, please try again later. Reference: <b>Saving user data</b>.',
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

        // GET USER'S / EMPLOYEE'S DATA TO SHOW IN PROFILE PAGE
        getProfileData : function () {
            this.profileLoading = true;
            $.ajax({
                type        : "GET",
                url         : route('profile.show'),
                headers     : {
                    'X-CSRF-TOKEN': this.csrfToken
                },
                data        : {
                    user_id : this.userId
                },
            }).then((response) => {
                const profileKey    =   Object.keys(response)[0];
                this.profileData    =   response[profileKey] ? JSON.parse(atob(response[profileKey])) : [];
                const wholeName     =   this.profileData.first_name + " " + (this.profileData.middle_name ? this.profileData.middle_name : "") + " " + this.profileData.last_name;
                this.fullName       =   wholeName ? wholeName : this.profileData.maiden_name;
                this.userEmail      =   this.profileData.userEmail ? this.profileData.userEmail : "";
                this.userPassword   =   this.profileData.userPassword ? this.profileData.userPassword : "";
                this.profileLoading =   false;

                console.log(this.profileData);
                console.log(this.profileData.maiden_name);
            }).catch((error) => {
                Swal.fire('Something error!','Please try again! Please refrain to this error : Fetching Profile');
            })
        }
    }
}
