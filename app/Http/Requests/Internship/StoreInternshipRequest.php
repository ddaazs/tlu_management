<?php

namespace App\Http\Requests\Internship;

class StoreInternshipRequest extends BaseInternshipRequest
{
    public function authorize()
    {
        return $this->user()->can('giangvien') || $this->user()->can('quantri');
    }

    public function rules()
    {
        return array_merge($this->baseRules(), [
            'student_id' => 'required|exists:students,id',
        ]);
    }

    public function messages()
    {
        return [
            'student_id.required' => 'Vui lòng chọn sinh viên.',
            'student_id.exists' => 'Sinh viên không tồn tại.',
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