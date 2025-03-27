<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;
use App\Imports\LecturerImport;

class ImportController extends Controller
{
    /**
     * Import danh sách sinh viên qua file Excel.
     */
    public function importStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240' // Giới hạn file 10MB
        ]);

        Excel::import(new StudentImport, $request->file('file'));

        return redirect()->back()->with('success', 'Danh sách sinh viên đã được import thành công.');
    }

    /**
     * Import danh sách giảng viên qua file Excel.
     */
    public function showLecturerImportForm()
    {
        return view('import.lecturers');
    }
    public function importLecturers(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240'
        ]);

        Excel::import(new LecturerImport, $request->file('file'));

        return redirect()->back()->with('success', 'Danh sách giảng viên đã được import thành công.');
    }
}
