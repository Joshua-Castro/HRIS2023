function attendance() {
    return {
        attendanceData      :       [],





        // METHOD
        init () {
            this.getAllAttendance();
        },

        // GET ALL ATTENDANCE DATA ON TABLE TO SHOW IN UI
        getAllAttendance : function () {
            $.ajax({
                type        : "GET",
                url         : route("attendance.all"),
                headers     : {
                    'X-CSRF-TOKEN' : this.csrfToken
                },

            }).then((response) => {
                this.attendanceData    = response.data;
                console.log(this.attendanceData);
            }).catch((error) => {
                if (error.responseJSON && error.responseJSON.error) {

                } else {
                    // Handle other error scenarios
                    // ...
                }
            });
        },
    }
}
