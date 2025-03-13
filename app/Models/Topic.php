<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',  // Đổi từ 'name' thành 'title' để đúng với migration
        'description',
        'student_id',
        'lecturer_id',
        'status',
    ];

    // 🔗 Một đề tài thuộc về một giảng viên
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id', 'id');
    }

    // 🔗 Một đề tài có thể có một sinh viên đăng ký (hoặc không có ai)
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    // 🔗 Một đề tài có thể liên kết với một project (nếu được duyệt)
    public function project()
    {
        return $this->hasOne(Project::class, 'topic_id', 'id'); 
    }
}
