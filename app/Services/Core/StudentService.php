<?php

namespace App\Services\Core;

use App\Repositories\Contracts\IStudentRepository;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class StudentService
{
    protected $studentRepository;
    protected $userRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(
        IStudentRepository $studentRepository,
        IUserRepository $userRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
    }

    public function getStudents(int $perPage = 5): LengthAwarePaginator
    {
        return $this->studentRepository->paginate($perPage);
    }

    public function searchStudents(array $filters): \Illuminate\Database\Eloquent\Collection
    {
        $query = $this->studentRepository->query();

        if (!empty($filters['full_name'])) {
            $query->where('full_name', 'like', "%{$filters['full_name']}%");
        }

        if (!empty($filters['class'])) {
            $query->where('class', 'like', "%{$filters['class']}%");
        }

        if (!empty($filters['major'])) {
            $query->where('major', 'like', "%{$filters['major']}%");
        }

        return $query->get();
    }

    public function getStudentById(string|int $id)
    {
        return $this->studentRepository->find((int) $id);
    }

    public function getStudentByAccountId(int $accountId)
    {
        return $this->studentRepository->getStudentByAccountId($accountId);
    }

    public function createStudent(array $data)
    {
        // Create user account
        $user = $this->userRepository->create([
            'name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make('password'),
            'role' => 'sinhvien',
        ]);

        // Create student record
        return $this->studentRepository->createStudent([
            'account_id' => $user->id,
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'class' => $data['class'],
            'major' => $data['major'],
        ]);
    }

    public function updateStudent(string|int $id, array $data): bool
    {
        return $this->studentRepository->update((int) $id, $data);
    }

    public function deleteStudent(string|int $id): bool
    {
        return $this->studentRepository->delete((int) $id);
    }

    public function getAllStudents()
    {
        return $this->studentRepository->getAllStudents();
    }

    public function getStudent(): Collection
    {
        return $this->studentRepository->getStudent();
    }
}
