<?php

namespace App\Exports;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StatusExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Project::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();
    }

    public function headings(): array
    {
        return ['Trạng thái', 'Số lượng'];
    }
}
