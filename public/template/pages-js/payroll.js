'use strict';

function payroll() {
    return {
        // PROPERTIES
        payrollData      :       [],

        // METHOD
        init () {
            $('#attendance-date-from', this.attendanceModal).datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            }).attr("readonly", "readonly");

            $('#attendance-date-to', this.attendanceModal).datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            }).attr("readonly", "readonly");

            this.attendancePaginationPage();
            this.getAllAttendance();
        },

    }
}
