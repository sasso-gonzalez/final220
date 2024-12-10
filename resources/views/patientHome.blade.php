@extends('layouts.app')
@include('layouts.navigation')
<link href="{{ asset('css/customerHomes.css') }}" rel="stylesheet">
<br><br><br>
@php
    $firstName = $user->first_name;
    $lastName = $user->last_name;
@endphp

@section('content')
<div class="container">
    <h1>Welcome, {{ $firstName }} {{ $lastName }}!</h1>
    <h2>Patient ID: {{$patient->patient_id}}</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Time</th>
                <th>Medication</th>
                <th>Meal</th>
                <th>Doctor</th>
                <th>Appointment</th>
                <th>Prescription</th>
                <th>Attended</th>
            </tr>
        </thead>
        <tbody>
        @if($patient->patientSchedules->isEmpty())
            <tr>
                <td colspan="7">No schedule available for today. Please try again later.</td>
            </tr>
        @else
            @foreach($patient->patientSchedules as $schedule)
                <tr>
                    <td>Morning</td>
                    <td><input type="checkbox" name="m_med[]" value="{{ $schedule->id }}" {{ $schedule->m_med ? 'checked' : '' }} disabled></td>
                    <td><input type="checkbox" name="breakfast[]" value="{{ $schedule->id }}" {{ $schedule->breakfast ? 'checked' : '' }} disabled></td>
                    @if ($loop->first)
                        <td rowspan="{{ $patient->patientSchedules->count() }}">
                            {{ $doctorUser ? $doctorUser->first_name . ' ' . $doctorUser->last_name : 'N/A' }}
                        </td>
                        <td rowspan="{{ $patient->patientSchedules->count() }}">
                            {{ $latestAppointment ? 'Scheduled' : 'Not Scheduled' }}
                        </td>
                        <td rowspan="{{ $patient->patientSchedules->count() }}">
                            {{ $latestAppointment && $latestAppointment->prescriptions->isNotEmpty() ? 'Given' : 'Not Given' }}
                        </td>
                        <td rowspan="{{ $patient->patientSchedules->count() }}">
                            <input type="checkbox" name="attended" value="1" {{ $attended ? 'checked' : '' }} disabled>
                        </td>
                    @endif
                </tr>
                <tr>
                    <td>Afternoon</td>
                    <td><input type="checkbox" name="a_med[]" value="{{ $schedule->id }}" {{ $schedule->a_med ? 'checked' : '' }} disabled></td>
                    <td><input type="checkbox" name="lunch[]" value="{{ $schedule->id }}" {{ $schedule->lunch ? 'checked' : '' }} disabled></td>
                </tr>
                <tr>
                    <td>Night</td>
                    <td><input type="checkbox" name="n_med[]" value="{{ $schedule->id }}" {{ $schedule->n_med ? 'checked' : '' }} disabled></td>
                    <td><input type="checkbox" name="dinner[]" value="{{ $schedule->id }}" {{ $schedule->dinner ? 'checked' : '' }} disabled></td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
@endsection