<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'full_name',
        'email',
        'phone_number',
        'date_of_birth',
        'gender',
        'class',
        'major',
    ];

    /**
     * Quan hệ với bảng users (1 user có 1 student).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'account_id');
    }
}
