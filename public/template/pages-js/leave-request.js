'use strict';

function leaveRequest() {
    return {
        // PROPERTIES
        leaveData           :   [],
        viewLeaveDataModal  :   '#view-request-leave-modal',
        staticData          :   {
            leaveDate       :   '',
            leaveType       :   '',
            dayType         :   '',
            reason          :   '',
        },

        adminLeaveLoading    :   false,
        leaveRequestCount    :   0,
        leaveCsrfToken       :   $('meta[name="csrf-token"]').attr('content'),

        // METHODS
        init() {
            // SHOW WARNING ON CONSOLE
            if (window.console && window.console.log) {
                console.log("%cWHAT YOU DOING? STOP THAT SH!T"                                          , "color: red; font-size: 72px; font-weight: bold;");
                console.log("%cThis is a browser feature intended for developers. Not for users!"       , "font-size: 32px;");
                console.log("%cIf someone told you to copy and paste something here, it's a scam."      , "font-size: 32px;");
                console.log("%cWe can also get your IP, and will come back for revenge."                , "font-size: 32px;");
            }

            this.fetchLeaveData();
        },

        // FETCH ALL LEAVE AND UPDATE IT EITHER ACCEPT OR DECLINE
        fetchLeaveData : function () {
            this.adminLeaveLoading = true;
            $.ajax({
                type        :   "GET",
                url         :   route("leave.show.all"),
            }).then((response) => {
                const leaveData     = Object.keys(response)[0];
                const leaveCount    = Object.keys(response)[1];
                this.leaveData         = response[leaveData] ? JSON.parse(atob(response[leaveData])) : "";
                this.leaveRequestCount = response[leaveCount];
                this.adminLeaveLoading = false;

            }).catch((error) => {

            })
        },

        // VIEW LEAVE REQUEST BY EMPLOYEE
        viewRequest : function (index) {
            this.staticData          =   {
                leaveDate       :   this.leaveData[index].leave_date,
                leaveType       :   this.leaveData[index].leave_type,
                dayType         :   this.leaveData[index].day_type,
                reason          :   this.leaveData[index].reason,
            }

            $(this.viewLeaveDataModal).modal('show');
        },

        // ACCEPT OR DELETE THE LEAVE REQUEST
        updateRequest : function (index, type) {
            var text    =   '',
                confirm =   '';
            if (type === 'Accepted') {
                text = 'Accept this leave? <b>' + this.leaveData[index].leave_type + '</b>';
                confirm = 'Accept it!';
            } else if (type === 'Declined') {
                text = 'Decline this leave? <b>' + this.leaveData[index].leave_type + '</b>'  + `<div class="form-floating mt-4">
                <textarea name="reason-decline" id="swal-textarea" class="form-control" placeholder="REASON FOR DECLINING" required style="height: 100px;"></textarea>
                <label for="reason-decline" class="text-small">REASON FOR DECLINING</label>
                </div>`;
                confirm = 'Decline it!';
            }

            Swal.fire({
                title               :   "Are you sure?",
                html                :   text,
                icon                :   "warning",
                showCancelButton    :   !0,
                confirmButtonColor  :   "#28bb4b",
                cancelButtonColor   :   "#f34e4e",
                confirmButtonText   :   "Yes, " + confirm,
                customClass: {
                    icon: 'custom-swal-icon' // APPLY CUSTOM CLASS TO THE ICON
                  },
              }).then(result => {
                  if(result.isConfirmed){
                    const textareaValue = document.getElementById('swal-textarea');
                    var declineReason = textareaValue ? textareaValue.value : null;

                      $.ajax({
                        type        :   "POST",
                        url         :   route('leave.update'),
                        data        :   {
                            _token  :   this.leaveCsrfToken,
                            id      :   this.leaveData[index].id,
                            status  :   type,
                            reason  :   declineReason
                        },
                      }).then((data) => {
                        Swal.fire({
                                  title               : data.message,
                                  icon                : 'success',
                                  timer               : 1000,
                                  showConfirmButton   : false,
                              });
                              this.fetchLeaveData();
                      }).catch(err => {
                        Swal.fire('Updating Failed. Please refresh the page and try again.','error');
                    })
                  }
              });

              $('.custom-swal-icon').css('margin-top', '20px');
        },
    }
}
