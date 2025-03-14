<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MajorExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Student::select('major', DB::raw('COUNT(*) as total'))
            ->groupBy('major')
            ->get();
    }

    public function headings(): array
    {
        return ['Ngành', 'Số lượng sinh viên'];
    }
}
