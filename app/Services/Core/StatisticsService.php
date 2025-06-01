<?php

namespace App\Services\Core;

use App\Repositories\Contracts\IStatisticsRepository;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;

class StatisticsService
{
    protected $statisticsRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(IStatisticsRepository $statisticsRepository)
    {
        $this->statisticsRepository = $statisticsRepository;
    }

    public function getAllStatistics(): array
    {
        return [
            'byMajor' => $this->statisticsRepository->getStatisticsByMajor(),
            'byLecturer' => $this->statisticsRepository->getStatisticsByLecturer(),
            'byScore' => $this->statisticsRepository->getStatisticsByScore(),
            'byStatus' => $this->statisticsRepository->getStatisticsByStatus(),
            'submission' => [
                'projectCount' => $this->statisticsRepository->getProjectCount(),
                'internshipCount' => $this->statisticsRepository->getInternshipCount()
            ]
        ];
    }

    public function generatePdf(string $view, array $data): PDF
    {
        return PDF::loadView($view, $data);
    }
}
