<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'company_id',
        'start_date',
        'end_date',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // 1 thực tập thuộc về 1 công ty
    public function company()
    {
        return $this->belongsTo(InternshipCompany::class, 'company_id');
    }

    // 1 thực tập do 1 giảng viên hướng dẫn
    public function instructor()
    {
        return $this->belongsTo(Lecturer::class, 'instructor_id');
    }
}
