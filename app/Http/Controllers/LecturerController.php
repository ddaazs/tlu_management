<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $departments = Department::all();
        $lecturers = Lecturer::orderBy('created_at', 'desc')->paginate(8);
        return view('page.lecturer.index', compact('lecturers', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
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
                'unique:users,email', // Đảm bảo email không trùng
                'regex:/^[a-zA-Z0-9._%+-]+@tlu\.edu\.vn$/',
            ],
            'phone_number' => 'nullable|string|max:15',
            'degree' => 'required|in:Thạc sĩ,Tiến sĩ,Giáo sư, Phó giáo sư',
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
    
        $user = User::create([
            'name' => $validatedData['full_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make('password'),
            'role' => 'giangvien',
        ]);
    
        Lecturer::create([
            'full_name' => $validatedData['full_name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'degree' => $validatedData['degree'],
            'department_id' => $validatedData['department_id'],
            'account_id' => $user->id,
        ]);
    
        return redirect()->route('lecturers.index')->with('success', 'Thêm giảng viên thành công!');
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
    public function edit(Lecturer $lecturer)
    {
        $departments = Department::all();
        return view('page.lecturer.edit', compact('lecturer', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($lecturer->account_id),
                'regex:/^[a-zA-Z0-9._%+-]+@tlu\.edu\.vn$/',
            ],
            'phone_number' => 'required|string|max:15',
            'degree' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|in:Đang làm việc,Đã nghỉ việc,Chuyển công tác',
        ],[
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
        // Cập nhật thông tin giảng viên
        
        // Nếu email thay đổi, cập nhật cả tài khoản người dùng
        if ($lecturer->account) {
            $lecturer->account->update([
                'name' => $request->full_name,
                'email' => $request->email,
            ]);
        }
        // dd($validatedData);
        $lecturer->update($validatedData);
        return redirect()->route('lecturers.index')->with('success', 'Cập nhật thông tin giảng viên thành công!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecturer $lecturer)
    {
        $user_id = $lecturer->account_id;
        // Cập nhật trạng thái giảng viên thành "Đã nghỉ việc"
        $lecturer->update(['status' => 'Đã nghỉ việc']);
        $user = User::find($user_id);
        $user->deactivate();
    
        return redirect()->route('lecturers.index')->with('success', 'Giảng viên đã được vô hiệu hóa.');
    }
}
