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
        return Project::selectRaw('instructor_id, COUNT(DISTINCT student_id) as total_students')
            ->groupBy('instructor_id')
            ->with('instructor')
            ->get();
    }

    public function headings(): array
    {
        return ['Giảng viên', 'Số lượng sinh viên'];
    }
}
