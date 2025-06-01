<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface IStatisticsRepository
{
    public function getStatisticsByMajor(): Collection;
    public function getStatisticsByLecturer(): Collection;
    public function getStatisticsByStatus(): Collection;
    public function getProjectCount(): int;
    public function getInternshipCount(): int;
}
