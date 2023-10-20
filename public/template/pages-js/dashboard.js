'use strict';

function adminDashboard(userRole) {
    return {
        // PROPERTIES
        employeeData            :   [],
        employeeAttendance      :   {
            clockIn                 :   '',
            breakOut                :   '',
            breakIn                 :   '',
            clockOut                :   '',
        },
        current                 :   {
            recordId                :       0,
            lastName                :       '',
            firstName               :       '',
            middleName              :       '',
            gender                  :       '',
            maidenName              :       '',
            position                :       '',
            lastPromotion           :       '',
            stationCode             :       '',
            controlNumber           :       '',
            employeeNumber          :       '',
            schoolCode              :       '',
            itemNumber              :       '',
            employeeStatus          :       '',
            salaryGrade             :       '',
            dateHired               :       '',
            sss                     :       '',
            pagIbig                 :       '',
            philHealth              :       '',
            name                    :       '',
            email                   :       '',
            password                :       '',
            confirmPassword         :       '',
            userId                  :       '',
            userImage               :       '',
        },

        disableFields           :   [
            'last_name',
            'first_name',
            'middle_name',
            'gender',
            'maiden_name',
            'position',
            'last_promotion',
            'station_code',
            'control_number',
            'employee_number',
            'school_code',
            'item_number',
            'employment_status',
            'salary_grade',
            'date_hired',
            'sss_benefits',
            'pagibig_benefits',
            'phil_health_benefits',
            'email',
            'password'
        ],

        leaveData               :   [],
        employeeFiles           :   [],
        fetchAttendance         :   [],
        currentLeave            :   {
            leaveRecordId   :   0,
            leaveDate       :   '',
            leaveType       :   '',
            dayType         :   '',
            reason          :   '',
        },

        userRole                        :   userRole,
        dateToday                       :   '',
        newEmployees                    :   '',
        reasonDecline                   :   '',
        leaveIsLoading                  :   false,
        removeFileIsLoading             :   false,
        attendanceMonitoringLoading     :   false,
        timeLoading                     :   false,
        isDisabled                      :   false,
        isLoading                       :   false,
        fileFetchLoading                :   false,
        clockInBtn                      :   false,
        breakOutBtn                     :   false,
        breakInBtn                      :   false,
        clockOutBtn                     :   false,
        indication                      :   false,
        webBundyLoading                 :   false,
        loadGetEmployeeAttendance       :   false,
        inputTimer                      :   null,
        pond                            :   null,
        filter                          :   'all',
        currentDate                     :   '',
        currentTime                     :   '',
        searchName                      :   '',
        imageUrl                        :   '',
        filterName                      :   '',
        pagination                      :   10,
        page                            :   1,
        employeeCount                   :   0,
        leaveCount                      :   0,
        overAllLeaveCount               :   0,
        leaveModal                      :   '#request-leave-modal',
        modal                           :   '#employee-modal',
        fileUploadModal                 :   '#employee-file-upload-modal',
        viewUploadedFileModal           :   '#employee-view-uploaded-file-modal',
        leaveReqForm                    :   '#leaveRequestForm',
        employeeForm                    :   '#employeeForm',
        passwordField                   :   '.real-password',
        togglePassword                  :   '.toggle-password',
        confirmPasswordField            :   '.confirm-password',
        confirmTogglePassword           :   '.toggle-confirm-password',
        csrfToken                       :   $('meta[name="csrf-token"]').attr('content'),



        // METHODS
        init () {
            // INITIALIZE THE DATEPICKER WHEN THE MODAL IS SHOWN IN REQUEST LEAVE (USER/EMPLOYEE SIDE)
            $('#leave-date', this.leaveModal).datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            });

            // INITIALIZE THE DATEPICKER WHEN THE MODAL IS SHOWN IN ADD EMPLOYEE (ADMIN/HR SIDE)
            $('#date-hired', this.modal).datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            });

            // INITIALIZE THE DATEPICKER WHEN THE MODAL IS SHOWN IN ADD EMPLOYEE (ADMIN/HR SIDE)
            $('#last-promotion', this.modal).datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            });

            // INITIALIZE THE DATEPICKER IN ATTENDANCE MONITORING (USER/EMPLOYEE SIDE)
            $('#attendance-monitoring-input').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            }).attr("readonly", "readonly").on('changeDate', function() {
                // Trigger the custom event when the date is selected
                $(this).trigger('date-selected');
            });

            let here = this;
            // DATE TIME PICKER PROVIDES AN EVENT HANDLER FOR VALUE CHANGE (USER/EMPLOYEE SIDE)
            $('#attendance-monitoring-input').on('change', function() {
                // GET THE CHANGED OR NEW DATE VALUE FROM THE DATE TIME PICKER
                const date = $(this).val();

                // TRIGGER THE CUSTOM EVENT WITH THE NEW VALUE
                this.dispatchEvent(new CustomEvent('datetime-changed', { detail: date }));
                here.getEmployeeAttendance(date);
            });

            // INITIALIZE THE SELECT2 IN SALARY GRADE
            $('#salary-grade').select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                dropdownParent: $('#salary-grade').closest('.form-floating') // SET THE DROPDOWN PARENT TO THE CLOSEST FORM-GROUP CONTAINER
            });

            const now       =   new Date();
            const month     =   String(now.getMonth() + 1).padStart(2, '0'); // Months are 0-based
            const day       =   String(now.getDate()).padStart(2, '0');
            const year      =   now.getFullYear();

            this.dateToday = `${year}-${month}-${day}`;
            this.getAllInitialization();
        },

        // CREATE FUNCTION EMPLOYEE
        create : function () {
            $(this.modal).modal({
                backdrop: 'static',
                keyboard: false
            });

            this.imageUrl = '';
            this.$refs.fileInputHidden.value = '';

            this.current    =  {
                recordId        :   0,
                lastName        :   '',
                firstName       :   '',
                middleName      :   '',
                gender          :   '',
                maidenName      :   '',
                position        :   '',
                lastPromotion   :   '',
                stationCode     :   '',
                controlNumber   :   '',
                employeeNumber  :   '',
                schoolCode      :   '',
                itemNumber      :   '',
                employeeStatus  :   '',
                salaryGrade     :   '',
                dateHired       :   '',
                sss             :   '',
                pagIbig         :   '',
                philHealth      :   '',
                name            :   '',
                email           :   '',
                password        :   '',
            };

            // SET TIME OUT FOR SELECT2 AFTER INITIALIZING THE VALUE TO SHOW IT IN THE UI.
            setTimeout(function() {
                $('#salary-grade').select2({
                    theme: "bootstrap-5",
                    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                    dropdownParent: $('#salary-grade').closest('.form-group')
                });
            }, 100);

            let here = this;
            this.disableFields.forEach(function(field) {
                $('input[name="' + field + '"]', here.modal).removeAttr('disabled');
                $('select[name="' + field + '"]', here.modal).removeAttr('disabled');
            });

            $('.submit-btn').removeAttr('hidden');
            $('.account-information'    ,this.modal).removeAttr('hidden');
            $('.account-information'    ,this.modal).removeAttr('disabled');
            $('.upload-picture-btn'     ,this.modal).removeAttr('hidden');

            $(this.passwordField).attr("type", "password");
            $(this.togglePassword).html('<i class="fa fa-eye-slash"></i>');
            $(this.confirmPasswordField).attr("type", "password");
            $(this.confirmTogglePassword).html('<i class="fa fa-eye-slash"></i>');
            $(this.employeeForm, this.modal).removeClass('was-validated');
            $(this.employeeForm)[0].reset();
            $(this.employeeForm, this.modal).removeClass('was-validated');
            $(this.modal).modal('show');
        },

        // EDIT | VIEW FUNCTION EMPLOYEE DATA
        edit : function (index, type) {
            let here = this;

            $(this.modal).modal({
                backdrop: 'static',
                keyboard: false
                });

            this.current    =  {
                recordId            :   this.employeeData[index].employee_id,
                lastName            :   this.employeeData[index].last_name,
                firstName           :   this.employeeData[index].first_name,
                middleName          :   this.employeeData[index].middle_name,
                gender              :   this.employeeData[index].gender,
                maidenName          :   this.employeeData[index].maiden_name,
                position            :   this.employeeData[index].position,
                lastPromotion       :   this.employeeData[index].last_promotion,
                stationCode         :   this.employeeData[index].station_code,
                controlNumber       :   this.employeeData[index].control_no,
                employeeNumber      :   this.employeeData[index].employee_no,
                schoolCode          :   this.employeeData[index].school_code,
                itemNumber          :   this.employeeData[index].item_number,
                employeeStatus      :   this.employeeData[index].employment_status,
                salaryGrade         :   this.employeeData[index].salary_grade,
                dateHired           :   this.employeeData[index].date_hired,
                sss                 :   this.employeeData[index].sss,
                pagIbig             :   this.employeeData[index].pag_ibig,
                philHealth          :   this.employeeData[index].phil_health,
                name                :   this.employeeData[index].name,
                email               :   this.employeeData[index].email,
                password            :   this.employeeData[index].password,
                confirmPassword     :   this.employeeData[index].password,
                userId              :   this.employeeData[index].user_id,
                userImage           :   this.employeeData[index].image_filepath,
            };

            // SET TIME OUT FOR SELECT2 AFTER INITIALIZING THE VALUE TO SHOW IT IN THE UI.
            setTimeout( () => {
                $('#salary-grade').select2({
                    theme: "bootstrap-5",
                    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                    dropdownParent: $('#salary-grade').closest('.form-group')
                });
            }, 100);

            this.imageUrl = 'storage/' + this.current.userImage;
            // DISABLE FIELDS WHEN USER WANTS ONLY VIEW FUNCTIONALITIES
            if (type === 'view') {
                this.disableFields.forEach(function(field) {
                    $('input[name="' + field + '"]'     ,here.modal).attr('disabled', true);
                    $('select[name="' + field + '"]'    ,here.modal).attr('disabled', true);
                });

                $('input[name="last_promotion"]' ,here.modal).removeClass('bg-white');
                $('input[name="date_hired"]'     ,here.modal).removeClass('bg-white');
                $('.account-information'    ,this.modal).removeAttr('hidden');
                $('.submit-btn').attr('hidden', true);
                $('.upload-picture-btn').attr('hidden', true);
            } else {
                this.disableFields.forEach(function(field) {
                    $('input[name="' + field + '"]'     ,here.modal).removeAttr('disabled');
                    $('select[name="' + field + '"]'    ,here.modal).removeAttr('disabled');
                });

                $('input[name="last_promotion"]' ,here.modal).addClass('bg-white');
                $('input[name="date_hired"]'     ,here.modal).addClass('bg-white');
                $('.account-information'    ,this.modal).attr('hidden', true);
                $('.account-information'    ,this.modal).removeAttr('required');
                $('.upload-picture-btn'     ,this.modal).removeAttr('hidden');
                $('.submit-btn').removeAttr('hidden');
            };

            $(this.passwordField).attr("type", "password");
            $(this.togglePassword).html('<i class="fa fa-eye-slash"></i>');
            $(this.confirmPasswordField).attr("type", "password");
            $(this.confirmTogglePassword).html('<i class="fa fa-eye-slash"></i>');
            $(this.employeeForm, this.modal).removeClass('was-validated');
            $(this.modal).modal('show');
        },

        // DELETE OR REMOVE EMPLOYEE DATA
        remove : function (index) {
            Swal.fire({
                title               :   "Are you sure?",
                text                :   "Employee Number: " + this.employeeData[index].employee_no,
                icon                :   "warning",
                showCancelButton    :   !0,
                confirmButtonColor  :   "#28bb4b",
                cancelButtonColor   :   "#f34e4e",
                confirmButtonText   :   "Yes, delete it!",
                customClass: {
                    icon: 'custom-swal-icon' // Apply custom class to the icon
                  }
              }).then(result => {
                  if(result.isConfirmed){
                      this.isLoading = true;
                      $.ajax({
                        type      :   "POST",
                        url       :   route('employee.delete'),
                        data      :   {
                            _token: this.csrfToken,
                            id      :   this.employeeData[index].employee_id,
                            userId  :   this.employeeData[index].user_id
                        },
                      }).then((data) => {
                        Swal.fire({
                                  title               : data.message,
                                  icon                : 'success',
                                  timer               : 1000,
                                  showConfirmButton   : false,
                              });

                        this.getEmployeeData();
                      }).catch(err => {
                        this.isLoading = false;
                        Swal.fire('Delete Failed. Please refresh the page and try again.','error');
                    })
                  }
              });

              $('.custom-swal-icon').css('margin-top', '20px');
        },

        // OPEN FILE PICKER WHEN BUTTON CLICK ON IMAGE
        openFilePicker : function () {
            this.$refs.fileInputHidden.click();
        },

        // PICK A FILE AND CALL THE FILE TO DATA URL TO GET THE SPECIFIC FILE AND GET THE URL
        fileChosen : function (event) {
            this.fileToDataUrl(event, src => this.imageUrl = src)
        },

        // GET THE DATA URL OF THE FILE
        fileToDataUrl : function (event, callback) {
            if (! event.target.files.length) return

            let file = event.target.files[0],
                reader = new FileReader()

            reader.readAsDataURL(file)
            reader.onload = e => callback(e.target.result)
        },

        // FUNCTION TO CLEAR UPLOADED IMAGE
        clearImage: function () {
            this.imageUrl = '';
            this.$refs.fileInputHidden.value = '';
        },

        // FORM ON SUBMIT EITHER STORE | UPDATE EMPLOYEE DATA
        submit : function () {
            // this.isDisabled             =   true;
            const employeeForm              =   $('#employeeForm'     ,this.modal)[0];
            this.current.salaryGrade        =   $('#salary-grade'     ,this.modal).val();
            this.current.dateHired          =   $('#date-hired'       ,this.modal).val();
            this.current.lastPromotion      =   $('#last-promotion'   ,this.modal).val();
            this.current.userImage          =   this.imageUrl;

            // SHOW ERROR WHEN THERE IS NO IMAGE
            if (this.current.userImage === '') {
                Swal.fire({
                    title:              'Image missing!',
                    icon:               'error',
                    timer:              1000,
                    showConfirmButton:  false,
                });
            }

            $(employeeForm).removeClass('was-validated').addClass('was-validated');

            if (employeeForm.checkValidity()) {
                var email          =   this.current.email;
                this.isDisabled    =   true;

                $.ajax({
                    type: "POST",
                    url: route("employee.store"),
                    data: {
                        _token: this.csrfToken,
                        ...this.current
                    },
                }).then((response) => {
                    Swal.fire({
                        title: response.message,
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false,
                    });
                    this.isDisabled = false;
                    $(this.modal).modal('hide');
                    this.getEmployeeData();
                }).catch((error) => {
                    if (error.responseJSON && error.responseJSON.error) {
                        // var errorMessage = error.responseJSON.error;
                        Swal.fire({
                            title: 'Saving Failed!',
                            html: 'Username: <b>' + email + '</b> already exist.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    } else {
                        // Handle other error scenarios
                        // ...
                    }
                });
            }
        },

        // FETCH DATA ON DATABASE AND DISPLAY ON TABLE EMPLOYEE DATA
        getEmployeeData : function () {
            this.isLoading    = true;
            this.isDisabled   = true;
            $('ul.pagination').empty();

            $('input[name="name"]'          ).val(this.searchName);
            $('input[name="status"]'        ).val(this.filter);
            $('input[name="pagination"]'    ).val(this.pagination);
            $('input[name="page"]'          ).val(this.page);

            $.ajax({
                type        :   "GET",
                url         :   route("employee.show"),
                data        :   $('#users-search-form').serializeArray(),
            }).then((response) => {
                var data = JSON.parse(atob(response.users));
                var users = data['data'],
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

                            $('#user-counter').text('Showing ' + data['from'] + ' to ' + data['to'] + ' of ' + data['total'] + ' Account/s');

                        } else {
                            $('.pagination a[href="' + data['first_page_url'] + '"]').trigger('click');
                        }
                    } else {
                        $('#user-counter').text('No Accounts Found!');
                    }


                this.isLoading      = false;
                this.isDisabled     = false;
                this.employeeData   = users;
                this.employeeCount  = response.count ? response.count : '';
                this.newEmployees   = response.newEmployees ? response.newEmployees : '';
                // DONUT CHART
                if ($("#customerOverviewEcommerce").length) {
                    var customerOverviewEcommerceCanvas = $("#customerOverviewEcommerce").get(0).getContext("2d");
                    var customerOverviewEcommerceData = {
                        datasets: [{
                            data: [
                                1,
                                this.newEmployees,
                                1
                            ],
                            backgroundColor: [
                                "#1E3BB3",
                                "#00CDFF",
                                "#00AAB7",
                            ],
                            borderColor: [
                                "#fff",
                                "#fff",
                                "#fff",
                            ],
                        }],

                        // THESE LABELS APPEAR IN THE LEGEND AND IN THE TOOLTIPS WHEN HOVERING DIFFERENT ARCS
                        labels: [
                            'Resigned Employee',
                            'New Employee',
                            'OJT',
                        ]
                    };
                    var customerOverviewEcommerceOptions = {
                        cutoutPercentage          :   60,
                        animationEasing           :   "easeOutBounce",
                        animateRotate             :   true,
                        animateScale              :   true,
                        responsive                :   false,
                        maintainAspectRatio       :   true,
                        showScale                 :   true,
                        legend                    :   false,
                        legendCallback    : function (chart) {
                            var text = [];
                            text.push('<div class="chartjs-legend"><ul>');
                            for (var i = 0; i < chart.data.datasets[0].data.length; i++) {
                                text.push('<li><span style="background-color:' + chart.data.datasets[0].backgroundColor[i] + '">');
                                text.push('</span>');

                                if (chart.data.labels[i]) {
                                    text.push(chart.data.labels[i]);
                                }
                                text.push('</li>');
                            }
                            text.push('</div></ul>');
                            return text.join("");
                        },

                    layout: {
                        padding : {
                            left      :   0,
                            right     :   0,
                            top       :   0,
                            bottom    :   0
                        }
                    },
                    tooltips: {
                        callbacks: {
                            title: function(tooltipItem, data) {
                                return data['labels'][tooltipItem[0]['index']];
                            },
                            label: function(tooltipItem, data) {
                                return data['datasets'][0]['data'][tooltipItem['index']];
                            }
                        },

                        backgroundColor     :   '#fff',
                        titleFontSize       :   14,
                        titleFontColor      :   '#0B0F32',
                        bodyFontColor       :   '#737F8B',
                        bodyFontSize        :   11,
                        displayColors       :   false
                    }
                    };
                    var customerOverviewEcommerce = new Chart(customerOverviewEcommerceCanvas, {
                        type          :   'doughnut',
                        data          :   customerOverviewEcommerceData,
                        options       :   customerOverviewEcommerceOptions
                    });
                    document.getElementById('customerOverviewEcommerce-legend').innerHTML = customerOverviewEcommerce.generateLegend();
                }
            }).catch((error) => {

            })
        },

        // PAGINATION PAGE ON THE TABLE EMPLOYEE DATA
        paginationPage : function () {
            var component = this;

            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];

                component.page = page;

                // Call the getEmployeeData method using the component reference
                component.getEmployeeData();
            });
        },

        // FRONT END VALIDATION ON CONFIRM PASSWORD EMPLOYEE DATA
        validatePasswordConfirmation : function () {
            if (this.current.confirmPassword !== '' && this.current.password !== this.current.confirmPassword) {
                // Show the error message
                this.$refs.errorMessage.style.display = 'block';
                this.isDisabled = true;
            } else {
                // Hide the error message
                this.$refs.errorMessage.style.display = 'none';
                this.isDisabled = false;
            }
        },

        // SEARCH SPECIFIC NAME OF EMPLOYEE ON EMPLOYEE TABLE
        inputSearch : function (event) {
            clearTimeout(this.inputTimer);
                if (event.code === 'Enter') {
                    // this.disableInput();
                    this.updateSearchInput();
                    this.triggerSearch();
                } else {
                    this.inputTimer = setTimeout(() => {
                        this.updateSearchInput();
                        this.getEmployeeData();
                    }, 1000);
                }
        },

        // VIEW UPLOADED FILES FOR EACH EMPLOYEE
        viewFiles : function (employeeId) {
            $(this.viewUploadedFileModal).modal({
                backdrop: 'static',
                keyboard: false
            });

            this.getEmployeeFiles(employeeId);
            $(this.viewUploadedFileModal).modal('show');
        },

        // VIEW UPLOADED FILES FOR EACH EMPLOYEE
        closeViewUploadedFilesModal : function () {
            $(this.viewUploadedFileModal).modal('hide');
        },

        // UPLOAD FILE FOR EACH EMPLOYEE
        uploadFile : function (employeeId, employeeToken) {
            $(this.fileUploadModal).modal({
                backdrop: 'static',
                keyboard: false
            });

            const inputElement = document.querySelector('input[type="file"]');
            this.pond = FilePond.create(inputElement, { // INITIALIZE FILEPOND
                allowMultiple: true,
                server: {
                    process: {
                        url                :   route("file.store", employeeToken),
                        method             :   "POST",
                        withCredentials    :   false,
                        headers: {
                            'X-CSRF-TOKEN' : this.csrfToken
                        },
                        timeout: 7000,
                        onload: (response) => {
                            // Handle a successful upload
                        },
                        onerror: (response) => {
                            // Handle an error during upload
                        },
                    },
                    revert: {
                        url                 :   route("file.delete"),
                        method              :   "DELETE",
                        headers: {
                            'X-CSRF-TOKEN'  :   this.csrfToken
                        },
                    }
                },
            });

            // EVENT LISTENER FOR ADD FILE THEN STORE IT ON THE DATABASE
            this.pond.on('processfile', (error, file) => {
                const data = new FormData();
                    data.append('employee_id', employeeId);
                    data.append('file_id', file.id);
                    data.append('employee_token', employeeToken);
                    data.append('filepond[]', file.file);

                // Send the file data to your server
                $.ajax({
                    url: route("file.upload"),
                    method: "POST",
                    data: data,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken
                    },
                    success: (response) => {
                        Swal.fire({
                            title: response.message,
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    },
                    error: (response) => {
                        // Handle an error during upload
                    },
                });
            });

            // EVENT LISTENER FOR REMOVE FILE ON THE FILE POND SAME ON BOTH DATABASE AND FILE DIRECTORY
            this.pond.on('removefile', (error, file) => {
                $.ajax({
                    url: route("file.revert"),
                    method: "POST",
                    data: {
                        file_id     : file.id,
                        employee_id : employeeId
                    },
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken
                    },
                    success: (response) => {
                        // Handle success (e.g., display a message to the user)
                    },
                    error: (error) => {
                        // Handle error (e.g., display an error message)
                        console.error('Error deleting file:', error);
                    }
                });
            });

            $(this.fileUploadModal).modal('show');
        },

        // ON CLOSE FILE UPLOAD MODAL STOP POND TO REINITIALIZE
        closeFileUploadModal : function () {
            if(this.pond) {
                this.pond.destroy();
                this.pond = null;
            }

            $(this.fileUploadModal).modal('hide');
        },

        // TRIGGER SEARCH WHEN THE BUTTON WHEN CLICK ENTER
        triggerSearch : function () {
            this.$refs.usersSearchButton.click();
        },

        // UPDATE NAME VALUE OF THE NAME
        updateSearchInput : function () {
            this.$refs.nameInput.value = this.searchName;
        },

        // SEE PASSWORD ON ADMIN SIDE
        seePassword : function (type) {
            if (type === 'password') {
                if ($(this.passwordField).attr("type") === "password") {
                    $(this.passwordField).attr("type", "text");
                    $(this.togglePassword).html('<i class="fa fa-eye"></i>');
                } else {
                    $(this.passwordField).attr("type", "password");
                    $(this.togglePassword).html('<i class="fa fa-eye-slash"></i>');
                }
            } else if (type === 'confirmPassword') {
                if ($(this.confirmPasswordField).attr("type") === "password") {
                    $(this.confirmPasswordField).attr("type", "text");
                    $(this.confirmTogglePassword).html('<i class="fa fa-eye"></i>');
                } else {
                    $(this.confirmPasswordField).attr("type", "password");
                    $(this.confirmTogglePassword).html('<i class="fa fa-eye-slash"></i>');
                }
            }

        },

        // FOR DATE AND TIME SHOW (USER/EMPLOYEE VIEW)
        startClock: function () {
            this.timeLoading = true;
            setInterval(() => {
                const now = new Date();

                // GET THE CURRENT TIME IN 12-HOUR FORMAT WITH AM/PM
                const options = {
                    hour    :   'numeric',
                    minute  :   'numeric',
                    second  :   'numeric',
                    hour12  :   true, // Use 12-hour format
                };

                this.currentDate = now.toISOString().slice(0, 10);
                this.currentTime = now.toLocaleTimeString(undefined, options); // FORMAT TIME

                // // DEFINE THE START AND END TIME FOR THE RANGE (12:00 PM TO 1:00 PM)
                // const startTime  =  '12:00:00 PM';
                // const endTime    =  '1:00:00 PM';

                // // CHECK IF THE CURRENT TIME IS WITHIN THE SPECIFIED RANGE
                // if (this.currentTime >= startTime && this.currentTime <= endTime) {
                //     // ENABLE THE "BREAK OUT" BUTTON
                //     $('.break-out').prop('disabled', false);
                // } else {
                //     // DISABLE THE "BREAK OUT" BUTTON
                //     $('.break-out').prop('disabled', true);
                // }

                this.timeLoading = false;
            }, 1000);
        },

        // CREATE LEAVE REQUEST (USER/EMPLOYEE VIEW)
        createRequest : function () {
            $('#leave-date', this.leaveModal).datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            });

            $(this.leaveModal).modal({
                backdrop: 'static',
                keyboard: false
                });

            $('input[name="leave_date"]', this.leaveModal).addClass('bg-white');
            $('.hr-note', this.leaveModal).attr('hidden', true);
            $('.submit-btn', this.leaveModal).removeAttr('hidden');
            $(this.leaveReqForm)[0].reset();
            $(this.leaveReqForm, this.leaveModal).removeClass('was-validated');
            $(this.leaveModal).modal('show');
        },

        // EDIT LEAVE REQUEST (USER/EMPLOYEE VIEW)
        editLeaveRequest : function (index) {
            $(this.leaveModal).modal({
                backdrop: 'static',
                keyboard: false
                });

            this.currentLeave    =   {
                leaveRecordId   :   this.leaveData[index].id            ? this.leaveData[index].id              :   '',
                leaveDate       :   this.leaveData[index].leave_date    ? this.leaveData[index].leave_date      :   '',
                leaveType       :   this.leaveData[index].leave_type    ? this.leaveData[index].leave_type      :   '',
                dayType         :   this.leaveData[index].day_type      ? this.leaveData[index].day_type        :   '',
                reason          :   this.leaveData[index].reason        ? this.leaveData[index].reason          :   '',
            };

            this.reasonDecline  =   this.leaveData[index].decline_reason ? this.leaveData[index].decline_reason : '';

            if (!this.leaveData[index].decline_reason) {
                $('.hr-note', this.leaveModal).attr('hidden', true);
            } else {
                $('.hr-note', this.leaveModal).removeAttr('hidden');
            }

            if (this.leaveData[index].status != 'Pending') {
                $('.submit-btn', this.leaveModal).attr('hidden', true);
                $('.leave-form-modal', this.leaveModal).attr('disabled', true);
                $('input[name="leave_date"]', this.leaveModal).removeClass('bg-white');
            } else {
                $('.submit-btn', this.leaveModal).removeAttr('hidden');
                $('.leave-form-modal', this.leaveModal).removeAttr('disabled');
                $('input[name="leave_date"]', this.leaveModal).addClass('bg-white');
            }

            $(this.leaveReqForm, this.leaveModal).removeClass('was-validated');
            $(this.leaveModal).modal('show');
        },

        // REMOVE LEAVE REQUEST (USER/EMPLOYEE VIEW)
        removeLeaveRequest : function (index) {
            const customMessage = this.leaveData[index].status != 'Pending' ? 'Delete ' : 'Cancel ';

            Swal.fire({
                title               :   "Are you sure?",
                html                :   customMessage + "this leave request : <b>" + this.leaveData[index].leave_type + "</b>",
                icon                :   "warning",
                showCancelButton    :   !0,
                confirmButtonColor  :   "#28bb4b",
                cancelButtonColor   :   "#f34e4e",
                confirmButtonText   :   "Yes, " + customMessage + "it!",
                cancelButtonText    :   "Close",
                customClass: {
                    icon: 'custom-swal-icon' // Apply custom class to the icon
                  }
              }).then(result => {
                  if(result.isConfirmed){
                      this.isLoading = true;
                      $.ajax({
                        type      :   "POST",
                        url       :   route('leave.delete'),
                        data      :   {
                            _token: this.csrfToken,
                            id: this.leaveData[index].id,
                        },
                      }).then((data) => {
                        Swal.fire({
                                  title               : data.message,
                                  icon                : 'success',
                                  timer               : 1000,
                                  showConfirmButton   : false,
                              });

                        this.getLeaveRequest();
                      }).catch(err => {
                        this.isLoading = false;
                        Swal.fire('Delete Failed. Please refresh the page and try again.','error');
                    })
                  }
              });

              $('.custom-swal-icon').css('margin-top', '20px');
        },

        // REMOVE SPECIFIC FILE OF EMPLOYEE (USER/EMPLOYEE VIEW)
        removeEmployeeFile : function (data) {
            const file_id   = data.file_unique_id      ?  data.file_unique_id       :   '';
            const user_id   = data.employee_id         ?  data.employee_id          :   '';
            const file_name = data.file_name           ?  data.file_name            :   '';
            const text      = 'File Name: <b>' + file_name + '</b>';
            Swal.fire({
                title               :   "Are you sure?",
                html                :   text,
                icon                :   "warning",
                showCancelButton    :   !0,
                confirmButtonColor  :   "#28bb4b",
                cancelButtonColor   :   "#f34e4e",
                confirmButtonText   :   "Yes, delete it!",
                customClass: {
                    icon: 'remove-file-swal-icon' // Apply custom class to the icon
                  }
              }).then(result => {
                  if(result.isConfirmed){
                      this.removeFileIsLoading = true;
                      $.ajax({
                        type      :   "POST",
                        url       :   route('file.revert'),
                        data      :   {
                            _token        :   this.csrfToken,
                            file_id       :   file_id,
                            employee_id   :   user_id
                        },
                      }).then((data) => {
                        Swal.fire({
                                  title               : data.message,
                                  icon                : 'success',
                                  timer               : 1000,
                                  showConfirmButton   : false,
                              });

                        this.getEmployeeFiles(user_id);
                      }).catch(err => {
                        this.removeFileIsLoading = false;
                        Swal.fire('Delete Failed. Please refresh the page and try again.','error');
                    })
                  }
              });

              $('.remove-file-swal-icon').css('margin-top', '20px');
        },

        // ON SUBMIT FORM LEAVE REQUEST (USER/EMPLOYEE VIEW)
        submitRequest : function () {
            const leaveRequestForm = $('#leaveRequestForm', this.leaveModal)[0];
            $(leaveRequestForm).removeClass('was-validated').addClass('was-validated');
            this.currentLeave.leaveDate = $('input[name="leave_date"]').val();

            if (leaveRequestForm.checkValidity()) {
                $.ajax({
                    type: "POST",
                    url: route("leave.store"),
                    data: {
                        _token: this.csrfToken,
                        ...this.currentLeave
                    },
                }).then((response) => {
                    Swal.fire({
                        title: response.message,
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false,
                    });
                    this.getLeaveRequest();
                    $('#leave-date', this.leaveModal).datepicker("destroy");
                    $(this.leaveModal).modal('hide');
                }).catch((error) => {

                });
            }
        },

        // GET EMPLOYEE LEAVE REQUEST (USER/EMPLOYEE VIEW)
        getLeaveRequest : function () {
            this.leaveIsLoading = true;

            $.ajax({
                type        :   "GET",
                url         :   route("leave.show"),
                data        :   $('#users-search-form').serializeArray(),
            }).then((response) => {
                this.overAllLeaveCount      =   response.overAll;
                this.leaveData              =   response.data;
                this.leaveCount             =   response.count;
                this.leaveIsLoading         =   false;

            }).catch((error) => {

            })
        },

        // GET EMPLOYEE FILES (USER/EMPLOYEE VIEW)
        getEmployeeFiles : function (employeeId) {
            this.fileFetchLoading = true;
            $.ajax({
                type        :   "GET",
                url         :   route("file.show"),
                data        :   {
                    employeeId : employeeId
                },
            }).then((response) => {
                this.employeeFiles          =   response.files;
                this.fileFetchLoading       =   false;

            }).catch((error) => {

            })
        },

        // CONVERT 12 HOUR FORMAT TO 24 HOUR FORMAT (USER/EMPLOYEE VIEW)
        convert24hrTo12hr : function(time) {
            // Assuming timeData is in the format "HH:mm:ss"
            const [hours, minutes, seconds] = time.split(':').map(Number);

            // Create a Date object and set hours, minutes, and seconds
            const date = new Date();
            date.setHours(hours);
            date.setMinutes(minutes);
            date.setSeconds(seconds);

            // Format as 12-hour time with AM/PM
            const formattedTime = date.toLocaleString('en-US', {
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true,
            });

            return formattedTime;
        },

        // WEB BUNDY FUNCTION FOR EACH EMPLOYEE (CLOCK IN, BREAK OUT, BREAK IN, CLOCK OUT) (USER/EMPLOYEE VIEW)
        webBundyFunction : function (userId, type) {
            let time = this.currentTime;
            this.webBundyLoading            =   true;
            this.loadGetEmployeeAttendance  =   true;
            switch (type) {
                case 'clock-in' :
                    this.processWebBundy(type, time, userId);
                break;
                case 'break-out' :
                    this.processWebBundy(type, time, userId);
                break;
                case 'break-in' :
                    this.processWebBundy(type, time, userId);
                break;
                case 'clock-out' :
                    this.processWebBundy(type, time, userId);
                break;
            }
        },

        // ALL AJAX REQUEST FOR SENDING TO ATTENDANCE CONTROLLER (USER/EMPLOYEE VIEW)
        processWebBundy : function (type, time, userId) {
            $.ajax({
                type    :   "POST",
                url     :   route("attendance.store"),
                headers: {
                    'X-CSRF-TOKEN' : this.csrfToken
                },
                data    : {
                    time        : time,
                    type        : type,
                    user_id     : userId
                },
            }).then((response) => {
                Swal.fire({
                    title                   :   response.message,
                    icon                    :   'success',
                    timer                   :   1000,
                    showConfirmButton       :   false,
                    allowEscapeKey          :   false,
                    allowOutsideClick       :   false,
                });
                this.dailyAttendance();
            }).catch((error) => {
                if (error.responseJSON && error.responseJSON.error) {

                } else {
                    // Handle other error scenarios
                    // ...
                }
            });
        },

        // EMPLOYEE DAILY ATTENDANCE (USER/EMPLOYEE VIEW)
        dailyAttendance : function () {
            $.ajax({
                type    :   "GET",
                url     :   route("attendance.daily"),
                headers :   {
                    'X-CSRF-TOKEN' : this.csrfToken
                }
            }).then((response) => {
                const data = response.dailyAttendance ? response.dailyAttendance : '';
                this.employeeAttendance = {
                    clockIn     :   data.clock_in   ?  data.clock_in    :   '',
                    breakOut    :   data.break_out  ?  data.break_out   :   '',
                    breakIn     :   data.break_in   ?  data.break_in    :   '',
                    clockOut    :   data.clock_out  ?  data.clock_out   :   '',
                };

                this.clockInBtn         = false;
                this.breakOutBtn        = false;
                this.breakInBtn         = false;
                this.clockOutBtn        = false;
                this.webBundyLoading    = false;

                switch (true) {
                    case !this.employeeAttendance.clockIn:
                        this.clockInBtn = true;
                        break;
                    case this.employeeAttendance.clockIn && !this.employeeAttendance.breakOut:
                        this.breakOutBtn = true;
                        break;
                    case this.employeeAttendance.clockIn && this.employeeAttendance.breakOut && !this.employeeAttendance.breakIn:
                        this.breakInBtn = true;
                        break;
                    case this.employeeAttendance.clockIn && this.employeeAttendance.breakOut && this.employeeAttendance.breakIn && !this.employeeAttendance.clockOut:
                        this.clockOutBtn = true;
                        break;
                }
                if (this.loadGetEmployeeAttendance) {
                    this.getEmployeeAttendance();
                }
            }).catch((error) => {
                if (error.responseJSON && error.responseJSON.error) {

                } else {
                    // Handle other error scenarios
                    // ...
                }
            });
        },

        // EMPLOYEE ATTENDANCE (USER/EMPLOYEE VIEW)
        getEmployeeAttendance : function (date = null) {
            this.attendanceMonitoringLoading = true;
            let requestDate = date != null ? date : this.dateToday;
            $.ajax({
                type        : "GET",
                url         : route("attendance.record"),
                headers     : {
                    'X-CSRF-TOKEN' : this.csrfToken
                },
                data        : {
                    date : requestDate
                }
            }).then((response) => {
                this.attendanceMonitoringLoading    = false;
                this.fetchAttendance                = response.attendance ? response.attendance : [];
                if (this.fetchAttendance.length > 0) {
                    const attendance = this.fetchAttendance[0];
                    attendance.clock_in     = attendance.clock_in   ? this.convert24hrTo12hr(attendance.clock_in)   : '';
                    attendance.break_out    = attendance.break_out  ? this.convert24hrTo12hr(attendance.break_out)  : '';
                    attendance.break_in     = attendance.break_in   ? this.convert24hrTo12hr(attendance.break_in)   : '';
                    attendance.clock_out    = attendance.clock_out  ? this.convert24hrTo12hr(attendance.clock_out)  : '';
                }

            }).catch((error) => {
                if (error.responseJSON && error.responseJSON.error) {

                } else {
                    // Handle other error scenarios
                    // ...
                }
            });
        },

        // GET ALL FETCH TO LOAD IN DOM ONCE
        getAllInitialization : function () {
            if (this.userRole != 1) {
                this.getLeaveRequest();
                this.dailyAttendance();
                this.getEmployeeAttendance();
                this.startClock();
            }
        },

        // DISPATCH EMPLOYEE DATA. USING CUSTOM EVENT SO THE DATA WILL LOAD ONLY AFTER OPENING THE TAB
        dispatchCustomEvent : function () {
            event.target.dispatchEvent(new CustomEvent ('loademployeedata',
                {
                    bubbles : true
                }
            ));
        },

        // EMPLOYEE TAB DATA FETCH INITIALIZATION
        getEmployeeInit : function () {
            if (!this.indication) { // PUT INDICATION TO AVOID INITIALIZE EVERYTIME THE USER CLICK'S ON THE EMPLOYEE TAB
                this.getEmployeeData();
                this.paginationPage();
                this.indication = true;
            }
        }
    }
}
