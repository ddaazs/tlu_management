<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'full_name',
        'email',
        'phone_number',
        'degree',
        'department',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'account_id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'instructor_id');
    }
}
