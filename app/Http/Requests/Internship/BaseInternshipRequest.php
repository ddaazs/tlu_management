<?php

namespace App\Http\Requests\Internship;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseInternshipRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function baseRules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'company_id' => 'required|exists:internship_companies,id',
            'instructor_id' => 'required|exists:lecturers,id',
            'start_date' => ['required', 'date', 'after_or_equal:' . now()->format('Y-m-d')],
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|string|in:Chưa bắt đầu,Đang thực tập,Hoàn thành',
            'report_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ];
    }
}