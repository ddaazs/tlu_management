<?php

namespace App\Http\Controllers;

use App\Services\Core\ImportService;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    protected $importService;

    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * Import danh sách sinh viên qua file Excel.
     */
    public function importStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240' // Giới hạn file 10MB
        ]);

        $this->importService->importStudents($request->file('file'));

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

        $this->importService->importLecturers($request->file('file'));

        return redirect()->back()->with('success', 'Danh sách giảng viên đã được import thành công.');
    }
}
