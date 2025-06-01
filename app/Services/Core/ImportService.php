<?php

namespace App\Services\Core;

use App\Repositories\Contracts\IImportRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;
use App\Imports\LecturerImport;

class ImportService
{
    protected $importRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(IImportRepository $importRepository)
    {
        $this->importRepository = $importRepository;
    }

    /**
     * Import students from Excel file
     */
    public function importStudents($file): void
    {
        Excel::import(new StudentImport($this->importRepository), $file);
    }

    /**
     * Import lecturers from Excel file
     */
    public function importLecturers($file): void
    {
        Excel::import(new LecturerImport($this->importRepository), $file);
    }
}
