<style>
    .container {
        max-width: 1500px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        color:black;
    }
    
    .ok {
        background-color: #4CAF50;
        color: white;
    }

    .ok:hover {
        background-color: #45a049;
    }

    .cancel {
        background-color: #f44336;
        color: white;
    }

    .cancel:hover {
        background-color: #e53935;
    }

    @media (max-width: 600px) {
        #familyForm {
            padding: 15px;
        }

        #familyForm .actions {
            flex-direction: column;
            align-items: center;
        }

        #familyForm button {
            width: 100%;
            margin-bottom: 10px;
        }
    }

    .table-container {
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 100%;
        max-width: 1000px; 
        margin: 20px auto;
        overflow-x: auto; 
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;

    }

    .table th, .table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    .table th {
        background-color: #0056b3;
        font-weight: bold;
        color:white;
    }

    .patient-info {
        margin-top: 20px;
        color:black;
    }
    tr {
        font-size:20;
        color:black;
    }

    .return-link {
        margin-top: 20px;
        text-align: center;
    }

    .return-link a {
        color: #007bff;
        text-decoration: none;
    }

    .return-link a:hover {
        text-decoration: underline;
    }
    input[type='checkbox']{
    height: 25px;
    width: 25px;
    border-radius: 4px black;
    }
</style>

@extends('layouts.app')
@include('layouts.navigation')
<br><br><br>
@php
    $firstName = $user->first_name;
    $lastName = $user->last_name;
@endphp

@section('content')
<br><br><br>
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