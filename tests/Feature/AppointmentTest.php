<?php

use App\Models\Appointment;
use App\Models\User;

beforeEach(function () {
    $this->doctor = User::factory()->create(['role' => 'doctor']);
    $this->patient = User::factory()->create(['role' => 'patient']);
    $this->appointmentData = ['doctor_id' => $this->doctor->id, 'patient_id' => $this->patient->id, 'book' => now(), 'deleted_at' => null];
});

function actingAsDoctor()
{
    return test()->actingAs(test()->doctor);
}

function actingAsPatient()
{
    return test()->actingAs(test()->patient);
}

test('doctor must not see create appointment button', function () {
    actingAsDoctor()->get('/appointment')
        ->assertStatus(200)
        ->assertDontSee('Buat Janji Temu');
});

test('patient must see create appointment button', function () {
    actingAsPatient()->get('/appointment')
        ->assertStatus(200)
        ->assertSee('Buat Janji Temu');
});

test('user see blank appointment', function () {
    actingAsPatient()->get('/appointment')
        ->assertStatus(200)
        ->assertSee('belum ada janji temu');
});

test('doctor must not see cancel appointment button', function () {
    Appointment::factory()->create($this->appointmentData);
    actingAsDoctor()->get('/appointment')
        ->assertStatus(200)
        ->assertDontSee('Batalkan');
});

test('patient must see cancel appointment button', function () {
    Appointment::factory()->create($this->appointmentData);
    actingAsPatient()->get('/appointment')
        ->assertStatus(200)
        ->assertSee('Batalkan');
});

test('doctor must see patient column', function () {
    Appointment::factory()->create($this->appointmentData);
    actingAsDoctor()->get('/appointment')
        ->assertStatus(200)
        ->assertSee('Pasien');
});

test('patient must not see patient column', function () {
    Appointment::factory()->create($this->appointmentData);
    actingAsPatient()->get('/appointment')
        ->assertStatus(200)
        ->assertDontSee('Pasien');
});

test('patient can see create appointment form', function () {
    actingAsPatient()->get('/appointment/create')
        ->assertStatus(200)
        ->assertSee($this->doctor->name)
        ->assertSee('Buat jadwal janji temu anda');
});

test('patient can create new appointment', function () {
    actingAsPatient()->post('/appointment', [
        'doctor_id' => $this->doctor->id,
        'patient_id' => $this->patient->id,
        'time' => 17,
        'date' => now(),
    ])->assertRedirect('/appointment');

    expect(Appointment::count())->toBe(1);
});

test('patient can cancel appointment', function () {
    $appointment = Appointment::factory()->create($this->appointmentData);
    actingAsPatient()->delete("/appointment/{$appointment->id}")
        ->assertRedirect('/appointment');

    expect(Appointment::count())->toBe(0);
});

test('patient can see edit appointment form', function () {
    $appointment = Appointment::factory()->create($this->appointmentData);
    actingAsPatient()->get("/appointment/{$appointment->id}/edit")
        ->assertStatus(200)
        ->assertSee($this->doctor->name)
        ->assertSee($appointment->time);
});

test('patient can edit appointment', function () {
    $appointment = Appointment::factory()->create($this->appointmentData);
    actingAsPatient()->put("/appointment/{$appointment->id}", [
        'doctor_id' => 17,
        'patient_id' => $this->patient->id,
        'time' => 17,
        'date' => now(),
    ])->assertRedirect('/appointment');
    expect($appointment->fresh()->doctor_id)->toBe(17);
});
