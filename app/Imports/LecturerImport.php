<?php

namespace App\Imports;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LecturerImport implements ToModel, WithHeadingRow
{
    /**
     * Mỗi dòng dữ liệu trong file Excel sẽ được map vào model Lecturer.
     * Email của giảng viên được tạo từ tên giảng viên (slugify) với đuôi '@tlu.edu.vn'.
     * Nếu tài khoản trong bảng users chưa tồn tại, sẽ được tạo mới với mật khẩu mặc định là 'password'.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function headingRowFormatter(): string
    {
        return 'none';
    }

    public function model(array $row)
    {
        // Tạo email từ tên giảng viên: slugify tên với dấu chấm thay vì dấu gạch nối
        // Ví dụ: "Nguyễn Văn A" -> "nguyenvana@tlu.edu.vn"
        $email = Str::slug($row['full_name'], ) . '@tlu.edu.vn';

        // Tạo hoặc lấy tài khoản trong bảng users
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name'     => $row['full_name'],
                'password' => Hash::make('password'),
                'role'     => 'giangvien'
            ]
        );

        // Tạo bản ghi giảng viên với liên kết qua account_id
        return new Lecturer([
            'account_id' => $user->id,
            'full_name'  => $row['full_name'],
            'email'      => $email,
            'phone_number' => $row['SĐT'],
            'degree'    => $row['Học vị'],
        ]);
    }
}
