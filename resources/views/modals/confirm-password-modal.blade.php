<div class="modal fade" id="employee-update-profile-modal" tabindex="-1" role="dialog" aria-labelledby="employeeupdateprofile" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="#">
                    <h1 class="modal-title text-center mb-4 fw-bold text-warning">WARNING</h1>
                    <p class="mt-2">Before changing your password, please keep the following in mind:</p>
                    <ul>
                        <li>
                            Ensure that your new password is strong and unique.
                        </li>
                        <li>
                            Do not share your password with anyone.
                        </li>
                        <li>
                            Remember your new password, as it cannot be retrieved once changed.
                        </li>
                    </ul>
                    <div class="row my-2" style="padding-right: 15px; padding-left: 15px;">
                        <input type="password" class="form-control" placeholder="PLEASE INPUT THE OLD PASSWORD: " x-model="confirmPassword" autocomplete="old-password">
                    </div>
                    <div class="row mt-4">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-outline-danger" style="border-radius: 5px;" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-sm btn-outline-primary ms-2" style="border-radius: 5px;" @click="confirmPasswordValidate">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
