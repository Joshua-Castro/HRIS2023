<div class="modal fade" id="edit-attendance-modal" tabindex="-1" role="dialog" aria-labelledby="editAttendanceModal" aria-hidden="true">
    <div class="modal-dialog modal-sm-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row my-2 gx-1">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" id="edit-clock-in" name="edit-clock-in" class="form-control form-control-sm attendance-time" placeholder="Clock In" data-inputmask="'alias': 'datetime', 'inputFormat': 'hh:MM:ss TT', 'placeholder': 'hh:mm:ss AM/PM'">
                            <label for="edit-clock-in">Clock In</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" id="edit-break-out" name="edit-break-out" class="form-control form-control-sm attendance-time" placeholder="Break Out" data-inputmask="'alias': 'datetime', 'inputFormat': 'hh:MM:ss TT', 'placeholder': 'hh:mm:ss AM/PM'">
                            <label for="edit-break-out">Break Out</label>
                        </div>
                    </div>
                </div>
                <div class="row my-2 gx-1">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" id="edit-break-in" name="edit-break-in" class="form-control form-control-sm attendance-time" placeholder="Break In" data-inputmask="'alias': 'datetime', 'inputFormat': 'hh:MM:ss TT', 'placeholder': 'hh:mm:ss AM/PM'">
                            <label for="edit-break-in">Break In</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" id="edit-clock-out" name="edit-clock-out" class="form-control form-control-sm attendance-time" placeholder="Clock Out" data-inputmask="'alias': 'datetime', 'inputFormat': 'hh:MM:ss TT', 'placeholder': 'hh:mm:ss AM/PM'">
                            <label for="edit-clock-out">Clock Out</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal" style="border-radius: 5px;">Cancel</button>
                <button type="button" class="btn btn-sm btn-outline-primary" style="border-radius: 5px;">Update Attendance</button>
            </div>
        </div>
    </div>
</div>
