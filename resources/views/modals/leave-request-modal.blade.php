<div class="modal fade" id="request-leave-modal" tabindex="-1" role="dialog" aria-labelledby="createEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 750px;">
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
                                    <select class="form-select leave-form-modal" name="leave_day" x-model="currentLeave.leaveDay" required @change="changeDateUi">
                                        <option value="">Select</option>
                                        <option value="1">Half Day</option>
                                        <option value="2">Whole Day</option>
                                        <option value="3">1 or more day/s</option>
                                    </select>
                                    <label for="leave_day">Leave Day/s</label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 d-none" x-ref="dateDiv">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="currentLeave[leaveDate]" class="form-control bg-white leave-form-modal leave-dates" id="leave-date" placeholder="Leave Date" x-model="currentLeave.leaveDate" required data-inputmask-placeholder="YYYY-MM-DD" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy-mm-dd">
                                    <label for="currentLeave[leaveDate]">Leave Date<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-none" x-ref="dateFromDiv">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="currentLeave[leaveDateFrom]" class="form-control bg-white leave-form-modal leave-dates" id="leave-from" placeholder="Leave Date From" x-model="currentLeave.leaveDateFrom" required data-inputmask-placeholder="YYYY-MM-DD" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy-mm-dd">
                                    <label for="currentLeave[leaveDateFrom]">Leave Date From<span class="text-danger"> *</span></label>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-none" x-ref="dateToDiv">
                        <div class="form-group row p-1 m-0" >
                            <div class="col-sm-12 p-0 m-0">
                                <div class="form-floating">
                                    <input type="text" name="currentLeave[leaveDateTo]" class="form-control bg-white leave-form-modal leave-dates" id="leave-to" placeholder="Leave Date To" x-model="currentLeave.leaveDateTo" required data-inputmask-placeholder="YYYY-MM-DD" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy-mm-dd">
                                    <label for="currentLeave[leaveDateTo]">Leave Date To<span class="text-danger"> *</span></label>
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
                                    <select class="form-select leave-form-modal" name="currentLeave[leaveType]" x-model="currentLeave.leaveType" required>
                                        <option value="">Select</option>
                                        <template x-if="(leaveType ?? []).length > 0">
                                            <template x-for="leave in leaveType">
                                                <option :value="leave.id" x-text="leave.description"></option>
                                            </template>
                                        </template>
                                    </select>
                                    <label for="currentLeave[leaveType]">Leave Type</label>
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
                                    <select class="form-select leave-form-modal" name="currentLeave[dayType]" x-model="currentLeave.dayType" required>
                                        <option value="">Select</option>
                                        <option value="Whole Day">Whole Day</option>
                                        <option value="Half Day">Half Day</option>
                                    </select>
                                    <label for="currentLeave[dayType]">Day Type</label>
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
                                    <textarea name="currentLeave[reason]" class="form-control leave-form-modal" placeholder="Reason" required style="height: 100px;" x-model="currentLeave.reason"></textarea>
                                    <label for="currentLeave[reason]">Reason<span class="text-danger"> *</span></label>
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
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal" style="border-radius: 5px;">Close</button>
                <button type="button" class="btn btn-sm btn-outline-primary submit-btn" @click="submitRequest" style="border-radius: 5px;">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>
