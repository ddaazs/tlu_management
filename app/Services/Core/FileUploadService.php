<?php

namespace App\Services\Core;

use App\Repositories\Contracts\IFileUploadRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    protected $fileUploadRepository;

    public function __construct(IFileUploadRepository $fileUploadRepository)
    {
        $this->fileUploadRepository = $fileUploadRepository;
    }

    /**
     * Get student's files data
     */
    public function getStudentFiles(int $accountId): array
    {
        $student = $this->fileUploadRepository->getStudentByAccountId($accountId);
        if (!$student) {
            abort(404, 'Không tìm thấy thông tin sinh viên của bạn.');
        }

        return [
            'projects' => $this->fileUploadRepository->getStudentLatestProject($student->id),
            'internships' => $this->fileUploadRepository->getStudentLatestInternship($student->id)
        ];
    }

    /**
     * Get lecturer's projects
     */
    public function getLecturerProjects(int $accountId): array
    {
        $lecturer = $this->fileUploadRepository->getLecturerByAccountId($accountId);
        if (!$lecturer) {
            abort(404, 'Không tìm thấy thông tin giảng viên của bạn.');
        }

        return [
            'projects' => $this->fileUploadRepository->getLecturerProjects($lecturer->id)
        ];
    }

    /**
     * Get lecturer's internships
     */
    public function getLecturerInternships(int $accountId): array
    {
        $lecturer = $this->fileUploadRepository->getLecturerByAccountId($accountId);
        if (!$lecturer) {
            abort(404, 'Không tìm thấy thông tin giảng viên của bạn.');
        }

        return [
            'internships' => $this->fileUploadRepository->getLecturerInternships($lecturer->id)
        ];
    }

    /**
     * Upload project file
     */
    public function uploadProjectFile(int $projectId, UploadedFile $file): bool
    {
        $path = $file->store('projects', 'public');
        return $this->fileUploadRepository->updateProjectFile($projectId, $path);
    }

    /**
     * Upload internship file
     */
    public function uploadInternshipFile(int $internshipId, UploadedFile $file): bool
    {
        $path = $file->store('internships', 'public');
        return $this->fileUploadRepository->updateInternshipFile($internshipId, $path);
    }

    /**
     * Download project file
     */
    public function downloadProjectFile(int $projectId)
    {
        $project = $this->fileUploadRepository->getProjectById($projectId);
        if (!$project || !$project->project_file) {
            abort(404, 'File không tồn tại.');
        }
        return response()->download(storage_path('app/public/' . $project->project_file));
    }

    /**
     * Download internship file
     */
    public function downloadInternshipFile(int $internshipId)
    {
        $internship = $this->fileUploadRepository->getInternshipById($internshipId);
        if (!$internship || !$internship->report_file) {
            abort(404, 'File không tồn tại.');
        }
        return response()->download(storage_path('app/public/' . $internship->report_file));
    }
}
