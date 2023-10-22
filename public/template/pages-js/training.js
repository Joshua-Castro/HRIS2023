'use strict';

function training() {
    return {
        // PROPERTIES
        trainingData                :   [],
        currentTraining             :   {
            trainingRecordId    :   0,
            trainingTitle       :   '',
            trainingDesc        :   '',
            trainingLocation    :   '',
            trainingStartDate   :   '',
            trainingEndDate     :   '',
            trainingStartTime   :   '',
            trainingEndTime     :   '',
        },

        trainingModal                   :   '#training-modal',
        trainingLoading                 :   false,
        csrfToken                       :   $('meta[name="csrf-token"]').attr('content'),
        buttonDisabled                  :   false,
        trainingLoading                 :   false,



        // METHODS
        init () {
            // TRAINING START AND END DATE DATEPICKER INITALIZATION
            $('.training-date').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            });

            // TRAINING TIME START AND END INITIALIZATION
            $('.training-time').datetimepicker({
                useCurrent: false,
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

        // FORM ON SUBMIT EITHER STORE | UPDATE EMPLOYEE DATA
        submitTraining : function () {
            this.buttonDisabled = true;
            const trainingForm                          =   $('#training-form'    ,this.trainingModal)[0];
            this.currentTraining.trainingStartDate      =   $('input[name="training-start"]'            ,this.trainingModal).val();
            this.currentTraining.trainingEndDate        =   $('input[name="training-end"]'              ,this.trainingModal).val();
            this.currentTraining.trainingStartTime      =   $('input[name="training-start-time"]'       ,this.trainingModal).val();
            this.currentTraining.trainingEndTime        =   $('input[name="training-end-time"]'         ,this.trainingModal).val();

            console.log(this.currentTraining);

            $(trainingForm).removeClass('was-validated').addClass('was-validated');

            if (trainingForm.checkValidity()) {
                $.ajax({
                    type        : "POST",
                    url         : route("training.store"),
                    data        : {
                        _token: this.csrfToken,
                        ...this.currentTraining
                    },
                }).then((response) => {
                    Swal.fire({
                        title               :   response.message,
                        icon                :   'success',
                        timer               :   1000,
                        showConfirmButton   :   false,
                    });
                    this.buttonDisabled = false;

                }).catch((error) => {
                    this.buttonDisabled = false;
                    if (error.responseJSON && error.responseJSON.error) {

                    } else {
                        // Handle other error scenarios
                        // ...
                    }
                });
            }
        },

        // FETCH OR GET ALL TRAINING'S DATA
        getTraining : function () {
            this.trainingLoading = true;

            $.ajax({
                type        : "GET",
                url         : route("training.show"),
                data        : {
                    _token: this.csrfToken,
                },
            }).then((response) => {
                this.trainingData = response.training ? JSON.parse(atob(response.training)) : "";
            }).catch((error) => {
                Swal.fire('Something error! Please refrain to this error : Fetching Training','error');
            });
        }


    }
}
