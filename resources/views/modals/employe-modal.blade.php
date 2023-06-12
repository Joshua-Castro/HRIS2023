<div class="modal fade" id="employee-modal" tabindex="-1" role="dialog" aria-labelledby="createEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        {{-- <div class="modal-header justify-content-center">
            <h4 class="modal-title" id="createEmployeeModalLabel">ADD EMPLOYEE</h4>
        </div> --}}
        <form action="" method="POST" id="employeeForm" class="needs-validation">
            @csrf
            <div class="modal-body">
                <h4 class="header-title mb-2">Employee Information</h4>
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name" x-model="current.lastName" required>
                                    <label for="last_name">Last Name<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="first_name" class="form-control" placeholder="First Name" x-model="current.firstName" required>
                                    <label for="first_name">First Name<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="middle_name" class="form-control" placeholder="Middle Name (Optional)" x-model="current.middleName">
                                    <label for="middle_name">Middle Name (Optional)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="gender" class="form-control" placeholder="Gender" x-model="current.gender">
                                    <label for="gender">Gender</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-12">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="maiden_name" class="form-control" placeholder="Maiden Name" x-model="current.maidenName">
                                    <label for="maiden_name">Maiden Name</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-12 col-md-4">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="position" class="form-control" placeholder="Position" x-model="current.position" required>
                                    <label for="position">Position<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="last_promotion" class="form-control" placeholder="Last Promotion" x-model="current.lastPromotion" required>
                                    <label for="last_promotion">Last Promotion<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="station_code" class="form-control" placeholder="Station Code" x-model="current.stationCode" required>
                                    <label for="station_code">Station Code<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-12 col-md-3">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="control_number" class="form-control" placeholder="Control Number" x-model="current.controlNumber" required>
                                    <label for="control_number">Control Number<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="employee_number" class="form-control" placeholder="Employee Number" x-model="current.employeeNumber" required>
                                    <label for="employee_number">Employee Number<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="school_code" class="form-control" placeholder="School Code/Name" x-model="current.schoolCode" required>
                                    <label for="school_code">School Code/Name<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="item_number" class="form-control" placeholder="Item Number" x-model="current.itemNumber" required>
                                    <label for="item_number">Item Number<span class="text-danger"> *</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1 mb-4">
                    <div class="col-12 col-md-4">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="employment_status" class="form-control" placeholder="Employment Status" x-model="current.employeeStatus" required>
                                    <label for="employment_status">Employment Status<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="salary_grade" class="form-control" placeholder="Salary Grade/Step" x-model="current.salaryGrade" required>
                                    <label for="salary_grade">Salary Grade/Step<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="date_hired" class="form-control" placeholder="Date Hired" x-model="current.dateHired" required>
                                    <label for="date_hired">Date Hired<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="header-title mb-2">Benefits Information</h4>
                <div class="row mt-1 mb-4">
                    <div class="col-12 col-md-4">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="sss_benefits" class="form-control" placeholder="SSS" x-model="current.sss" required>
                                    <label for="sss_benefits">SSS<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="pagibig_benefits" class="form-control" placeholder="Pag-IBIG" x-model="current.pagIbig" required>
                                    <label for="pagibig_benefits">Pag-IBIG<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="phil_health_benefits" class="form-control" placeholder="PhilHealth" x-model="current.philHealth" required>
                                    <label for="phil_health_benefits">PhilHealth<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="header-title mb-2">Account Information</h4>
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf
                    <div class="row mt-1 mb-4">
                        <div class="col-12 col-md-6">
                            <div class="form-group row p-1 m-0" >
                                <div class="col-sm-12 p-0 m-0">
                                    <div class="form-floating">
                                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Username" required autocomplete="email">
                                        <label for="email">Username<span class="text-danger"> *</span></label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group row p-1 m-0" >
                                <div class="col-sm-12 p-0 m-0">
                                    <div class="form-floating">
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" autocomplete="new-password" required>
                                        <label for="password">Password<span class="text-danger"> *</span></label>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-outline-primary submit-btn" @click="submit">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>