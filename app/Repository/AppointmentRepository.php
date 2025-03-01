<?php

namespace App\Repository;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppointmentRepository
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
        return Appointment::with(['doctor', 'patient'])->orderBy('book')->get();
    }
    public function getDoctor()
    {
        return User::find(Auth::user()->id)->appointments()->with(['doctor', 'patient'])->get();
    }
    public function getPatient()
    {
        return User::find(Auth::user()->id)->books()->with(['doctor', 'patient'])->get();
    }

    public function findById($id)
    {
        return Appointment::find($id);
    }

    public function create(array $data)
    {
        return Appointment::create($data);
    }

    public function update($id, array $data)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($data);
        return $appointment;
    }

    public function delete($id)
    {
        return Appointment::destroy($id);
    }
}
