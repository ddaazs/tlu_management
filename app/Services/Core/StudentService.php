<?php

namespace App\Services\Core;

use App\Repositories\Eloquent\StudentRepository;

class StudentService
{
    public $studentRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function getStudent()
    {
        return $this->studentRepository->getAll(['*']);
    }

    public function getStudentById($id)
    {
        return $this->studentRepository->getById($id);

    }
}
