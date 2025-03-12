<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScoreExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('reviews')
            ->join('projects', 'reviews.project_id', '=', 'projects.id')
            ->select('reviews.score', DB::raw('COUNT(DISTINCT projects.student_id) as total_students'))
            ->groupBy('reviews.score')
            ->get();
    }

    public function headings(): array
    {
        return ['Điểm số', 'Số lượng sinh viên'];
    }
}
