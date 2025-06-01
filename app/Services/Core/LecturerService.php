<?php

namespace App\Services\Core;

use App\Repositories\Contracts\ILecturerRepository;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class LecturerService
{
    protected $lecturerRepository;
    protected $userRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(
        ILecturerRepository $lecturerRepository,
        IUserRepository $userRepository
    ) {
        $this->lecturerRepository = $lecturerRepository;
        $this->userRepository = $userRepository;
    }

    public function getAllLecturers()
    {
        return $this->lecturerRepository->getAllLecturers();
    }

    public function getLecturerById(int $id)
    {
        return $this->lecturerRepository->getLecturerById($id);
    }

    public function createLecturer(array $data)
    {
        // Create user account
        $user = $this->userRepository->create([
            'name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make('password'),
            'role' => 'giangvien',
        ]);

        // Create lecturer record
        return $this->lecturerRepository->createLecturer([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'degree' => $data['degree'],
            'department_id' => $data['department_id'],
            'account_id' => $user->id,
        ]);
    }

    public function updateLecturer(int $id, array $data)
    {
        $lecturer = $this->lecturerRepository->getLecturerById($id);

        if ($lecturer->account) {
            $this->userRepository->update($lecturer->account_id, [
                'name' => $data['full_name'],
                'email' => $data['email'],
            ]);
        }

        return $this->lecturerRepository->updateLecturer($id, $data);
    }

    public function deactivateLecturer(int $id)
    {
        $lecturer = $this->lecturerRepository->getLecturerById($id);

        if ($lecturer->account) {
            $this->userRepository->update($lecturer->account_id, ['status' => 'inactive']);
        }

        return $this->lecturerRepository->deactivateLecturer($id);
    }

    public function getDepartments()
    {
        return $this->lecturerRepository->getDepartments();
    }

    public function getLecture(): Collection
    {
        return $this->lecturerRepository->getLecture();
    }
}
