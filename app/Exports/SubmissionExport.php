<?php

namespace App\Exports;

use App\Models\Project;
use App\Models\Internship;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubmissionExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $projectCount = Project::whereNotNull('project_file')->count();
        $internshipCount = Internship::whereNotNull('report_file')->count();

        return collect([
            ['Loại File' => 'Đồ Án', 'Số lượng' => $projectCount],
            ['Loại File' => 'Báo Cáo Thực Tập', 'Số lượng' => $internshipCount],
        ]);
    }

    public function headings(): array
    {
        return ['Loại File', 'Số lượng'];
    }
}
