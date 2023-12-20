'use strict';

function activity() {
    return {
        // PROPERTIES
        logsData        :   [],
        logsLoading     :   false,


        // METHODS
        init () {
            // SHOW WARNING ON CONSOLE
            if (window.console && window.console.log) {
                console.log("%cWHAT YOU DOING? STOP THAT SH!T"                                          , "color: red; font-size: 72px; font-weight: bold;");
                console.log("%cThis is a browser feature intended for developers. Not for users!"       , "font-size: 32px;");
                console.log("%cIf someone told you to copy and paste something here, it's a scam."      , "font-size: 32px;");
                console.log("%cWe can also get your IP, and will come back for revenge."                , "font-size: 32px;");
            }

            this.fetchLogs();
        },

        // REFRESH OR RELOAD THE FETCH

        // FETCH LOGS DATA TO DISPLAY IN THE ACTIVITY PAGE
        fetchLogs : function () {
            var component = this;
            this.logsLoading = true;
            $.ajax({
                type        : "GET",
                url         : route("log.show"),
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken
                },
            }).then((response) => {
                const key               =   Object.keys(response)[0];
                component.logsData      =   response[key] ? JSON.parse(atob(response[key])) : "";

                $.each(component.logsData, function (i, row) {
                    component.logsData[i].created_at    = component.logsData[i].created_at  ? component.timeAgo(component.logsData[i].created_at)   : '';
                });
                this.logsLoading = false;
            }).catch((error) => {
                Swal.fire('Something error! Please refrain to this error : Fetching Logs', 'error');
            });
        },

        // FORMAT THE TIME OR HISTORY WHEN IS THE LOG BEEN CREATED
        timeAgo: function (created_at) {
            const currentDate = new Date();
            const logDate = new Date(created_at);
            const timeDifference = currentDate - logDate;

            switch (true) {
                case timeDifference < 60000:
                    return "Just now";
                case timeDifference < 3600000:
                    const minutesAgo = Math.floor(timeDifference / 60000);
                    if (minutesAgo === 1) {
                        return "1 minute ago";
                    } else {
                        return minutesAgo + " minutes ago";
                    }
                case timeDifference < 86400000:
                    const hoursAgo = Math.floor(timeDifference / 3600000);
                    const remainingMinutes = Math.floor((timeDifference % 3600000) / 60000);

                    if (hoursAgo === 1) {
                        if (remainingMinutes === 1) {
                            return "1 hour and 1 minute ago";
                        } else {
                            return `1 hour and ${remainingMinutes} minutes ago`;
                        }
                    } else {
                        if (remainingMinutes === 1) {
                            return `${hoursAgo} hours and 1 minute ago`;
                        } else {
                            return `${hoursAgo} hours and ${remainingMinutes} minutes ago`;
                        }
                    }
                default:
                    const daysAgo = Math.floor(timeDifference / 86400000);
                    return daysAgo === 1 ? "1 day ago" : daysAgo + " days ago";
            }
        },
    }
}
