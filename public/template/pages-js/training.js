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

            // TIME PICKER TRAINING TIME
            $('.training-time').datetimepicker({
                format: 'LT'
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
