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

        trainingSearchInput             :   '',
        trainingPagination              :   5,
        trainingCurrentPage             :   1,
        trainingModal                   :   '#training-modal',
        trainingForm                    :   '#training-form',
        trainingLoading                 :   false,
        csrfToken                       :   $('meta[name="csrf-token"]').attr('content'),
        buttonDisabled                  :   false,



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

            this.getTraining();
            this.trainingPaginationPage();
        },

        // CREATE TRAINING METHOD
        createTraining : function () {
            $(this.trainingModal).modal({
                backdrop: 'static',
                keyboard: false
            });

            this.currentTraining = {
                trainingRecordId        :    0,
                trainingTitle           :    '',
                trainingLocation        :    '',
                trainingEndTime         :    '',
                trainingStartTime       :    '',
                trainingDesc            :    '',
                trainingEndDate         :    '',
                trainingStartDate       :    '',
            };

            $('.training-submit-btn'    ,this.trainingModal).removeAttr('hidden');
            $('.form-training-control'  ,this.trainingModal).removeAttr('disabled');
            $('.training-close-btn'     ,this.trainingModal).html('Cancel');
            $(this.trainingForm         ,this.trainingModal)[0].reset();
            $(this.trainingForm         ,this.trainingModal).removeClass('was-validated');
            $(this.trainingModal).modal('show');
        },

        // VIEW OR EDIT TRAINING'S DATA
        editTraining : function (index, method) {
            $(this.trainingModal).modal({
                backdrop: 'static',
                keyboard: false
            });

            this.currentTraining = {
                trainingRecordId        :   this.trainingData[index].id                 ?   this.trainingData[index].id                                                    :   '',
                trainingTitle           :   this.trainingData[index].title              ?   this.trainingData[index].title                                                 :   '',
                trainingLocation        :   this.trainingData[index].location           ?   this.trainingData[index].location                                              :   '',
                trainingEndTime         :   this.trainingData[index].end_time           ?   this.trainingConvert24hrTo12hr(this.trainingData[index].end_time)              :   '',
                trainingStartTime       :   this.trainingData[index].start_time         ?   this.trainingConvert24hrTo12hr(this.trainingData[index].start_time)            :   '',
                trainingDesc            :   this.trainingData[index].description        ?   this.trainingData[index].description                                           :   '',
                trainingEndDate         :   this.trainingData[index].end_date_time      ?   this.trainingData[index].end_date_time                                         :   '',
                trainingStartDate       :   this.trainingData[index].start_date_time    ?   this.trainingData[index].start_date_time                                       :   '',
            };

            // DISABLED THE INPUT AND FIX THE UI DEPENDS ON THE METHOD
            if (method === 'view') {
                console.log('View Mode!');
                $('.training-submit-btn'    ,this.trainingModal).attr('hidden', true);
                $('.form-training-control'  ,this.trainingModal).attr('disabled', true);
                $('.training-close-btn'     ,this.trainingModal).html('Close');
            } else {
                $('.training-submit-btn'    ,this.trainingModal).removeAttr('hidden');
                $('.form-training-control'  ,this.trainingModal).removeAttr('disabled');
                $('.training-close-btn'     ,this.trainingModal).html('Cancel');
            }

            $(this.trainingModal).modal('show');
        },

        // FORM ON SUBMIT EITHER STORE | UPDATE EMPLOYEE DATA
        submitTraining : function () {
            this.buttonDisabled = true;
            const trainingForm                          =   $(this.trainingForm                         ,this.trainingModal)[0];
            this.currentTraining.trainingStartDate      =   $('input[name="training-start"]'            ,this.trainingModal).val();
            this.currentTraining.trainingEndDate        =   $('input[name="training-end"]'              ,this.trainingModal).val();
            this.currentTraining.trainingStartTime      =   $('input[name="training-start-time"]'       ,this.trainingModal).val();
            this.currentTraining.trainingEndTime        =   $('input[name="training-end-time"]'         ,this.trainingModal).val();

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
                    $(this.trainingModal).modal('hide');

                    Swal.fire({
                        title               :   response.message,
                        icon                :   'success',
                        timer               :   1000,
                        showConfirmButton   :   false,
                    });
                    this.buttonDisabled = false;
                    this.getTraining();
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

            $('input[name="training-title"]'                     ).val(this.trainingSearchInput);
            $('input[name="training-pagination-hidden"]'         ).val(this.trainingPagination);

            $.ajax({
                type        : "GET",
                url         : route("training.show"),
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken
                },
                data : $('#training-search-form').serializeArray(),

            }).then((response) => {
                const key               =   Object.keys(response)[0];
                const data              =   response[key] ? JSON.parse(atob(response[key])) : "";

                var trainingData = data['data'],
                    navlinks = data['links'];

                    if (data['total']) {
                        // PAGINATION LINKS
                        $.each(navlinks, function (i, link) {
                            var nav = '';

                            nav += '<li class="page-item' + (link['active'] ? ' active' : '') + (!link['url'] ? ' disabled' : '') + '">';
                            nav += '<a class="page-link" href="' + link['url'] + '">' + link['label'] + '</a>';
                            nav += '</li>';

                            $('ul.pagination').append(nav);
                        });

                        if (data['from']) {

                            $('#training-counter').text('Showing ' + data['from'] + ' to ' + data['to'] + ' of ' + data['total'] + ' Training/s');

                        } else {
                            $('.pagination a[href="' + data['first_page_url'] + '"]').trigger('click');
                        }
                    } else {
                        $('#training-counter').text('No Training Found!');
                    }

                    this.trainingData       =   trainingData ? trainingData : "";
                    this.trainingLoading    =   false;
                    console.log(data);

            }).catch((error) => {
                Swal.fire('Something error! Please refrain to this error : Fetching Training', 'error');
            });
        },

        // PAGINATION PAGE ON THE TABLE TRAINING DATA
        trainingPaginationPage : function () {
            let component = this;

            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                component.trainingCurrentPage = page;

                // CALL THE getAllAttendance METHOD USING THE COMPONENT REFERENCE OR THIS
                component.getTraining();
            });
        },

        // CONVERT 24 HOUR FORMAT TO 12 HOUR FORMAT
        trainingConvert24hrTo12hr : function(time) {
            // Assuming timeData is in the format "HH:mm:ss"
            const [hours, minutes] = time.split(':').map(Number);

            // Create a Date object and set hours, minutes, and seconds
            const date = new Date();
            date.setHours(hours);
            date.setMinutes(minutes);

            // Format as 12-hour time with AM/PM
            const formattedTime = date.toLocaleString('en-US', {
                hour: 'numeric',
                minute: 'numeric',
                hour12: true,
            });

            return formattedTime;
        },


    }
}
