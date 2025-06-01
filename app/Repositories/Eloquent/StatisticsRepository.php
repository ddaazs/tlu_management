<?php

namespace App\Repositories\Eloquent;

use App\Models\Student;
use App\Models\Project;
use App\Models\Internship;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IStatisticsRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class StatisticsRepository extends BaseRepository implements IStatisticsRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getStatisticsByMajor(): Collection
    {
        return Project::join('students', 'projects.student_id', '=', 'students.id')
            ->select('students.major', DB::raw('count(*) as total'))
            ->groupBy('students.major')
            ->get();
    }

    public function getStatisticsByLecturer(): Collection
    {
        return Project::join('lecturers', 'projects.instructor_id', '=', 'lecturers.id')
            ->select('lecturers.full_name as lecturer_name', DB::raw('count(*) as total_students'))
            ->groupBy('lecturers.id', 'lecturers.full_name')
            ->get();
    }

    public function getStatisticsByScore(): Collection
    {
        // Since there's no score column, return an empty collection
        return new Collection();
    }

    public function getStatisticsByStatus(): Collection
    {
        return Project::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->get();
    }

    public function getProjectCount(): int
    {
        return Project::count();
    }

    public function getInternshipCount(): int
    {
        return Internship::count();
    }

    public function getSubmissionStatistics(): array
    {
        return [
            'project_count' => Project::whereNotNull('project_file')->count(),
            'internship_count' => Internship::whereNotNull('report_file')->count()
        ];
    }
}
