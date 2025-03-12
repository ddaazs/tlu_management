<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipCompany extends Model
{
    use HasFactory;
    protected $table = 'internship_companies';
    protected $fillable = ['company_name', 'address', 'field', 'email', 'phone_number'];

    public $timestamps = true;
}
