<?php

namespace App\Exports;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LecturerExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Lấy dữ liệu thống kê theo giảng viên dựa trên projects:
        $data = Project::selectRaw('instructor_id, COUNT(DISTINCT student_id) as total_students')
            ->groupBy('instructor_id')
            ->with('lecturer')
            ->get();

        // Chuyển đổi dữ liệu để thay thế instructor_id bằng tên giảng viên
        $dataTransformed = $data->map(function ($item) {
            return [
                'Lecturer'       => $item->instructor->full_name ?? 'N/A',
                'Total Students' => $item->total_students,
            ];
        });

        return $dataTransformed;
    }

    public function headings(): array
    {
        return ['Giảng viên', 'Số lượng sinh viên hướng dẫn'];
    }
}
