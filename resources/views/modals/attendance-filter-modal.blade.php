<div class="modal fade" id="attendance-filter-modal" tabindex="-1" role="dialog" aria-labelledby="attendanceFilterModal" aria-hidden="true">
    <div class="modal-dialog modal-sm-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row mt-2">
                    <div class="col-lg-12 col-sm-12">
                        <div class="form-floating">
                            <input type="text" id="attendance-search-keyword" name="search-keyword" class="form-control form-control-sm" placeholder="Employee Number \ Employee Name" x-model="currentSearchName">
                            <label for="search-keyword">Employee Number \ Employee Name</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 gx-1">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-floating">
                            <input type="text" id="attendance-date-from" name="attendance-date-from" class="form-control form-control-sm bg-white" placeholder="Date From :" x-model="attendanceFilterFrom">
                            <label for="search-keyword">Date From :</label>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-floating">
                            <input type="text" id="attendance-date-to" name="attendance-date-to" class="form-control form-control-sm bg-white" placeholder="Date To :" x-model="attendanceFilterTo">
                            <label for="search-keyword">Date To :</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal" style="border-radius: 5px;">Cancel</button>
                <button type="button" class="btn btn-sm btn-outline-primary submit-btn" @click="getAllAttendance" :disabled="attendanceLoading" style="border-radius: 5px;">Apply Filter</button>
            </div>
        </div>
    </div>
</div>
