<?php

namespace App\Repositories\Contracts;

use App\Models\Project;
use App\Models\Internship;
use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface IFileUploadRepository
{
    /**
     * Get student by account ID
     */
    public function getStudentByAccountId(int $accountId): ?Student;

    /**
     * Get lecturer by account ID
     */
    public function getLecturerByAccountId(int $accountId): ?Lecturer;

    /**
     * Get project by ID
     */
    public function getProjectById(int $id): ?Project;

    /**
     * Get internship by ID
     */
    public function getInternshipById(int $id): ?Internship;

    /**
     * Get student's latest project
     */
    public function getStudentLatestProject(int $studentId): ?Project;

    /**
     * Get student's latest internship
     */
    public function getStudentLatestInternship(int $studentId): ?Internship;

    /**
     * Get lecturer's projects with pagination
     */
    public function getLecturerProjects(int $lecturerId, int $perPage = 5): LengthAwarePaginator;

    /**
     * Get lecturer's internships with pagination
     */
    public function getLecturerInternships(int $lecturerId, int $perPage = 5): LengthAwarePaginator;

    /**
     * Update project file
     */
    public function updateProjectFile(int $projectId, string $filePath): bool;

    /**
     * Update internship file
     */
    public function updateInternshipFile(int $internshipId, string $filePath): bool;
}
