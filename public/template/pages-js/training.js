'use strict';

function training() {
    return {
        // PROPERTIES
        data            :   [],
        trainingModal   :   '#training-modal',


        // METHODS
        init () {
            // TRAINING DATE DATEPICKER
            $('.training-date').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            }).attr("readonly", "readonly");

            var firstOpen = true;
            var time;

            $('#training-end-time').datetimepicker({
                useCurrent: true,
                format: "hh:mm A"
            });

        },

        // CREATE TRAINING METHOD
        createTraining : function () {
            $(this.trainingModal).modal({
                backdrop: 'static',
                keyboard: false
            });

            $(this.trainingModal).modal('show');
        },

    }
}
