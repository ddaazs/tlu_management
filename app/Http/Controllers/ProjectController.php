<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Project;
use App\Models\Student;
use Illuminate\Http\Request;
class ProjectController extends Controller
{
    /**
     * Hiển thị danh sách đồ án
     */
    public function index(Request $request)
    {
        $query = Project::with(['student', 'instructor']);

        // Lọc theo tên hoặc trạng thái nếu có yêu cầu tìm kiếm
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Áp dụng phân trang (5 bản ghi trên mỗi trang)
        $projects = $query->paginate(10);

        // Kiểm tra nếu là request AJAX thì trả về JSON (hỗ trợ tìm kiếm động)
        if ($request->ajax()) {
            return response()->json($projects);
        }

        return view('projects.index', compact('projects'));
    }
    public function student(Request $request) // Thêm Request $request
    {
        $query = Project::with(['student', 'instructor']);

        // Lọc theo tên hoặc trạng thái nếu có yêu cầu tìm kiếm
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Áp dụng phân trang (10 bản ghi trên mỗi trang)
        $projects = $query->paginate(10);

        // Kiểm tra nếu là request AJAX thì trả về JSON (hỗ trợ tìm kiếm động)
        if ($request->ajax()) {
            return response()->json($projects);
        }

        return view('projects.student', compact('projects'));
    }





    /**
     * Hiển thị form tạo đồ án
     */
    public function create()
    {
        $students = Student::all();
        $instructor = Lecturer::all();
        return view('projects.create', compact('students', 'instructors'));
    }

    /**
     * Lưu đồ án mới vào database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'student_id' => 'required|exists:students,id',
            'instructor_id' => 'required|exists:lecturers,id',
            'status' => 'required|string'
        ]);

        Project::create($request->all());

        return redirect()->route('projects.index')->with('success', 'Đồ án đã được tạo thành công!');
    }

    /**
     * Hiển thị chi tiết một đồ án
     */
    public function show(Student $student)
    {
        $project = Project::with(['student', 'instructor'])->findOrFail($id);
        return view('projects.show', compact('project'));
    }

    /**
     * Hiển thị form chỉnh sửa đồ án
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $students = Student::all();
        $instructors = Lecturer::all();
        return view('projects.edit', compact('project', 'students', 'instructors'));
    }

    /**
     * Cập nhật đồ án trong database
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'student_id' => 'required|exists:students,id',
            'instructor_id' => 'required|exists:lecturers,id',
            'status' => 'required|string'
        ]);

        $project = Project::findOrFail($id);
        $project->update($request->all());

        return redirect()->route('projects.index')->with('success', 'Đồ án đã được cập nhật thành công!');
    }

    /**
     * Xóa đồ án khỏi database
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Đồ án đã bị xóa!');
    }
}
