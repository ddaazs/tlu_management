<?php

namespace App\Http\Controllers;

use App\Services\Core\LecturerService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LecturerController extends Controller
{
    protected $lecturerService;

    public function __construct(LecturerService $lecturerService)
    {
        $this->lecturerService = $lecturerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lecturers = $this->lecturerService->getAllLecturers();
        $departments = $this->lecturerService->getDepartments();

        return view('page.lecturer.index', compact('lecturers', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = $this->lecturerService->getDepartments();
        return view('page.lecturer.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@tlu\.edu\.vn$/',
            ],
            'phone_number' => 'nullable|string|max:15',
            'degree' => 'required|in:Thạc sĩ,Tiến sĩ,Giáo sư,Phó giáo sư',
            'department_id' => 'required|exists:departments,id'
        ], [
            'full_name.required' => 'Vui lòng nhập họ tên giảng viên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'email.regex' => 'Email phải có đuôi @tlu.edu.vn.',
            'phone_number.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'degree.required' => 'Vui lòng chọn học vị.',
            'degree.in' => 'Học vị không hợp lệ.',
            'department_id.required' => 'Vui lòng chọn bộ môn.',
            'department_id.exists' => 'Bộ môn không tồn tại.',
        ]);

        $this->lecturerService->createLecturer($validatedData);

        return redirect()
            ->route('lecturers.index')
            ->with('success', 'Thêm giảng viên thành công!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $lecturer = $this->lecturerService->getLecturerById($id);
        $departments = $this->lecturerService->getDepartments();

        return view('page.lecturer.edit', compact('lecturer', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id),
                'regex:/^[a-zA-Z0-9._%+-]+@tlu\.edu\.vn$/',
            ],
            'phone_number' => 'required|string|max:15',
            'degree' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|in:Đang làm việc,Đã nghỉ việc,Chuyển công tác',
        ], [
            'full_name.required' => 'Vui lòng nhập họ tên.',
            'full_name.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email này đã tồn tại.',
            'email.regex' => 'Email phải chứa @tlu.edu.vn',
            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'phone_number.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        $this->lecturerService->updateLecturer($id, $validatedData);

        return redirect()
            ->route('lecturers.index')
            ->with('success', 'Cập nhật thông tin giảng viên thành công!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->lecturerService->deactivateLecturer($id);

        return redirect()
            ->route('lecturers.index')
            ->with('success', 'Giảng viên đã được vô hiệu hóa.');
    }
}
