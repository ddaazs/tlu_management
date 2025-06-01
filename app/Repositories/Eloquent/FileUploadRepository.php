<?php

namespace App\Repositories\Eloquent;

use App\Models\Project;
use App\Models\Internship;
use App\Models\Student;
use App\Models\Lecturer;
use App\Repositories\Contracts\IFileUploadRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FileUploadRepository implements IFileUploadRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getStudentByAccountId(int $accountId): ?Student
    {
        return Student::where('account_id', $accountId)->first();
    }

    public function getLecturerByAccountId(int $accountId): ?Lecturer
    {
        return Lecturer::where('account_id', $accountId)->first();
    }

    public function getProjectById(int $id): ?Project
    {
        return Project::find($id);
    }

    public function getInternshipById(int $id): ?Internship
    {
        return Internship::find($id);
    }

    public function getStudentLatestProject(int $studentId): ?Project
    {
        return Project::where('student_id', $studentId)
            ->orderBy('updated_at', 'desc')
            ->first();
    }

    public function getStudentLatestInternship(int $studentId): ?Internship
    {
        return Internship::where('student_id', $studentId)
            ->orderBy('updated_at', 'desc')
            ->first();
    }

    public function getLecturerProjects(int $lecturerId, int $perPage = 5): LengthAwarePaginator
    {
        return Project::where('instructor_id', $lecturerId)
            ->paginate($perPage);
    }

    public function getLecturerInternships(int $lecturerId, int $perPage = 5): LengthAwarePaginator
    {
        return Internship::where('instructor_id', $lecturerId)
            ->paginate($perPage);
    }

    public function updateProjectFile(int $projectId, string $filePath): bool
    {
        $project = $this->getProjectById($projectId);
        if (!$project) {
            return false;
        }
        return $project->update(['project_file' => $filePath]);
    }

    public function updateInternshipFile(int $internshipId, string $filePath): bool
    {
        $internship = $this->getInternshipById($internshipId);
        if (!$internship) {
            return false;
        }
        return $internship->update(['report_file' => $filePath]);
    }
}
