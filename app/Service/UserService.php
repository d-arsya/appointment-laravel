<?php

namespace App\Service;

use App\Repository\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Create a new class instance.
     */

    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function getDoctor()
    {
        $data = $this->userRepository->getDoctor();
        return $data;
    }
    public function getPatient()
    {
        $data = $this->userRepository->getPatient();
        return $data;
    }
    public function getAllUsers()
    {
        $data = $this->userRepository->getAll()->map(function ($User) {
            return [
                "id" => $User->id,
                "doctor" => $User->doctor->name,
                "patient" => $User->patient->name,
                "book" => Carbon::parse($User->book)->isoFormat('d M y h:m'),
            ];
        })->toArray();
        return $data;
    }

    public function getUserById($id)
    {
        return $this->userRepository->findById($id);
    }

    public function createUser(Request $data)
    {
        $form = $data->validate([
            "doctor_id" => "required|number",
            "patient_id" => "required|number",
            "time" => "required|number",
            "date" => "required|date"
        ]);
        dd($form);
        return $this->userRepository->create($form);
    }

    public function updateUser($id, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }
}
