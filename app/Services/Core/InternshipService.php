<?php

namespace App\Services\Core;

use App\Repositories\Contracts\IInternshipRepository;
use App\Repositories\Contracts\IStudentRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class InternshipService
{
    protected $internshipRepository;
    protected $studentRepository;

    public function __construct(
        IInternshipRepository $internshipRepository,
        IStudentRepository $studentRepository
    ) {
        $this->internshipRepository = $internshipRepository;
        $this->studentRepository = $studentRepository;
    }

    public function getAllInternships()
    {
        return $this->internshipRepository->getAllInternships();
    }

    public function getInternshipsByStudentId(int $studentId)
    {
        return $this->internshipRepository->getInternshipsByStudentId($studentId);
    }

    public function getInternshipById(int $id)
    {
        return $this->internshipRepository->getInternshipById($id);
    }

    public function createInternship(array $data, ?UploadedFile $reportFile = null)
    {
        if ($reportFile) {
            $data['report_file'] = $reportFile->store('reports', 'public');
        }

        return $this->internshipRepository->createInternship($data);
    }

    public function updateInternship(int $id, array $data, ?UploadedFile $reportFile = null)
    {
        if ($reportFile) {
            $data['report_file'] = $reportFile->store('reports', 'public');
        }

        return $this->internshipRepository->updateInternship($id, $data);
    }

    public function deleteInternship(int $id)
    {
        return $this->internshipRepository->deleteInternship($id);
    }

    public function hasExistingInternship(int $studentId)
    {
        return $this->internshipRepository->hasExistingInternship($studentId);
    }

    public function getStudentByAccountId(int $accountId)
    {
        return $this->studentRepository->getStudentByAccountId($accountId);
    }
}