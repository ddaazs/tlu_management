<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',         // 🆕 Thêm tiêu đề
        'description',   // 🆕 Thêm mô tả
        'student_id',
        'company_id',
        'instructor_id', // 🆕 Thêm giảng viên hướng dẫn
        'start_date',
        'end_date',
        'status',
        'report_file'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Quan hệ với InternshipCompany
    public function company()
    {
        return $this->belongsTo(InternshipCompany::class, 'company_id');
    }

    // Quan hệ với Lecturer (giảng viên hướng dẫn)
    public function instructor()
    {
        return $this->belongsTo(Lecturer::class, 'instructor_id');
    }
}
