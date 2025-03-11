<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'student_id',
        'instructor_id',
        'status',
        'project_file'
    ];

    // Quan hệ với Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Quan hệ với Lecturer
    public function instructor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Lecturer::class, 'instructor_id');
    }
}
