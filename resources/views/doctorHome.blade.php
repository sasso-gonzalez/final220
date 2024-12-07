@extends('layouts.app')
@include('layouts.navigation')
<br><br><br><br><br>
@section('content')
<div class="container">
    <h1>Welcome, Doctor!</h1>
    <p>This is the Doctor Dashboard.</p>

    <h2>Search Appointments</h2>
    <form method="GET" action="{{ route('doctorHome') }}">
        <div>
            <label for="name">Patient Name:</label>
            <input type="text" id="name" name="name" value="{{ request('name') }}" placeholder="Enter patient name">
        </div>
        <div>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="{{ request('date') }}">
        </div>
        <div>
            <label for="comment">Comment:</label>
            <input type="text" id="comment" name="comment" value="{{ request('comment') }}" placeholder="Enter comment">
        </div>
        <div>
            <label for="morningMed">Morning Med:</label>
            <input type="text" id="morningMed" name="morningMed" value="{{ request('morningMed') }}" placeholder="Enter morning medication">
        </div>
        <div>
            <label for="afternoonMed">Afternoon Med:</label>
            <input type="text" id="afternoonMed" name="afternoonMed" value="{{ request('afternoonMed') }}" placeholder="Enter afternoon medication">
        </div>
        <div>
            <label for="nightMed">Night Med:</label>
            <input type="text" id="nightMed" name="nightMed" value="{{ request('nightMed') }}" placeholder="Enter night medication">
        </div>
        <button type="submit">Search</button>
    </form>

    <h2>Past Appointments</h2>
    <table>
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Appointment Date</th>
                <th>Morning Medication</th>
                <th>Afternoon Medication</th>
                <th>Night Medication</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pastAppointments as $appointment)
                @foreach($appointment->prescriptions as $prescription)
                    <tr>
                        <td>{{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}</td>
                        <td>{{ $appointment->app_date }}</td>
                        <td>{{ $prescription->m_med }}</td>
                        <td>{{ $prescription->a_med }}</td>
                        <td>{{ $prescription->n_med }}</td>
                        <td>
                            <form method="GET" action="{{ route('patientOfDoctor', ['appointment' => $appointment->appointment_id]) }}">
                                <button type="submit">View Details</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <h2>Current and Future Appointments</h2>
    <table>
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Appointment Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($currentAppointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}</td>
                    <td>{{ $appointment->app_date }}</td>
                    <td>
                        <form method="GET" action="{{ route('patientOfDoctor', ['appointment' => $appointment->appointment_id]) }}">
                            <button type="submit">View Details</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
