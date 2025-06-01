<?php

namespace App\Http\Controllers;

use App\Services\Core\ProjectService;
use App\Services\Core\StudentService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;
    protected $studentService;

    public function __construct(
        ProjectService $projectService,
        StudentService $studentService
    ) {
        $this->projectService = $projectService;
        $this->studentService = $studentService;
    }

    /**
     * Hiển thị danh sách đồ án
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status']);
        $projects = $this->projectService->getAllProjects($filters);

        if ($request->ajax()) {
            return response()->json($projects);
        }

        return view('projects.index', compact('projects'));
    }

    public function student(Request $request)
    {
        $student = $this->studentService->getStudentByAccountId(auth()->id());

        if (!$student) {
            return abort(404, 'Không tìm thấy thông tin sinh viên');
        }

        $filters = $request->only(['search', 'status']);
        $projects = $this->projectService->getStudentProjects($student->id, $filters);

        if ($request->ajax()) {
            return response()->json(
                $projects->isEmpty()
                    ? ['message' => 'Sinh viên chưa có đồ án nào']
                    : $projects
            );
        }

        return view('projects.student', compact('projects'));
    }

    /**
     * Hiển thị form tạo đồ án
     */
    public function create()
    {
        $formData = $this->projectService->getFormData();
        return view('projects.create', $formData);
    }

    /**
     * Lưu đồ án mới vào database
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'student_id' => 'required|exists:students,id',
            'instructor_id' => 'required|exists:lecturers,id',
            'status' => 'required|string'
        ]);

        $this->projectService->createProject($validatedData);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Đồ án đã được tạo thành công!');
    }

    /**
     * Hiển thị chi tiết một đồ án
     */
    public function show(int $id)
    {
        $project = $this->projectService->getProjectById($id);
        return view('projects.show', compact('project'));
    }

    /**
     * Hiển thị form chỉnh sửa đồ án
     */
    public function edit(int $id)
    {
        $project = $this->projectService->getProjectById($id);
        $formData = $this->projectService->getFormData();

        return view('projects.edit', array_merge(
            ['project' => $project],
            $formData
        ));
    }

    /**
     * Cập nhật đồ án trong database
     */
    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'student_id' => 'required|exists:students,id',
            'instructor_id' => 'required|exists:lecturers,id',
            'status' => 'required|string'
        ]);

        $this->projectService->updateProject($id, $validatedData);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Đồ án đã được cập nhật thành công!');
    }

    /**
     * Xóa đồ án khỏi database
     */
    public function destroy(int $id)
    {
        $this->projectService->deleteProject($id);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Đồ án đã bị xóa!');
    }
}
