<?php

namespace App\Repositories\Eloquent;

use App\Models\Student;
use App\Models\Lecturer;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IImportRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImportRepository extends BaseRepository implements IImportRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function importStudents(array $data): void
    {
        $email = $data['student_code'] . '@tlu.edu.vn';

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $data['full_name'],
                'password' => Hash::make('password'),
                'role' => 'sinhvien'
            ]
        );

        Student::create([
            'account_id' => $user->id,
            'full_name' => $data['full_name'],
            'email' => $email,
            'phone_number' => $data['phone_number'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'gender' => $data['gender'] ?? null,
            'class' => $data['class'] ?? null,
            'major' => $data['major'] ?? null,
        ]);
    }

    public function importLecturers(array $data): void
    {
        $email = Str::slug($data['full_name']) . '@tlu.edu.vn';

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $data['full_name'],
                'password' => Hash::make('password'),
                'role' => 'giangvien'
            ]
        );

        Lecturer::create([
            'account_id' => $user->id,
            'full_name' => $data['full_name'],
            'email' => $email,
            'phone_number' => $data['phone_number'] ?? null,
            'degree' => $data['degree'] ?? null,
        ]);
    }
}
