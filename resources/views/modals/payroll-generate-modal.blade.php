<div class="modal fade" id="generate-payroll-modal" tabindex="-1" role="dialog" aria-labelledby="generatePayrollModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row mt-2">
                <span class="fw-bold text-center" style="font-size: 26px;">PAYROLL FOR 11/01/2023 - 11/15/2023</span>
            </div>
            <div class="row mt-2">
                <div class="table-sm table-responsive mt-1">
                    <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th class="text-center">CLOCK IN</th>
                            <th class="text-center">CLOCK OUT</th>
                            <th class="text-center">NOTES</th>
                            <th class="text-center">WH</th>
                            <th class="text-center">RWH</th>
                            <th class="text-center">OTH</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="p-0">
                            <td x-text="rows.attendance_date"></td>
                            <td class="text-center py-0">SAMPLE DATA</td>
                            <td class="text-center py-0">SAMPLE DATA</td>
                            <td class="text-center py-0 text-wrap" x-text="(rows.notes ? rows.notes : '-')"></td>
                            <td class="text-center py-0">SAMPLE DATA</td>
                            <td class="text-center py-0">SAMPLE DATA</td>
                            <td class="text-center py-0">SAMPLE DATA</td>
                        </tr>
                    </tbody>
                    <thead x-show="(attendancePayrollData ?? []).length > 0">
                        <tr>
                            <th colspan="7" class="text-center fw-bold" style="letter-spacing: 5px; font-size: 16px;">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody x-show="(attendancePayrollData ?? []).length > 0">
                        <tr>
                            <td colspan="4"></td>
                            <td class="text-center">SAMPLE DATA</td>
                            <td class="text-center">SAMPLE DATA</td>
                            <td class="text-center">SAMPLE DATA</td>
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
