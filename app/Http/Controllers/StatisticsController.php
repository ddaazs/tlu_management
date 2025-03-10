<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    // Bỏ __construct để không áp dụng middleware xác thực trên backend

    public function index()
    {
        // Thống kê theo ngành (giả sử cột 'major' trên bảng students)
        $byMajor = Student::select('major', DB::raw('COUNT(*) as total'))
            ->groupBy('major')
            ->get();

        // Thống kê theo giảng viên hướng dẫn thông qua bảng projects
        $byLecturer = Project::selectRaw('instructor_id, COUNT(DISTINCT student_id) as total_students')
            ->groupBy('instructor_id')
            ->with('instructor')
            ->get();

        return view('statistics.index', compact('byMajor', 'byLecturer'));
    }
}
