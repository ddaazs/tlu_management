<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    // Tắt heading row formatter để giữ nguyên tên cột trong file Excel
    public static function headingRowFormatter(): string
    {
        return 'none';
    }

    public function model(array $row)
    {
        // Giả sử file Excel có cột "Mã số" để làm email và "Họ và tên" cho tên đầy đủ
        $email = $row['Mã sinh viên'] . '@tlu.edu.vn';

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name'     => $row['Họ và tên'],
                'password' => Hash::make('password'),
                'role'     => 'sinhvien'
            ]
        );

        return new Student([
            'account_id'    => $user->id,
            'full_name'     => $row['Họ và tên'],
            'email'         => $email,
            'phone_number'  => $row['Số điện thoại'] ?? null,
            'date_of_birth' => $row['Ngày sinh'] ?? null,
            'gender'        => $row['Giới tính'] ?? null,
            'class'         => $row['Lớp'] ?? null,
            'major'         => $row['Ngành'] ?? null,
        ]);
    }
}
