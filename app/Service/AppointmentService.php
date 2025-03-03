<?php

namespace App\Service;

use App\Repository\AppointmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentService
{
    /**
     * Create a new class instance.
     */
    protected AppointmentRepository $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function getAllAppointments()
    {
        if (Auth::user()->role == 'doctor') {
            $data = $this->appointmentRepository->getDoctor();
        } else {
            $data = $this->appointmentRepository->getPatient();
        }

        return $data;
    }

    public function getAppointmentById($id)
    {
        return $this->appointmentRepository->findById($id);
    }

    public function createAppointment(Request $data)
    {
        $form = $data->validate([
            'doctor_id' => 'required|integer',
            'patient_id' => 'required|integer',
            'time' => 'required|integer',
            'date' => 'required|date',
        ]);
        $form['book'] = $data['date'].' '.$data['time'].':00:00';

        return $this->appointmentRepository->create($form);
    }

    public function updateAppointment(Request $request, int $appointment)
    {
        $data = $request->all();
        $data['book'] = $data['date'].' '.$data['time'].':00:00';

        return $this->appointmentRepository->update($appointment, $data);
    }

    public function deleteAppointment($id)
    {
        return $this->appointmentRepository->delete($id);
    }
}
