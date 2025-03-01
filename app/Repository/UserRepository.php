<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{
    /**
     * Create a new class instance.
     */
    // public function __construct()
    // {
    //     //
    // }
    public function getAll()
    {
        return User::all();
    }
    public function getDoctor()
    {
        return User::where('role', 'doctor')->get();
    }
    public function getPatient()
    {
        return User::where('role', 'patient')->get();
    }

    public function findById($id)
    {
        return User::find($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        return User::destroy($id);
    }
}
