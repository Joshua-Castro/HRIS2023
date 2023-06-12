// $(function () {
//     var EMPLOYEE_MODAL      =   $('#createEmployeeModal');
//     var EMPLOYEE_FORM       =   $('#employeeForm')[0];
//     var LOADER              =   null;
//     var EMPLOYEE_RECORD_ID  =   0;
//     // INITIALIZE EMPLOYEE DATA AND DISPLAY ON TABLE
//     getEmployeeData();
//     // LOADING FUNCTIONALITY WHEN SENDING REQUEST TO BACKEND
//     function loading(message) {
//         LOADER = Swal.fire({
//             title               :   'Please wait...',
//             text                :   message,
//             allowEscapeKey      :   false,
//             allowOutsideClick   :   false,
//             didOpen             :   ()  =>  {
//                 Swal.showLoading();
//                 // Add overlay to prevent interactions with background elements
//                 Swal.getContainer().classList.add('swal-overlay');
//             },
//             willClose: () => {
//               // Remove overlay when Swal modal is closed
//               Swal.getContainer().classList.remove('swal-overlay');
//             },
//         });
//     };
//     // CREATE EMPLOYEE
//     $('.employee-btn').on('click', function() {
//         $(EMPLOYEE_FORM).removeClass('was-validated');
//         EMPLOYEE_MODAL.modal({
//             backdrop: 'static',
//             keyboard: false
//             });
//         EMPLOYEE_FORM.reset();
//         EMPLOYEE_MODAL.modal('show');
//     });
//     // EDIT | VIEW | DELETE
//     $(document).on('click', '.action-btn', function() {
//         const action = $(this).data('action');
//         const id     = $(this).data('id');
//         if (action == 'edit') {
//         }
//     }); 
//     // EMPLOYEE FORM ON SUBMIT
//     $('.submit-btn').on('click', function(e) {
//         e.preventDefault();
//         $(EMPLOYEE_FORM).removeClass('was-validated').addClass('was-validated');
//         if (EMPLOYEE_FORM.checkValidity()) {
//             $.ajax({
//                 type        :   "POST",
//                 url         :   route("employee.store"),
//                 data        :   $(EMPLOYEE_FORM).serialize(),
//                 dataType    :   "json",
//                 beforeSend  :   function () {
//                     loading('Saving Data');
//                 },
//             }).then((response) => {
//                 Swal.fire({
//                     title               : response.message,
//                     icon                : 'success',
//                     timer               : 1000,
//                     showConfirmButton   : false,
//                 });
//                 getEmployeeData();
//                 LOADER.close();
//                 EMPLOYEE_MODAL.modal('hide');
//             }).catch((error) => {
//                 console.log(error);
//                 console.log(error.message);
//             });
//         }
//     });
//     function getEmployeeData() {
//         $.ajax({
//             type        :   "GET",
//             url         :   route("employee.show"),
//         }).then((response) => {
//             var employeeData = response.data;
//             var row = '';
//             if (!employeeData.length > 0) {
//                 row += '<tr>';
//                 row += '<td class="text-center" colspan="6">';
//                 row += '<p class="text-muted text-small">NO DATA AVAILABLE</p>';
//                 row += '</td>';
//                 row += '</tr>';
//             } else {
//                 $.each(employeeData, function(index, employee) {
//                     row += '<tr>';
//                     row += '<td>';
//                     row += '<div class="d-flex align-items-center">';
//                     row += '<div>';
//                     row += '<p class="dark-text fs-14 fw-bold mb-0 pb-0">' + employee['first_name'] + ' ' + employee['middle_name'] + ' ' + employee['middle_name'] +'</p>';
//                     row += '<p class="text-muted text-small">' + employee['position'] + '</p>';
//                     row += '</div>';
//                     row += '</div>';
//                     row += '</td>';
//                     row += '<td><p class="dark-text fs-14">' + employee['employee_no'] + '</p></td>';
//                     row += '<td><p class="dark-text fs-14">' + employee['station_code'] + '</p></td>';
//                     row += '<td><p class="dark-text fs-14">' + employee['employment_status'] + '</p></td>';
//                     row += '<td><p class="dark-text fs-14">' + employee['school_code'] + '</p></td>';
//                     row += '<td class="text-center">';
//                     row += '<button type="button" class="btn btn-sm action-btn btn-outline-info" data-id="'+ employee['id'] +'" data-action="edit">Edit</button>';
//                     row += '<button type="button" class="btn btn-sm action-btn btn-outline-primary" data-id="'+ employee['id'] +'" data-action="view">View</button>';
//                     row += '<button type="button" class="btn btn-sm action-btn btn-outline-warning" data-id="'+ employee['id'] +'" data-action="delete">Delete</button>';
//                     row += '</td>';
//                     row += '</tr>';
//                 })
//             }
//             $('.employee-table').html(row);
//         }).catch((error) => {
//             console.log(error);
//             console.log(error.message);
//         });
//     };
// });

