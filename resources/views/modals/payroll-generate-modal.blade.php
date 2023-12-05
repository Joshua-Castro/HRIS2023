<div class="modal fade" id="generate-payroll-modal" tabindex="-1" role="dialog" aria-labelledby="generatePayrollModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 3050px; width: 1000px;">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row mt-2">
                <span class="fw-bold text-center" style="font-size: 26px;">PAYROLL FOR 11/01/2023 - 11/15/2023</span>
            </div>
            <div class="row mt-4">
                <div class="table-sm table-responsive mt-1">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th colspan="4" class="py-2 fw-bold" style="font-size: 16px; background-color: #eee;">EMPLOYEE INFORMATION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 fw-bold text-end" style="max-width: 500px; width: 90px;">Name :</td>
                                <td class="py-2" x-text="employeeName"></td>
                                <td class="py-2 fw-bold text-end" style="max-width: 500px; width: 90px;">Status :</td>
                                <td class="py-2" x-text="employeeStatus"></td>
                            </tr>
                            <tr>
                                <td class="py-2 fw-bold text-end" style="max-width: 500px; width: 90px;">Basic salary :</td>
                                <td class="py-2" x-text="employeeSalary"></td>
                                <td class="py-2 fw-bold text-end" style="max-width: 500px; width: 90px;">Employee No :</td>
                                <td class="py-2" x-text="employeeNo"></td>
                            </tr>
                            <tr>
                                <td class="py-2 fw-bold text-end" style="max-width: 500px; width: 90px;">Date Hired :</td>
                                <td class="py-2" x-text="employeeDateHired"></td>
                                <td class="py-2 fw-bold text-end" style="max-width: 500px; width: 90px;">Position :</td>
                                <td class="py-2" x-text="employeePosition"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-4">
                <div class="table-sm table-responsive mt-1">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th colspan="4" class="py-2 fw-bold" style="font-size: 16px; background-color: #eee;">EARNINGS</th>
                            </tr>
                            <tr class="text-center">
                                <th class="py-2 fw-bold">Description</th>
                                <th class="py-2 fw-bold">Hourly Rate</th>
                                <th class="py-2 fw-bold">Hours Rendered</th>
                                <th class="py-2 fw-bold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td class="py-2">Regular Income</td>
                                <td class="py-2" x-text="hourlyRate"></td>
                                <td class="py-2" x-text="regularHours"></td>
                                <td class="py-2" x-text="totalRegularEarnings"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal" style="border-radius: 5px;">Close</button>
            <button type="button" class="btn btn-sm btn-outline-primary submit-btn" style="border-radius: 5px;">Submit</button>
        </div>
      </div>
    </div>
</div>
