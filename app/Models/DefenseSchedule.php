<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefenseSchedule extends Model
{
    use HasFactory;
    protected $table = 'defense_schedule';
    protected $fillable = [
        'project_id',
        'council_id',
        'defense_date',
        'location',
    ];

    // Quan hệ với Project
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    // Quan hệ với Council
   
}