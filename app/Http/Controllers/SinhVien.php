<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


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
            'email' => [
                'required',
                'email',
                'unique:students,email,'.$id,
                'regex:/^[a-zA-Z0-9._%+-]+@tlu\.edu\.vn$/', // Email phải có đuôi @tlu.edu.vn
            ],
            'phone_number' => 'nullable|string|max:15',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:10',
            'class' => 'required|string|max:50',
            'major' => 'required|string|max:100',
        ], [
            'email.regex' => 'Email phải có đuôi @tlu.edu.vn.',
        ]);
        

        $student->update($request->all());

        return redirect()->route('.students.search')->with('success', 'Cập nhật thành công!');
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
        $validatedData = $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\p{L}\s]+$/u' // Chỉ cho phép chữ cái và khoảng trắng
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
        
    
        // Kiểm tra xem tài khoản đã tồn tại hay chưa
        $user = User::where('email', $validatedData['email'])->first();
    
        if (!$user) {
            // Nếu chưa có, tạo tài khoản mới
            $user = User::create([
                'name' => $validatedData['full_name'],
                'email' => $validatedData['email'],
                'password' => Hash::make('password'), // Mật khẩu mặc định là 'password'
                'role' => 'sinhvien',
            ]);
        }
    
        // Thêm sinh viên vào bảng students
        Student::create([
            'account_id' => $user->id,
            'full_name' => $validatedData['full_name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'gender' => $validatedData['gender'],
            'class' => $validatedData['class'],
            'major' => $validatedData['major'],
        ]);
    
        return redirect()->route('students.search')->with('success', 'Thêm sinh viên thành công!');
    }
    

    
public function create()
{
    return view('students.create');
}


}
