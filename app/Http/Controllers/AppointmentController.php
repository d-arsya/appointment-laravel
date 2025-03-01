<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Service\AppointmentService;
use App\Service\UserService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected AppointmentService $appointmentService;
    protected UserService $userService;

    public function __construct(AppointmentService $appointmentService, UserService $userService)
    {
        $this->appointmentService = $appointmentService;
        $this->userService = $userService;
    }
    public function index()
    {
        $appointments = $this->appointmentService->getAllAppointments();
        // dd($appointments);
        return view('appointment.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = $this->userService->getDoctor();
        $patients = $this->userService->getPatient();
        return view('appointment.create', compact('doctors', 'patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->appointmentService->createAppointment($request);
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $appointment)
    {
        $appointment = $this->appointmentService->getAppointmentById($appointment);
        $doctors = $this->userService->getDoctor();
        $patients = $this->userService->getPatient();
        return view('appointment.edit', compact('appointment', 'doctors', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $appointment)
    {
        $this->appointmentService->updateAppointment($request, $appointment);
        return to_route('appointment.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $appointment)
    {
        $this->appointmentService->deleteAppointment($appointment);
        return back();
    }
}
