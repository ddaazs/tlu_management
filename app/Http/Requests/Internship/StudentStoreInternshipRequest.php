<?php

namespace App\Http\Requests\Internship;

class StudentStoreInternshipRequest extends BaseInternshipRequest
{
    public function authorize()
    {
        return $this->user()->can('sinhvien');
    }

    public function rules()
    {
        return $this->baseRules();
    }

    public function messages()
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'company_id.required' => 'Vui lòng chọn công ty.',
            'instructor_id.required' => 'Vui lòng chọn giảng viên hướng dẫn.',
            'start_date.required' => 'Vui lòng chọn ngày bắt đầu.',
            'end_date.required' => 'Vui lòng chọn ngày kết thúc.',
            'status.required' => 'Vui lòng chọn trạng thái.',
        ];
    }
}