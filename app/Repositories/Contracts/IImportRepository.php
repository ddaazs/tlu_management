<?php

namespace App\Repositories\Contracts;

interface IImportRepository
{
    /**
     * Import students from Excel file
     */
    public function importStudents(array $data): void;

    /**
     * Import lecturers from Excel file
     */
    public function importLecturers(array $data): void;
}
