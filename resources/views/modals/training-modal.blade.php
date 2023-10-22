<div class="modal fade" id="training-modal" tabindex="-1" role="dialog" aria-labelledby="trainingModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-body">
                <form action="" method="POST" id="training-form" class="needs-validation" enctype="multipart/form-data">
                    <div class="row mt-2">
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-floating">
                                <input type="text" id="training-title" name="training-title" class="form-control form-control-sm" placeholder="Training's Title" required x-model="currentTraining.trainingTitle">
                                <label for="training-title">Training's Title</label>
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2 gx-1">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-floating">
                                <textarea class="form-control" name="training-description" id="training-description" placeholder="Training's description" style="height: 100px;" required x-model="currentTraining.trainingDesc"></textarea>
                                <label for="training-description">Training's description</label>
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2 gx-1">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-floating">
                                <input type="text" id="training-location" name="training-location" class="form-control form-control-sm" placeholder="Training's Location" required x-model="currentTraining.trainingLocation">
                                <label for="training-location">Training's Location</label>
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2 gx-lg-2 gy-sm-2">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-floating">
                                <input type="text" name="training-start" id="training-start" class="form-control form-control-sm training-date bg-white" placeholder="From Date: " required data-inputmask-placeholder="YYYY-MM-DD" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy-mm-dd" x-model="currentTraining.trainingStartDate">
                                <label for="training-start">From Date: </label>
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-floating">
                                <input type="text" name="training-end" id="training-end" class="form-control form-control-sm training-date bg-white" placeholder="To Date: " required data-inputmask-placeholder="YYYY-MM-DD" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="yyyy-mm-dd" x-model="currentTraining.trainingEndDate">
                                <label for="training-end">To Date: </label>
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2 gx-lg-2 gy-sm-2">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-floating">
                                <input type="text" name="training-start-time" id="training-start-time" class="form-control form-control-sm training-time" placeholder="Time Start: " required data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="HH:MM TT" x-model="currentTraining.trainingStartTime">
                                <label for="training-start-time">Time Start: </label>
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-floating date">
                                <input type="text" name="training-end-time" id="training-end-time" class="form-control form-control-sm training-time" placeholder="Time End: " required data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="HH:MM TT" x-model="currentTraining.trainingEndTime">
                                <label for="training-end-time">Time End: </label>
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-outline-primary submit-btn" @click="submitTraining" :disabled="buttonDisabled">Submit</button>
            </div>
        </div>
    </div>
</div>
