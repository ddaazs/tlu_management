<?php

namespace App\Http\Controllers;

use App\Services\Core\StatisticsService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MajorExport;
use App\Exports\LecturerExport;
use App\Exports\ScoreExport;
use App\Exports\StatusExport;
use App\Exports\SubmissionExport;

class StatisticsController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    /**
     * Hiển thị trang index thống kê.
     */
    public function index()
    {
        $statistics = $this->statisticsService->getAllStatistics();

        return view('statistics.index', [
            'byMajor' => $statistics['byMajor'],
            'byLecturer' => $statistics['byLecturer'],
            'byScore' => $statistics['byScore'],
            'byStatus' => $statistics['byStatus'],
            'projectCount' => $statistics['submission']['projectCount'],
            'internshipCount' => $statistics['submission']['internshipCount']
        ]);
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
        $data = ['byMajor' => $this->statisticsService->getAllStatistics()['byMajor']];
        $pdf = $this->statisticsService->generatePdf('statistics.pdf.major', $data);
        return $pdf->download('major_report.pdf');
    }

    /**
     * Xuất báo cáo thống kê theo giảng viên ra file PDF.
     */
    public function exportLecturerPdf()
    {
        $data = ['byLecturer' => $this->statisticsService->getAllStatistics()['byLecturer']];
        $pdf = $this->statisticsService->generatePdf('statistics.pdf.lecturer', $data);
        return $pdf->download('lecturer_report.pdf');
    }

    /**
     * Xuất báo cáo thống kê theo điểm số đồ án ra file PDF.
     */
    public function exportScorePdf()
    {
        $data = ['byScore' => $this->statisticsService->getAllStatistics()['byScore']];
        $pdf = $this->statisticsService->generatePdf('statistics.pdf.score', $data);
        return $pdf->download('score_report.pdf');
    }

    /**
     * Xuất báo cáo thống kê theo trạng thái đồ án ra file PDF.
     */
    public function exportStatusPdf()
    {
        $data = ['byStatus' => $this->statisticsService->getAllStatistics()['byStatus']];
        $pdf = $this->statisticsService->generatePdf('statistics.pdf.status', $data);
        return $pdf->download('status_report.pdf');
    }

    /**
     * Xuất báo cáo thống kê số file nộp ra file PDF.
     */
    public function exportSubmissionPdf()
    {
        $data = $this->statisticsService->getAllStatistics()['submission'];
        $pdf = $this->statisticsService->generatePdf('statistics.pdf.submission', $data);
        return $pdf->download('submission_report.pdf');
    }

    public function viewMajorPdf()
    {
        $data = ['byMajor' => $this->statisticsService->getAllStatistics()['byMajor']];
        $pdf = $this->statisticsService->generatePdf('statistics.pdf.major', $data);
        return $pdf->stream('major_report.pdf');
    }

    public function viewLecturerPdf()
    {
        $data = ['byLecturer' => $this->statisticsService->getAllStatistics()['byLecturer']];
        $pdf = $this->statisticsService->generatePdf('statistics.pdf.lecturer', $data);
        return $pdf->stream('lecturer_report.pdf');
    }

    public function viewScorePdf()
    {
        $data = ['byScore' => $this->statisticsService->getAllStatistics()['byScore']];
        $pdf = $this->statisticsService->generatePdf('statistics.pdf.score', $data);
        return $pdf->stream('score_report.pdf');
    }

    public function viewStatusPdf()
    {
        $data = ['byStatus' => $this->statisticsService->getAllStatistics()['byStatus']];
        $pdf = $this->statisticsService->generatePdf('statistics.pdf.status', $data);
        return $pdf->stream('status_report.pdf');
    }

    public function viewSubmissionPdf()
    {
        $data = $this->statisticsService->getAllStatistics()['submission'];
        $pdf = $this->statisticsService->generatePdf('statistics.pdf.submission', $data);
        return $pdf->stream('submission_report.pdf');
    }
}
