<div class="modal fade" id="employee-view-uploaded-file-modal" tabindex="-1" role="dialog" aria-labelledby="employeeviewuploadedfilemodal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="fw-bold">Files Uploaded</h4>
                <div class="row my-2 mx-2">
                    <div class="col-12">
                        <div class="table-sm table-responsive my-4 mx-4">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr class="text-center">
                                    <th>No.</th>
                                    <th>File Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <template x-if="fileFetchLoading">
                                    <tbody>
                                        <tr>
                                            <td class="text-center" colspan="3"><div class="spinner-border"></div></td>
                                        </tr>
                                    </tbody>
                                </template>
                                <template x-if="!fileFetchLoading">
                                    <tbody>
                                        <template x-if="(employeeFiles ?? []).length == 0">
                                            <tr class="text-center">
                                                <td class="" colspan="3"><i class="fa fa-info-circle"></i> There is no file uploaded yet.</td>
                                            </tr>
                                        </template>
                                        <template x-if="(employeeFiles ?? []).length > 0">
                                            <template x-for="(rows, indexData) in employeeFiles">
                                                <tr class="text-center">
                                                    <td x-text="indexData + 1"></td>
                                                    <td x-text="rows.file_name"></td>
                                                    <td>
                                                        <a class="text-reset text-decoration-none" href="javascript:void(0);" id="fileSplitMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-lg fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu" aria-labelledby="fileSplitMenuButton">
                                                            <a class="dropdown-item text-reset text-decoration-none" :href="'storage/' + rows.file_path" target="_blank">
                                                                <i class="ti-eye btn-icon-prepend me-2"></i>
                                                                View
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-reset text-decoration-none" href="javascript:void(0);">
                                                                <i class="ti-trash btn-icon-prepend me-2"></i>
                                                                Delete
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                        </template>
                                    </tbody>
                                </template>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-outline-danger" @click="closeViewUploadedFilesModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
