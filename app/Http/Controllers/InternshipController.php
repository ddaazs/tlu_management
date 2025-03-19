<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Student;
use App\Models\InternshipCompany;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    // 🔹 Hiển thị danh sách thực tập
    public function index()
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        $internships = Internship::with(['student', 'company', 'instructor'])->paginate(10);
        return view('internships.index', compact('internships'));
    }

    // 🔹 Sinh viên xem danh sách thực tập của mình
    public function studentIndex()
    {
        if (!Gate::allows('sinhvien')) {
            abort(403, 'Chỉ sinh viên mới có quyền truy cập.');
        }

        $internships = Internship::with(['student', 'company', 'instructor'])->paginate(10);
        
        return view('internships.student_index', compact('internships'));
    }

    // 🔹 Giảng viên & Quản trị viên tạo thực tập
    public function create()
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền tạo thực tập.');
        }

        $students = Student::all();
        $companies = InternshipCompany::all();
        $lecturers = Lecturer::all();
        return view('internships.create', compact('students', 'companies', 'lecturers'));
    }

    // 🔹 Lưu thực tập (Giảng viên & Quản trị viên)
    public function store(Request $request)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền thêm thực tập.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'student_id' => 'required|exists:students,id',
            'company_id' => 'required|exists:internship_companies,id',
            'instructor_id' => 'nullable|exists:lecturers,id',
            'start_date' => ['required', 'date', 'after_or_equal:today'], // Đảm bảo ngày bắt đầu >= hôm nay
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|string',
            'report_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
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

    // 🔹 Hiển thị chi tiết thực tập
    public function show(Internship $internship)
    {
        return view('internships.show', compact('internship'));
    }

    // 🔹 Chỉnh sửa thực tập (Chỉ giảng viên & quản trị)
    public function edit(Internship $internship)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền chỉnh sửa.');
        }

        $students = Student::all();
        $companies = InternshipCompany::all();
        $lecturers = Lecturer::all();
        return view('internships.edit', compact('internship', 'students', 'companies', 'lecturers'));
    }

    // 🔹 Cập nhật thực tập (Chỉ giảng viên & quản trị)
    public function update(Request $request, Internship $internship)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền cập nhật.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'student_id' => 'required|exists:students,id',
            'company_id' => 'required|exists:internship_companies,id',
            'instructor_id' => 'nullable|exists:lecturers,id',
            'start_date' => ['required', 'date', 'after_or_equal:today'], // Đảm bảo ngày bắt đầu >= hôm nay
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|string',
            'report_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $internship->update($validated);

        if ($request->hasFile('report_file')) {
            $file = $request->file('report_file');
            $filePath = $file->store('reports', 'public');
            $internship->update(['report_file' => $filePath]);
        }

        return redirect()->route('internships.index')->with('success', 'Cập nhật thành công!');
    }

    // 🔹 Xóa thực tập (Chỉ giảng viên & quản trị)
    public function destroy(Internship $internship)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền xóa.');
        }

        $internship->delete();
        return redirect()->route('internships.index')->with('success', 'Xóa thành công!');
    }

    // 🔹 Sinh viên đăng ký thực tập
    public function studentCreate()
    {
        if (!Gate::allows('sinhvien')) {
            abort(403, 'Chỉ sinh viên mới có thể đăng ký thực tập.');
        }

        $companies = InternshipCompany::all();
        $lecturers = Lecturer::all(); // Lấy danh sách giảng viên

        return view('internships.student_create', compact('companies', 'lecturers'));
    }

    // 🔹 Xử lý đăng ký thực tập (Sinh viên)
    public function studentStore(Request $request)
    {
        if (!Gate::allows('sinhvien')) {
            abort(403, 'Chỉ sinh viên mới có thể đăng ký thực tập.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'company_id' => 'required|exists:internship_companies,id',
            'instructor_id' => 'required|exists:lecturers,id', // 🔥 Bắt buộc chọn giảng viên
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|string',
        ]);

        Internship::create([
            'title' => $request->title,
            'description' => $request->description,
            'student_id' => Auth::id(),
            'company_id' => $request->company_id,
            'instructor_id' => $request->instructor_id, // 🔥 Giảng viên bắt buộc phải có
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()->route('internships.studentIndex')->with('success', 'Bạn đã đăng ký thực tập thành công!');
    }

}
