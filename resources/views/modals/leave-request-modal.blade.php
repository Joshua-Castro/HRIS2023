<div class="modal fade" id="request-leave-modal" tabindex="-1" role="dialog" aria-labelledby="createEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="" method="POST" id="leaveRequestForm" class="needs-validation">
            @csrf
            <div class="modal-body">
                <h4 class="header-title mb-2">Leave Request</h4>
                <div class="row g-0 pt-2">
                    <div class="col-12 col-md-12">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="leave_date" class="form-control bg-white leave-form-modal" id="leave-date" placeholder="Leave Date" x-model="currentLeave.leaveDate" required data-inputmask-placeholder="YYYY-MM-DD" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy-mm-dd">
                                    <label for="last_name">Leave Date<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <select class="form-select leave-form-modal" name="leave_type" x-model="currentLeave.leaveType" required>
                                        <option value="">Select</option>
                                        <option value="Emergency/Sick Leave">Emergency/Sick Leave</option>
                                        <option value="Parental Leave">Parental Leave</option>
                                        <option value="Paternity Leave">Paternity Leave</option>
                                        <option value="Vacation Leave">Vacation Leave</option>
                                        <option value="Birthday Leave">Birthday Leave</option>
                                    </select>
                                    <label for="leave_type">Leave Type</label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <select class="form-select leave-form-modal" name="day_type" x-model="currentLeave.dayType" required>
                                        <option value="">Select</option>
                                        <option value="Whole Day">Whole Day</option>
                                        <option value="Half Day">Half Day</option>
                                    </select>
                                    <label for="day_type">Day Type</label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <textarea name="reason" class="form-control leave-form-modal" placeholder="Reason" required style="height: 100px;" x-model="currentLeave.reason"></textarea>
                                    <label for="reason">Reason<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-note" hidden>
                    <h4 class="header-title mb-2 mt-4">HR Note :</h4>
                    <div class="row g-0 pt-2">
                        <span class="text-center text-primary" x-text="reasonDecline"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-outline-primary submit-btn" @click="submitRequest">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>
