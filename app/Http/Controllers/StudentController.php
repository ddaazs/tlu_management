<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Str;

class SinhVien extends Controller
{
    /**
     * Hiển thị danh sách sinh viên.
     */
    public function search(Request $request)
{
    $students = Student::query(); // Khởi tạo query builder

    // Nếu người dùng nhập tên
    if ($request->filled('full_name')) {
        $students->where('full_name', 'like', "%" . $request->full_name . "%");
    }

    // Nếu người dùng chọn lớp
    if ($request->filled('class')) {
        $students->where('class', 'like', "%" . $request->class . "%");
    }

    // Nếu người dùng chọn ngành
    if ($request->filled('major')) {
        $students->where('major', 'like', "%" . $request->major . "%");
    }

    // Lấy dữ liệu
    $students = $students->get();

    // Kiểm tra nếu không có sinh viên nào thì trả về thông báo
    if ($students->isEmpty()) {
        return redirect()->route('students.search')->with('error', 'Không tìm thấy sinh viên phù hợp.');
    }
    
    return view('students.index', compact('students'));
}


     public function index(Request $request)
    {
        $students = Student::paginate(5);
        return view('students.index', compact('students'));
    }
    
    /**
     * Hiển thị chi tiết một sinh viên.
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('students.show', compact('student'));
    }

    /**
     * Hiển thị form chỉnh sửa sinh viên.
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    /**
     * Cập nhật thông tin sinh viên.
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,'.$id,
            'phone_number' => 'nullable|string|max:15',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:10',
            'class' => 'required|string|max:50',
            'major' => 'required|string|max:100',
        ]);

        $student->update($request->all());

        return redirect()->route('students.search')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Xóa sinh viên khỏi hệ thống.
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.search')->with('success', 'Xóa thành công!');
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:users,id', // Kiểm tra account_id có tồn tại trong users chưa
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone_number' => 'nullable|string|max:15',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:10',
            'class' => 'required|string|max:50',
            'major' => 'required|string|max:100',
        ]);
    
        Student::create([
            'account_id' => $request->account_id, 
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'class' => $request->class,
            'major' => $request->major,
        ]);
    
        return redirect()->route('students.search')->with('success', 'Thêm sinh viên thành công!');
    }

    
public function create()
{
    return view('students.create');
}


}
