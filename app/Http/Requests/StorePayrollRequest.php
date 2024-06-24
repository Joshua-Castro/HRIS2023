<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePayrollRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $validation = [];

        switch ($this->route()->getName()) {
            case 'payroll.store' :
                $validation = [
                    'payroll'   => 'required|array',
                    'payroll.0' => 'required|numeric', // HOURLY RATE
                    'payroll.1' => 'required|exists:employees,id', // EMPLOYEE ID
                    'payroll.3' => 'required|numeric', // TOTAL DEDUCTIONS
                    'payroll.4' => 'required|numeric', // NETPAY
                ];
            break;
            case 'payroll.employee.attendance' :
                $validation = [
                    'dateFrom'      => 'required|date_format:Y-m-d',
                    'dateTo'        => 'required|date_format:Y-m-d',
                    'employeeId'    => 'required',
                ];
            break;
        }

        return $validation;
    }

    public function messages()
    {
        $messages = [];

        switch ($this->route()->getName()) {
            case 'payroll.store':
                $messages = [
                    'payroll.required'      => 'Payroll data is required.',
                    'payroll.array'         => 'Payroll data must be an array.',
                    'payroll.0.required'    => 'Hourly rate is required.',
                    'payroll.0.numeric'     => 'Hourly rate must be a number.',
                    'payroll.1.required'    => 'Employee ID is required.',
                    'payroll.1.exists'      => 'The selected employee ID does not exist.',
                    'payroll.3.required'    => 'Total deductions are required.',
                    'payroll.3.numeric'     => 'Total deductions must be a number.',
                    'payroll.4.required'    => 'Net pay is required.',
                    'payroll.4.numeric'     => 'Net pay must be a number.',
                ];
            break;
            case 'payroll.employee.attendance':
                $messages = [
                    'dateFrom.required'     => 'Please select date the attendance starting date.',
                    'dateTo.required'       => 'Please select date the attendance ending date.',
                    'employeeId.required'   => 'Error, please select employee.',
                ];
            break;
        }

        return $messages;
    }
}
