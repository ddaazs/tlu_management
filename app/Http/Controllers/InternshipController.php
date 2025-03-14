<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Student;
use App\Models\InternshipCompany;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    // Hiển thị danh sách thực tập
    public function index()
    {
        $internships = Internship::with(['student', 'company', 'instructor'])->paginate(10); // Phân trang 10 bản ghi mỗi trang
        return view('internships.index', compact('internships'));
    }


    // Hiển thị form tạo mới
    public function create()
    {
        $students = Student::all();
        $companies = InternshipCompany::all();
        $lecturers = Lecturer::all();
        return view('internships.create', compact('students', 'companies', 'lecturers'));
    }

    // Lưu thực tập mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'student_id' => 'required|exists:students,id',
            'company_id' => 'required|exists:internship_companies,id',
            'instructor_id' => 'nullable|exists:lecturers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|string',
            'report_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $internship = new Internship($request->all());

        if ($request->hasFile('report_file')) {
            $file = $request->file('report_file');
            $filePath = $file->store('reports', 'public');
            $internship->report_file = $filePath;
        }

        $internship->save();

        return redirect()->route('internships.index')->with('success', 'Thực tập đã được tạo!');
    }

    // Hiển thị chi tiết thực tập
    public function show(Internship $internship)
    {
        return view('internships.show', compact('internship'));
    }

    // Hiển thị form chỉnh sửa
    public function edit(Internship $internship)
    {
        $students = Student::all();
        $companies = InternshipCompany::all();
        $lecturers = Lecturer::all();
        return view('internships.edit', compact('internship', 'students', 'companies', 'lecturers'));
    }

    // Cập nhật thực tập
    public function update(Request $request, Internship $internship)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'student_id' => 'required|exists:students,id',
            'company_id' => 'required|exists:internship_companies,id',
            'instructor_id' => 'nullable|exists:lecturers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|string',
            'report_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $internship->fill($request->all());

        if ($request->hasFile('report_file')) {
            $file = $request->file('report_file');
            $filePath = $file->store('reports', 'public');
            $internship->report_file = $filePath;
        }

        $internship->save();

        return redirect()->route('internships.index')->with('success', 'Cập nhật thành công!');
    }

    // Xóa thực tập
    public function destroy(Internship $internship)
    {
        $internship->delete();
        return redirect()->route('internships.index')->with('success', 'Xóa thành công!');
    }
}
