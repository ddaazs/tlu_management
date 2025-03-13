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
        'department_id',
        'status',
    ];

    public function resign(){
        $this->update(['status' => 'Đã nghỉ việc']);
    }
    public function active(){
        $this->update(['status' => 'Đang làm việc']);
    }
    public function transfer(){
        $this->update(['status' => 'Chuyển công tác']);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'account_id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }
}
