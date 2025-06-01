<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Student;
use App\Models\InternshipCompany;
use App\Models\Lecturer;
use App\Services\Core\InternshipService;
use App\Http\Requests\Internship\StoreInternshipRequest;
use App\Http\Requests\Internship\UpdateInternshipRequest;
use App\Http\Requests\Internship\StudentStoreInternshipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    protected $internshipService;

    public function __construct(InternshipService $internshipService)
    {
        $this->internshipService = $internshipService;
    }

    // 🔹 Hiển thị danh sách thực tập
    public function index()
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        $internships = $this->internshipService->getAllInternships();
        return view('internships.index', compact('internships'));
    }

    // 🔹 Sinh viên xem danh sách thực tập của mình
    public function studentIndex()
    {
        if (!Gate::allows('sinhvien')) {
            abort(403, 'Chỉ sinh viên mới có quyền truy cập.');
        }

        $student = $this->internshipService->getStudentByAccountId(auth()->id());

        if (!$student) {
            return abort(404, 'Không tìm thấy thông tin sinh viên.');
        }

        $internships = $this->internshipService->getInternshipsByStudentId($student->id);

        if ($internships->isEmpty()) {
            session()->flash('warning', 'Bạn chưa có thực tập nào.');
        }

        return view('internships.student_index', compact('internships'));
    }


    // 🔹 Giảng viên & Quản trị viên tạo thực tập
    public function create()
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền tạo thực tập.');
        }

        $students = $this->internshipService->getStudent();
        $companies = InternshipCompany::all();
        $lecturers = Lecturer::all();
        return view('internships.create', compact('students', 'companies', 'lecturers'));
    }

    // 🔹 Lưu thực tập (Giảng viên & Quản trị viên)
    public function store(StoreInternshipRequest $request)
    {
        $this->internshipService->createInternship($request->validated(), $request->file('report_file'));
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

        $students = $this->internshipService->getStudent();
        $companies = InternshipCompany::all();
        $lecturers = Lecturer::all();
        return view('internships.edit', compact('internship', 'students', 'companies', 'lecturers'));
    }

    // 🔹 Cập nhật thực tập (Chỉ giảng viên & quản trị)
    public function update(UpdateInternshipRequest $request, Internship $internship)
    {
        $this->internshipService->updateInternship($internship->id, $request->validated(), $request->file('report_file'));
        return redirect()->route('internships.index')->with('success', 'Cập nhật thành công!');
    }

    // 🔹 Xóa thực tập (Chỉ giảng viên & quản trị)
    public function destroy(Internship $internship)
    {
        if (!Gate::allows('giangvien') && !Gate::allows('quantri')) {
            abort(403, 'Bạn không có quyền xóa.');
        }

        $this->internshipService->deleteInternship($internship->id);
        return redirect()->route('internships.index')->with('success', 'Xóa thành công!');
    }

    // 🔹 Sinh viên đăng ký thực tập
    public function studentCreate()
    {
        if (!Gate::allows('sinhvien')) {
            abort(403, 'Chỉ sinh viên mới có thể đăng ký thực tập.');
        }

        $companies = InternshipCompany::all();
        $lecturers = Lecturer::all();
        return view('internships.student_create', compact('companies', 'lecturers'));
    }

    // 🔹 Xử lý đăng ký thực tập (Sinh viên)
    public function studentStore(StudentStoreInternshipRequest $request)
    {
        $student = $this->internshipService->getStudentByAccountId(auth()->id());

        if (!$student) {
            return abort(404, 'Không tìm thấy thông tin sinh viên.');
        }

        if ($this->internshipService->hasExistingInternship($student->id)) {
            return redirect()->back()->with('error', 'Bạn đã có một thực tập, không thể đăng ký thêm.');
        }

        $this->internshipService->createInternship([
            ...$request->validated(),
            'student_id' => $student->id,
        ]);

        return redirect()->route('internships.studentIndex')->with('success', 'Bạn đã đăng ký thực tập thành công!');
    }
}
