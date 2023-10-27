'use strict';

function profile(userId) {
    return {
        // PROPERTIES
        profileData         :   [],
        userId              :   userId,
        csrfToken           :   $('meta[name="csrf-token"]').attr('content'),
        passwordModal       :   "#employee-update-profile-modal",
        fullName            :   "",
        profileLoading      :   false,
        userEmail           :   "",
        userPassword        :   "",


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

            $(this.passwordModal).modal('show');
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
