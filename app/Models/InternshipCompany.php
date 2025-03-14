<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipCompany extends Model
{
    use HasFactory;
    protected $table = 'internship_companies';

    protected $fillable = ['name', 'address', 'contact_person', 'email', 'phone_number'];

    public $timestamps = true;

    public function internships()
    {
        return $this->hasMany(Internship::class, 'company_id');
    }
}
