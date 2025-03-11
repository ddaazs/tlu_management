<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Project;
use App\Models\Internship;

class FileUploadController extends Controller
{
    /**
     * Áp dụng middleware auth để đảm bảo chỉ có user đăng nhập mới được truy cập.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Hiển thị trang index với danh sách dự án và báo cáo của sinh viên.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Lấy thông tin người dùng đã đăng nhập
        $user = auth()->user();
        if (!$user) {
            abort(403, 'Bạn cần đăng nhập.');
        }

        // Lấy thông tin sinh viên dựa trên account_id của user
        $student = Student::where('account_id', $user->id)->first();
        if (!$student) {
            abort(404, 'Không tìm thấy thông tin sinh viên của bạn.');
        }

        // Lấy danh sách dự án và báo cáo của sinh viên
        $projects = Project::where('student_id', $student->id)->get();
        $internships = Internship::where('student_id', $student->id)->get();

        return view('file-upload.index', compact('projects', 'internships'));
    }

    /**
     * Hiển thị trang edit cho upload file dự án.
     *
     * @param  int  $id  ID của bản ghi Project
     * @return \Illuminate\View\View
     */
    public function editProject($id)
    {
        $user = auth()->user();
        $student = Student::where('account_id', $user->id)->first();
        if (!$student) {
            abort(404, 'Không tìm thấy thông tin sinh viên của bạn.');
        }

        $project = Project::findOrFail($id);
        if ($project->student_id != $student->id) {
            abort(403, 'Bạn không có quyền truy cập dự án này.');
        }
        return view('file-upload.edit-project', compact('project'));
    }

    /**
     * Xử lý upload file cho dự án (đồ án).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id  ID của bản ghi Project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeProject(Request $request, $id)
    {
        $user = auth()->user();
        $student = Student::where('account_id', $user->id)->first();
        if (!$student) {
            abort(404, 'Không tìm thấy thông tin sinh viên của bạn.');
        }

        $project = Project::findOrFail($id);
        if ($project->student_id != $student->id) {
            abort(403, 'Bạn không có quyền upload file cho dự án này.');
        }

        // Validate file upload: sử dụng input name 'project_file'
        $request->validate([
            'project_file' => 'required|file|mimes:pdf,doc,docx,zip|max:5120',
        ]);

        // Lưu file vào thư mục 'projects' trên disk 'public'
        $path = $request->file('project_file')->store('projects', 'public');

        // Cập nhật trường project_file cho dự án
        $project->update([
            'project_file' => $path,
        ]);

        return redirect()->route('file-upload')->with('success', 'File dự án đã được upload thành công.');
    }

    /**
     * Hiển thị trang edit cho upload file báo cáo thực tập.
     *
     * @param  int  $id  ID của bản ghi Internship
     * @return \Illuminate\View\View
     */
    public function editInternship($id)
    {
        $user = auth()->user();
        $student = Student::where('account_id', $user->id)->first();
        if (!$student) {
            abort(404, 'Không tìm thấy thông tin sinh viên của bạn.');
        }

        $internship = Internship::findOrFail($id);
        if ($internship->student_id != $student->id) {
            abort(403, 'Bạn không có quyền truy cập báo cáo này.');
        }
        return view('file-upload.edit-internship', compact('internship'));
    }

    /**
     * Xử lý upload file cho báo cáo thực tập.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id  ID của bản ghi Internship
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeInternship(Request $request, $id)
    {
        $user = auth()->user();
        $student = Student::where('account_id', $user->id)->first();
        if (!$student) {
            abort(404, 'Không tìm thấy thông tin sinh viên của bạn.');
        }

        $internship = Internship::findOrFail($id);
        if ($internship->student_id != $student->id) {
            abort(403, 'Bạn không có quyền upload file cho báo cáo này.');
        }

        // Validate file upload: sử dụng input name 'internship_file'
        $request->validate([
            'internship_file' => 'required|file|mimes:pdf,doc,docx,zip|max:5120',
        ]);

        // Lưu file vào thư mục 'internships' trên disk 'public'
        $path = $request->file('internship_file')->store('internships', 'public');

        // Cập nhật trường report_file cho báo cáo thực tập
        $internship->update([
            'report_file' => $path,
        ]);

        return redirect()->route('file-upload')->with('success', 'Báo cáo thực tập đã được upload thành công.');
    }

}
