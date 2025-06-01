<?php

namespace App\Imports;

use App\Repositories\Contracts\IImportRepository;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LecturerImport implements ToModel, WithHeadingRow
{
    protected $importRepository;

    public function __construct(IImportRepository $importRepository)
    {
        $this->importRepository = $importRepository;
    }

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
        $this->importRepository->importLecturers([
            'full_name' => $row['full_name'],
            'phone_number' => $row['SĐT'] ?? null,
            'degree' => $row['Học vị'] ?? null,
        ]);
    }
}
