<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class SinhVien extends Controller
{
    /**
     * Hiển thị danh sách sinh viên.
     */
    
     public function index(Request $request)
    {
        $students = Student::all();
        $query = Student::query();
        return view('students.index', compact('students'));

        if ($request->has('class')) {
            $query->where('class', $request->class);
        }
        if ($request->has('major')) {
            $query->where('major', $request->major);
        }
        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->has('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }

        $students = $query->get();
        return response()->json($students);
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

        return redirect()->route('students.index')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Xóa sinh viên khỏi hệ thống.
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Xóa thành công!');
    }
}
