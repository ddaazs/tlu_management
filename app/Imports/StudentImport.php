<?php

namespace App\Imports;

use App\Repositories\Contracts\IImportRepository;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    protected $importRepository;

    public function __construct(IImportRepository $importRepository)
    {
        $this->importRepository = $importRepository;
    }

    // Tắt heading row formatter để giữ nguyên tên cột trong file Excel
    public static function headingRowFormatter(): string
    {
        return 'none';
    }

    public function model(array $row)
    {
        $this->importRepository->importStudents([
            'student_code' => $row['Mã sinh viên'],
            'full_name' => $row['Họ và tên'],
            'phone_number' => $row['Số điện thoại'] ?? null,
            'date_of_birth' => $row['Ngày sinh'] ?? null,
            'gender' => $row['Giới tính'] ?? null,
            'class' => $row['Lớp'] ?? null,
            'major' => $row['Ngành'] ?? null,
        ]);
    }
}
