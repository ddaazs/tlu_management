<?php

namespace App\Http\Controllers;

use App\Services\Core\FileUploadService;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    protected $fileUploadService;

    /**
     * Áp dụng middleware auth để đảm bảo chỉ có user đăng nhập mới được truy cập.
     */
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->middleware('auth');
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Hiển thị trang index với danh sách dự án và báo cáo của sinh viên.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = $this->fileUploadService->getStudentFiles(auth()->id());
        return view('file-upload.index', $data);
    }

    /**
     * Hiển thị trang edit cho upload file dự án.
     *
     * @param  int  $id  ID của bản ghi Project
     * @return \Illuminate\View\View
     */
    public function editProject($id)
    {
        $data = $this->fileUploadService->getStudentFiles(auth()->id());
        return view('file-upload.edit-project', ['project' => $data['projects']]);
    }

    /**
     * Xử lý upload file cho dự án (đồ án).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id  ID của bản ghi Project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeProject(Request $request, $id)
    {
        $request->validate([
            'project_file' => 'required|file|mimes:pdf,doc,docx,zip|max:20480',
        ], [
            'project_file.mimes' => 'Tệp phải có định dạng: pdf, doc, docx hoặc zip.',
            'project_file.max'   => 'Kích thước tệp không được vượt quá 20MB.',
        ]);

        $this->fileUploadService->uploadProjectFile($id, $request->file('project_file'));

        return redirect()->route('file-upload')
            ->with('success', 'File dự án đã được upload thành công.');
    }

    /**
     * Hiển thị trang edit cho upload file báo cáo thực tập.
     *
     * @param  int  $id  ID của bản ghi Internship
     * @return \Illuminate\View\View
     */
    public function editInternship($id)
    {
        $data = $this->fileUploadService->getStudentFiles(auth()->id());
        return view('file-upload.edit-internship', ['internship' => $data['internships']]);
    }

    /**
     * Xử lý upload file cho báo cáo thực tập.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id  ID của bản ghi Internship
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeInternship(Request $request, $id)
    {
        $request->validate([
            'internship_file' => 'required|file|mimes:pdf,doc,docx,zip|max:20480',
        ], [
            'internship_file.mimes' => 'Tệp phải có định dạng: pdf, doc, docx hoặc zip.',
            'internship_file.max'   => 'Kích thước tệp không được vượt quá 20MB.',
        ]);

        $this->fileUploadService->uploadInternshipFile($id, $request->file('internship_file'));

        return redirect()->route('file-upload')
            ->with('success', 'Báo cáo thực tập đã được upload thành công.');
    }

    /**
     * Display lecturer's projects
     */
    public function reviewProjects()
    {
        $data = $this->fileUploadService->getLecturerProjects(auth()->id());
        return view('file-upload.observeproject', $data);
    }

    /**
     * Display lecturer's internships
     */
    public function reviewInternships()
    {
        $data = $this->fileUploadService->getLecturerInternships(auth()->id());
        return view('file-upload.observeinternship', $data);
    }

    /**
     * Cho phép giáo viên tải file dự án về.
     *
     * @param int $id ID của bản ghi Project
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadProjectFile($id)
    {
        return $this->fileUploadService->downloadProjectFile($id);
    }

    /**
     * Cho phép giáo viên tải file báo cáo thực tập về.
     *
     * @param int $id ID của bản ghi Internship
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadInternshipFile($id)
    {
        return $this->fileUploadService->downloadInternshipFile($id);
    }
}
