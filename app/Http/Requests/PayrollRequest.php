<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayrollRequest extends FormRequest
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
                    'payroll.0' => 'required|numeric', // BASIC SALARY
                    'payroll.1' => 'required|numeric', // HOURLY RATE
                    'payroll.2' => 'required|exists:employees,id', // EMPLOYEE ID
                    'payroll.3' => 'nullable', // GOVERNMENT BENEFITS | DEDUCTIONS
                    'payroll.4' => 'required|numeric', // TOTAL DEDUCTIONS
                    'payroll.5' => 'required|numeric', // NETPAY
                    'payroll.6' => 'required|date_format:Y-m-d', // PAYROLL DATE FROM
                    'payroll.7' => 'required|date_format:Y-m-d', // PAYROLL DATE TO
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
                    'payroll.required'          => 'Payroll data is required.',
                    'payroll.array'             => 'Payroll data must be an array.',
                    'payroll.0.required'        => 'Basic salary rate is required.',
                    'payroll.0.numeric'         => 'Basic salary rate must be a number.',
                    'payroll.1.required'        => 'Hourly rate is required.',
                    'payroll.1.numeric'         => 'Hourly rate must be a number.',
                    'payroll.2.required'        => 'Employee ID is required.',
                    'payroll.2.exists'          => 'The selected employee ID does not exist.',
                    'payroll.4.required'        => 'Total deductions are required.',
                    'payroll.4.numeric'         => 'Total deductions must be a number.',
                    'payroll.5.required'        => 'Net pay is required.',
                    'payroll.5.numeric'         => 'Net pay must be a number.',
                    'payroll.6.required'        => 'Payroll date from is required. Please select date.',
                    'payroll.6.date_format'     => 'Invalid date format. It must (YYYY-MM-DD).',
                    'payroll.7.required'        => 'Payroll date to is required. Please select date.',
                    'payroll.7.date_format'     => 'Invalid date format. It must (YYYY-MM-DD).',
                ];
            break;
            case 'payroll.employee.attendance':
                $messages = [
                    'dateFrom.required'     => 'Please select date the attendance starting date.',
                    'dateFrom.date_format'  => 'Invalid date format. It must (YYYY-MM-DD).',
                    'dateTo.required'       => 'Please select date the attendance ending date.',
                    'dateTo.date_format'    => 'Invalid date format. It must (YYYY-MM-DD).',
                    'employeeId.required'   => 'Error, please select employee.',
                ];
            break;
        }

        return $messages;
    }
}
