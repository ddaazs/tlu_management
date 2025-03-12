<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Project;
use App\Models\Internship;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MajorExport;
use App\Exports\LecturerExport;
use App\Exports\ScoreExport;
use App\Exports\StatusExport;
use App\Exports\SubmissionExport;

class StatisticsController extends Controller
{
    /**
     * Hiển thị trang index thống kê với các báo cáo và nút xuất báo cáo.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Thống kê theo ngành của sinh viên
        $byMajor = Student::select('major', DB::raw('COUNT(*) as total'))
            ->groupBy('major')
            ->get();

        // Thống kê theo giảng viên hướng dẫn (dựa trên dự án)
        $byLecturer = Project::selectRaw('instructor_id, COUNT(DISTINCT student_id) as total_students')
            ->groupBy('instructor_id')
            ->with('instructor')
            ->get();

        // Thống kê theo điểm số đồ án
        // Giả sử bảng reviews có cột score và liên kết với dự án (project_id) và mỗi dự án có trường student_id
        $byScore = DB::table('reviews')
            ->join('projects', 'reviews.project_id', '=', 'projects.id')
            ->select('reviews.score', DB::raw('COUNT(DISTINCT projects.student_id) as total_students'))
            ->groupBy('reviews.score')
            ->get();

        // Thống kê trạng thái đồ án từ bảng projects
        $byStatus = Project::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        // Thống kê số file nộp
        $projectCount = Project::whereNotNull('project_file')->count();
        $internshipCount = Internship::whereNotNull('report_file')->count();

        return view('statistics.index', compact('byMajor', 'byLecturer', 'byScore', 'byStatus', 'projectCount', 'internshipCount'));
    }

    /**
     * Xuất báo cáo thống kê theo ngành dưới dạng file Excel.
     */
    public function exportMajor()
    {
        return Excel::download(new MajorExport, 'major_report.xlsx');
    }

    /**
     * Xuất báo cáo thống kê theo giảng viên hướng dẫn dưới dạng file Excel.
     */
    public function exportLecturer()
    {
        return Excel::download(new LecturerExport, 'lecturer_report.xlsx');
    }

    /**
     * Xuất báo cáo thống kê theo điểm số đồ án dưới dạng file Excel.
     */
    public function exportScore()
    {
        return Excel::download(new ScoreExport, 'score_report.xlsx');
    }

    /**
     * Xuất báo cáo thống kê trạng thái đồ án dưới dạng file Excel.
     */
    public function exportStatus()
    {
        return Excel::download(new StatusExport, 'status_report.xlsx');
    }

    /**
     * Xuất báo cáo thống kê số file nộp dưới dạng file Excel.
     */
    public function exportSubmission()
    {
        return Excel::download(new SubmissionExport, 'submission_report.xlsx');
    }
}
