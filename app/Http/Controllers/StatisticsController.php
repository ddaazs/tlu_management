<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF;
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
     * Hiển thị trang index thống kê.
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

        // Thống kê theo điểm số đồ án (dựa trên bảng reviews, join projects)
        $byScore = DB::table('reviews')
            ->join('projects', 'reviews.project_id', '=', 'projects.id')
            ->select('reviews.score', DB::raw('COUNT(DISTINCT projects.student_id) as total_students'))
            ->groupBy('reviews.score')
            ->get();

        // Thống kê trạng thái đồ án từ bảng projects
        $byStatus = Project::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        // Thống kê số file nộp: đếm các dự án và báo cáo đã có file
        $projectCount = Project::whereNotNull('project_file')->count();
        $internshipCount = Internship::whereNotNull('report_file')->count();

        return view('statistics.index', compact('byMajor', 'byLecturer', 'byScore', 'byStatus', 'projectCount', 'internshipCount'));
    }

    /**
     * Xuất báo cáo thống kê theo ngành ra file Excel.
     */
    public function exportMajor()
    {
        return Excel::download(new MajorExport, 'major_report.xlsx');
    }

    /**
     * Xuất báo cáo thống kê theo giảng viên ra file Excel.
     */
    public function exportLecturer()
    {
        return Excel::download(new LecturerExport, 'lecturer_report.xlsx');
    }

    /**
     * Xuất báo cáo thống kê theo điểm số đồ án ra file Excel.
     */
    public function exportScore()
    {
        return Excel::download(new ScoreExport, 'score_report.xlsx');
    }

    /**
     * Xuất báo cáo thống kê theo trạng thái đồ án ra file Excel.
     */
    public function exportStatus()
    {
        return Excel::download(new StatusExport, 'status_report.xlsx');
    }

    /**
     * Xuất báo cáo thống kê số file nộp ra file Excel.
     */
    public function exportSubmission()
    {
        return Excel::download(new SubmissionExport, 'submission_report.xlsx');
    }

    /**
     * Xuất báo cáo thống kê theo ngành ra file PDF.
     */
    public function exportMajorPdf()
    {
        $byMajor = Student::select('major', DB::raw('COUNT(*) as total'))
            ->groupBy('major')
            ->get();

        $pdf = app('dompdf.wrapper')->loadView('statistics.pdf.major', compact('byMajor'));
        return $pdf->download('major_report.pdf');
    }

    /**
     * Xuất báo cáo thống kê theo giảng viên ra file PDF.
     */
    public function exportLecturerPdf()
    {
        $byLecturer = Project::selectRaw('instructor_id, COUNT(DISTINCT student_id) as total_students')
            ->groupBy('instructor_id')
            ->with('instructor')
            ->get();

        $pdf = app('dompdf.wrapper')->loadView('statistics.pdf.lecturer', compact('byLecturer'));
        return $pdf->download('lecturer_report.pdf');
    }

    /**
     * Xuất báo cáo thống kê theo điểm số đồ án ra file PDF.
     */
    public function exportScorePdf()
    {
        $byScore = DB::table('reviews')
            ->join('projects', 'reviews.project_id', '=', 'projects.id')
            ->select('reviews.score', DB::raw('COUNT(DISTINCT projects.student_id) as total_students'))
            ->groupBy('reviews.score')
            ->get();

        $pdf = app('dompdf.wrapper')->loadView('statistics.pdf.score', compact('byScore'));
        return $pdf->download('score_report.pdf');
    }

    /**
     * Xuất báo cáo thống kê theo trạng thái đồ án ra file PDF.
     */
    public function exportStatusPdf()
    {
        $byStatus = Project::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        $pdf = app('dompdf.wrapper')->loadView('statistics.pdf.status', compact('byStatus'));
        return $pdf->download('status_report.pdf');
    }

    /**
     * Xuất báo cáo thống kê số file nộp ra file PDF.
     */
    public function exportSubmissionPdf()
    {
        $projectCount = Project::whereNotNull('project_file')->count();
        $internshipCount = Internship::whereNotNull('report_file')->count();

        $pdf = app('dompdf.wrapper')->loadView('statistics.pdf.submission', compact('projectCount', 'internshipCount'));
        return $pdf->download('submission_report.pdf');
    }

    public function viewMajorPdf()
    {
        $byMajor = Student::select('major', DB::raw('COUNT(*) as total'))
            ->groupBy('major')
            ->get();

        // Tạo file PDF và stream (xem trước) trên trình duyệt
        $pdf = app('dompdf.wrapper')->loadView('statistics.pdf.major', compact('byMajor'));
        return $pdf->stream('major_report.pdf');
    }

    public function viewLecturerPdf(){
        $byLecturer = Project::selectRaw('instructor_id, COUNT(DISTINCT student_id) as total_students')
            ->groupBy('instructor_id')
            ->with('instructor')
            ->get();

        $pdf = app('dompdf.wrapper')->loadView('statistics.pdf.lecturer', compact('byLecturer'));
        return $pdf->stream('lecturer_report.pdf');
    }
    public function viewScorePdf(){
        $byScore = DB::table('reviews')
            ->join('projects', 'reviews.project_id', '=', 'projects.id')
            ->select('reviews.score', DB::raw('COUNT(DISTINCT projects.student_id) as total_students'))
            ->groupBy('reviews.score')
            ->get();

        $pdf = app('dompdf.wrapper')->loadView('statistics.pdf.score', compact('byScore'));
        return $pdf->stream('score_report.pdf');
    }
    public function viewStatusPdf(){
        $byStatus = Project::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        $pdf = app('dompdf.wrapper')->loadView('statistics.pdf.status', compact('byStatus'));
        return $pdf->stream('status_report.pdf');
    }
    public function viewSubmissionPdf(){
        $projectCount = Project::whereNotNull('project_file')->count();
        $internshipCount = Internship::whereNotNull('report_file')->count();

        $pdf = app('dompdf.wrapper')->loadView('statistics.pdf.submission', compact('projectCount', 'internshipCount'));
        return $pdf->stream('submission_report.pdf');
    }
}
