<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            case 'employee.store' :
                $validation = [
                    'recordId'         => 'nullable',
                    'name'             => 'nullable',
                    'role'             => 'nullable',
                    'lastName'         => 'required',
                    'firstName'        => 'required',
                    'position'         => 'required',
                    'lastPromotion'    => 'required|date_format:Y-m-d',
                    'stationCode'      => 'required',
                    'controlNumber'    => 'required',
                    'employeeNumber'   => 'required',
                    'schoolCode'       => 'required',
                    'itemNumber'       => 'required',
                    'employeeStatus'   => 'required',
                    'salaryGrade'      => 'required',
                    'dateHired'        => 'required|date_format:Y-m-d',
                    'sss'              => 'required',
                    'pagIbig'          => 'required',
                    'philHealth'       => 'required',
                    'gender'           => 'nullable',
                    'userImage'        => 'required|string',
                    'email'            => 'required|string|max:255|unique:users',
                    'password'         => 'required|string|min:8',
                ];
            break;
        }
        return $validation;
    }

    /**
     * Return message depending
     * on action.
     */
    public function messages()
    {
        $messages = [];

        switch ($this->route()->getName()) {
            case 'employee.store':
                $messages = [
                    'lastName.required'         =>  "Last name is required.",
                    'firstName.required'        =>  "First name is required.",
                    'position.required'         =>  "Position is required.",
                    'lastPromotion.required'    =>  "Last promotion is required.",
                    'stationCode.required'      =>  "Station code is required.",
                    'controlNumber.required'    =>  "Control number is required.",
                    'employeeNumber.required'   =>  "Employee Number is required.",
                    'schoolCode.required'       =>  "School codeis required.",
                    'itemNumber.required'       =>  "Item number is required.",
                    'employeeStatus.required'   =>  "Employee status is required.",
                    'salaryGrade.required'      =>  "Salary grade is required.",
                    'dateHired.required'        =>  "Date hired is required.",
                    'sss.required'              =>  "SSS is required.",
                    'pagIbig.required'          =>  "PAGIBIG is required.",
                    'philHealth.required'       =>  "PHILHEALTH is required.",
                    'userImage.required'        =>  "User image is required.",
                    // 'email.required'            =>  "Email is required.",
                    // 'password.required'         =>  "Password is required.",
                ];
            break;
            case 'employee.employee.attendance':
                $messages = [

                ];
            break;
            case 'employee.all-payroll':
                $messages = [

                ];
            break;
        }

        return $messages;
    }
}