function adminDashboard() {
    return {
        // PROPERTIES
        employeeData    :   [],
        current         :   {
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
        },

        disableFields       : [
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
            'phil_health_benefits'
          ],

        employeeCount   :   0,   
        isLoading       :   false,
        isDisabled      :   false,
        modal           :   '#employee-modal',
        employeeForm    :   '#employeeForm',
        csrfToken       :   $('meta[name="csrf-token"]').attr('content'),


        // METHODS
        init() {
            this.getEmployeeData();
        },

        // CREATE FUNCTION
        create : function () {
            $(this.modal).modal({
                        backdrop: 'static',
                        keyboard: false
                        });
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
            };

            this.disableFields.forEach(function(field) {
                $('input[name="' + field + '"]', this.modal).removeAttr('disabled');
            });
    
            $('.submit-btn').removeAttr('hidden');

            $(this.employeeForm)[0].reset();
            $(this.employeeForm, this.modal).removeClass('was-validated');
            $(this.modal).modal('show');
        },

        // EDIT | VIEW FUNCTION
        edit : function (index, type) {
            $(this.modal).modal({
                backdrop: 'static',
                keyboard: false
                });
            this.current    =  {
                recordId        :   this.employeeData[index].id,
                lastName        :   this.employeeData[index].last_name,
                firstName       :   this.employeeData[index].first_name,
                middleName      :   this.employeeData[index].middle_name,
                gender          :   this.employeeData[index].gender,
                maidenName      :   this.employeeData[index].maiden_name,
                position        :   this.employeeData[index].position,
                lastPromotion   :   this.employeeData[index].last_promotion,
                stationCode     :   this.employeeData[index].station_code,
                controlNumber   :   this.employeeData[index].control_no,
                employeeNumber  :   this.employeeData[index].employee_no,
                schoolCode      :   this.employeeData[index].school_code,
                itemNumber      :   this.employeeData[index].item_number,
                employeeStatus  :   this.employeeData[index].employment_status,
                salaryGrade     :   this.employeeData[index].salary_grade,
                dateHired       :   this.employeeData[index].date_hired,
                sss             :   this.employeeData[index].sss,
                pagIbig         :   this.employeeData[index].pag_ibig,
                philHealth      :   this.employeeData[index].phil_health,
            };

            // DISABLE FIELDS WHEN USER WANTS ONLY VIEW FUNCTIONALITIES
            // const disableFields = [
            //     'last_name',
            //     'first_name',
            //     'middle_name',
            //     'gender',
            //     'maiden_name',
            //     'position',
            //     'last_promotion',
            //     'station_code',
            //     'control_number',
            //     'employee_number',
            //     'school_code',
            //     'item_number',
            //     'employment_status',
            //     'salary_grade',
            //     'date_hired',
            //     'sss_benefits',
            //     'pagibig_benefits',
            //     'phil_health_benefits'
            //   ];

            if (type === 'view') {
                this.disableFields.forEach(function(field) {
                    $('input[name="' + field + '"]', this.modal).attr('disabled', true);
                });
        
                $('.submit-btn').attr('hidden', true);
            } else {
                this.disableFields.forEach(function(field) {
                    $('input[name="' + field + '"]', this.modal).removeAttr('disabled');
                });
        
                $('.submit-btn').removeAttr('hidden');
            };

          $(this.employeeForm, this.modal).removeClass('was-validated');
          $(this.modal).modal('show');
        },

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
                            id: this.employeeData[index].id 
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
        

        // FORM ON SUBMIT EITHER STORE | UPDATE
        submit : function () {
            const employeeForm = $('#employeeForm', this.modal)[0];
            $(employeeForm).removeClass('was-validated').addClass('was-validated');

            if (employeeForm.checkValidity()) {
                this.isDisabled = true;

                $.ajax({
                    type        :   "POST",
                    url         :   route("employee.store"),
                    data        :   {
                        _token: this.csrfToken, // Include the CSRF token
                        ...this.current // Include your form data
                    }
                    // beforeSend  :   function () {
                    // },
                }).then((response) => {
                    Swal.fire({
                        title               : response.message,
                        icon                : 'success',
                        timer               : 1000,
                        showConfirmButton   : false,
                    });
                    this.isDisabled = true;
                    $(this.modal).modal('hide');
                    this.getEmployeeData();
                }).catch((error) => {
                    console.log(error);
                    console.log(error.message);
                });
            }
        },

        // FETCH DATA ON DATABASE AND DISPLAY ON TABLE
        getEmployeeData : function () {
            this.isLoading    = true;
            $('ul.pagination').empty();
            
            $.ajax({
                type        :   "GET",
                url         :   route("employee.show"),
                data        :   $('#users-search-form').serializeArray(),
            }).then((response) => {
                this.isLoading    = false;
                this.employeeData   = response.data;
                this.employeeCount  = response.count;
            }).catch((error) => {
                console.log(error);
                console.log(error.message);
            })
        },
    }
}