<div class="modal fade" id="employee-modal" tabindex="-1" role="dialog" aria-labelledby="createEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form action="" method="POST" id="employeeForm" class="needs-validation" enctype="multipart/form-data">
            @csrf
        {{-- <div class="modal-header justify-content-center">
            <h4 class="modal-title" id="createEmployeeModalLabel">ADD EMPLOYEE</h4>
        </div> --}}
            <div class="row mt-2">
                <div class="col-md-12 col-lg-4 mt-2 align-item-center vertical-align-middle">
                    <div class="profile-card">
                        {{-- <div class="circle"> --}}
                            <img x-bind:src="imageUrl" class="circle">
                        {{-- </div> --}}
                        <div class="row" style="margin-top: 100px;">
                            <div class="col-12 col-md-12 mt-2">
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
                            <div class="col-12 col-md-12 mt-2">
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
                            <div class="col-12 col-md-12 mt-2">
                                <div class="form-group row p-1 m-0" >
                                    <div class="col-sm-12 p-0 m-0">
                                        <div class="form-floating">
                                            <input type="text" name="middle_name" class="form-control" placeholder="Middle Name (Optional)" x-model="current.middleName">
                                            <label for="middle_name">Middle Name (Optional)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" @click="clearImage" class="btn btn-danger btn-sm mt-4" :disabled="!imageUrl">Remove Uploaded Picture</button>
                            <input type="file" id="fileInput" x-ref="fileInputHidden" style="display: none;" accept="image/*" @change="fileChosen($event)" />
                            <button type="button" @click="openFilePicker" class="btn btn-success btn-sm mt-4">Upload Profile Picture</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8 mt-2">
                    <div class="modal-body">
                        <h4 class="header-title mb-2 mt-4">Employee Information</h4>
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
                                            <select class="form-select" id="salary-grade" name="salary_grade" x-model="current.salaryGrade" required>
                                                <option value="">Salary Grade</option>
                                                <option value="Grade1">Grade 1</option>
                                                <option value="Grade2">Grade 2</option>
                                                <option value="Grade3">Grade 3</option>
                                                <option value="Grade4">Grade 4</option>
                                                <option value="Grade5">Grade 5</option>
                                                <option value="Grade6">Grade 6</option>
                                                <option value="Grade7">Grade 7</option>
                                                <option value="Grade8">Grade 8</option>
                                                <option value="Grade9">Grade 9</option>
                                                <option value="Grade10">Grade 10</option>
                                                <option value="Grade11">Grade 11</option>
                                                <option value="Grade12">Grade 12</option>
                                                <option value="Grade13">Grade 13</option>
                                                <option value="Grade14">Grade 14</option>
                                                <option value="Grade15">Grade 15</option>
                                            </select>
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
                                            <input type="text" id="date-hired" name="date_hired" class="form-control bg-white" placeholder="Date Hired" x-model="current.dateHired" required>
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
                                            <label for="sss_benefits">GSIS<span class="text-danger"> *</span></label>
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
                        <h4 class="header-title mb-2 account-information">Account Information</h4>
                        <div class="row mt-1 mb-4 account-information">
                            {{-- <div class="col-12 col-md-6">
                                <div class="form-group row p-1 m-0" >
                                    <div class="col-sm-12 p-0 m-0">
                                        <div class="form-floating">
                                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Username" required autocomplete="name" x-model="current.name">
                                            <label for="name">Name<span class="text-danger"> *</span></label>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12 col-md-6">
                                <div class="form-group row p-1 m-0" >
                                    <div class="col-sm-12 p-0 m-0">
                                        <div class="form-floating">
                                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Username" required autocomplete="email" x-model="current.email">
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
                                        <div class="d-flex flex-row form-floating position-relative">
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror real-password" placeholder="Password" autocomplete="new-password" required x-model="current.password">
                                            <label for="password">Password<span class="text-danger"> *</span></label>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <button type="button" class="btn btn-light eye-icon toggle-password" @click="seePassword('password')">
                                                <i class="fa fa-eye-slash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-12 col-md-6">
                                <div class="form-group row p-1 m-0" >
                                    <div class="col-sm-12 p-0 m-0">
                                        <div class="d-flex flex-row form-floating position-relative">
                                            <input type="password" id="password-confirm" name="password_confirmation" class="form-control confirm-password" placeholder="Confirm Password" autocomplete="new-password" required x-model="current.confirmPassword" :input="validatePasswordConfirmation">
                                            <label for="password_confirmation">Confirm Password<span class="text-danger"> *</span></label>
                                            <button type="button" class="btn btn-light eye-icon toggle-confirm-password" @click="seePassword('confirmPassword')">
                                                <i class="fa fa-eye-slash"></i>
                                            </button>
                                        </div>
                                        <span class="invalid-feedback" x-show="current.confirmPassword !== '' && current.password !== current.confirmPassword" x-ref="errorMessage">The passwords are not the same</span>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-outline-primary submit-btn" @click="submit" :disabled="isDisabled">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>
