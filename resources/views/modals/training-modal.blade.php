<div class="modal fade" id="training-modal" tabindex="-1" role="dialog" aria-labelledby="trainingModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row mt-2">
                    <div class="col-lg-12 col-sm-12">
                        <div class="form-floating">
                            <input type="text" id="training-title" name="training-title" class="form-control form-control-sm" placeholder="Training Title">
                            <label for="training-title">Training Title</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 gx-1">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-floating">
                            <textarea class="form-control" name="training-description" id="training-description" placeholder="Please input the training's description" style="height: 100px;"></textarea>
                            <label for="training-description">Please input the training's description</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 gx-lg-2 gy-sm-2">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-floating">
                            <input type="text" name="training-start" id="training-start" class="form-control form-control-sm training-date bg-white" placeholder="Start Date: ">
                            <label for="training-start">Start Date: </label>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-floating">
                            <input type="text" name="training-end" id="training-end" class="form-control form-control-sm training-date bg-white" placeholder="End Date: ">
                            <label for="training-end">End Date: </label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 gx-lg-2 gy-sm-2">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-floating">
                            <input type="text" name="training-start-time" id="training-start-time" class="form-control form-control-sm training-time" placeholder="Time Start: ">
                            <label for="training-start-time">Time Start: </label>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-floating">
                            <input type="text" name="training-end-time" id="training-end-time" class="form-control form-control-sm training-time" placeholder="Time End: ">
                            <label for="training-end-time">Time End: </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-outline-primary submit-btn">Apply Filter</button>
            </div>
        </div>
    </div>
</div>
