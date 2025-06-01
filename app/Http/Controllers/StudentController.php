<?php

namespace App\Http\Controllers;

use App\Services\Core\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    /**
     * Hiển thị danh sách sinh viên.
     */
    public function search(Request $request)
    {
        $filters = $request->only(['full_name', 'class', 'major']);
        $students = $this->studentService->searchStudents($filters);

        if (!$students) {
            return redirect()->route('students.search')
                ->with('error', 'Không tìm thấy sinh viên phù hợp.');
        }

        return view('students.index', compact('students'));
    }

    public function index(Request $request)
    {
        $students = $this->studentService->getStudents();
        return view('students.index', compact('students'));
    }

    /**
     * Hiển thị chi tiết một sinh viên.
     */
    public function show(string|int $id)
    {
        $student = $this->studentService->getStudentById($id);
        return view('students.show', compact('student'));
    }

    /**
     * Hiển thị form chỉnh sửa sinh viên.
     */
    public function edit(string|int $id)
    {
        $student = $this->studentService->getStudentById($id);
        return view('students.edit', compact('student'));
    }

    /**
     * Cập nhật thông tin sinh viên.
     */
    public function update(Request $request, string|int $id)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:students,email,'.$id,
                'regex:/^[a-zA-Z0-9._%+-]+@tlu\.edu\.vn$/',
            ],
            'phone_number' => 'nullable|string|max:15',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:10',
            'class' => 'required|string|max:50',
            'major' => 'required|string|max:100',
        ], [
            'email.regex' => 'Email phải có đuôi @tlu.edu.vn.',
        ]);

        $this->studentService->updateStudent($id, $validatedData);

        return redirect()->route('students.index')
            ->with('success', 'Cập nhật thành công!');
    }

    /**
     * Xóa sinh viên khỏi hệ thống.
     */
    public function destroy(string|int $id)
    {
        $this->studentService->deleteStudent($id);
        return redirect()->route('students.index')
            ->with('success', 'Xóa thành công!');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\p{L}\s]+$/u'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@tlu\.edu\.vn$/',
            ],
            'phone_number' => 'nullable|string|max:15',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:10',
            'class' => 'required|string|max:50',
            'major' => 'required|string|max:100',
        ], [
            'full_name.required' => 'Vui lòng nhập họ tên sinh viên.',
            'full_name.regex' => 'Họ tên không được chứa ký tự đặc biệt.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'email.regex' => 'Email phải có đuôi @tlu.edu.vn.',
            'phone_number.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'date_of_birth.required' => 'Vui lòng nhập ngày sinh.',
            'gender.required' => 'Vui lòng chọn giới tính.',
            'class.required' => 'Vui lòng nhập lớp.',
            'major.required' => 'Vui lòng nhập ngành học.',
        ]);

        $this->studentService->createStudent($validatedData);

        return redirect()->route('students.index')
            ->with('success', 'Thêm sinh viên thành công!');
    }



public function create()
{
    return view('students.create');
}

}
