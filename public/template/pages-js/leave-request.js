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

        leaveRequestCount    :   0,
        leaveCsrfToken       :   $('meta[name="csrf-token"]').attr('content'),

        // METHODS
        init() {
            this.fetchLeaveData();
        },

        // FETCH ALL LEAVE AND UPDATE IT EITHER ACCEPT OR DECLINE
        fetchLeaveData : function () {
            // var component = this;
            $.ajax({
                type        :   "GET",
                url         :   route("leave.show.all"),
            }).then((response) => {
                this.leaveData = response.data;
                this.leaveRequestCount = response.count;
                console.log(this.leaveData);
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

        // ACCEPT OR DELET THE LEAVE REQUEST
        updateRequest : function (index, type) {
            var text = '',
                confirm = '';
            if (type === 'Accepted') {
                text = 'Accept this leave? <b>' + this.leaveData[index].leave_type + '</b>';
                confirm = 'Accept it!';
            } else if (type === 'Declined') {
                text = 'Decline this leave? <b>' + this.leaveData[index].leave_type + '</b>';
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
                    icon: 'custom-swal-icon' // Apply custom class to the icon
                  }
              }).then(result => {
                  if(result.isConfirmed){
                      $.ajax({
                        type      :   "POST",
                        url       :   route('leave.update'),
                        data      :   {
                            _token: this.leaveCsrfToken,
                            id: this.leaveData[index].id,
                            status:  type
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