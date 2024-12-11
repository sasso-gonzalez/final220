<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .past-container{
        max-height: 400px; 
        overflow-y: auto; 
        border: 1px solid #ccc;
    }
    .future-container{
        max-height: 400px; 
        overflow-y: auto; 
        border: 1px solid #ccc;
    }
    h1, h2 {
        color: #333;
        font-family: 'Arial', sans-serif;
    }

    h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    h2 {
        font-size: 1.8rem;
        margin-top: 30px;
        margin-bottom: 15px;
    }

    .search-container {
        max-width: 900px;
        margin: 0 auto 30px;
        background: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .form-row > div {
        flex: 1;
        margin-right: 10px;
    }

    .form-row > div:last-child {
        margin-right: 0;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #555;
    }

    input[type="text"], input[type="date"] {
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }

    button[type="submit"] {
        padding: 10px 20px;
        font-size: 1rem;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: #fff;
    }

    thead {
        background-color: #0056b3;
        color: #fff;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        position: sticky; 
        top: 0;
        z-index: 1;
    }
    tbody{
        color:black;
    }
    tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tbody tr:hover {
        background-color: lightgrey;
    }

    table button[type="submit"] {
        padding: 5px 10px;
        font-size: 0.9rem;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
    }

    table button[type="submit"]:hover {
        background-color: #0056b3;
    }

    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }

        .search-container {
            max-width: 100%;
        }

        .form-row {
            flex-direction: column;
        }

        .form-row > div {
            margin-right: 0;
            margin-bottom: 10px;
        }

        table th, table td {
            font-size: 0.9rem;
            padding: 8px;
        }

        button[type="submit"], table button[type="submit"] {
            font-size: 0.8rem;
            padding: 8px 15px;
        }
    }
</style>

@extends('layouts.app')
@include('layouts.navigation')
<br><br><br>

@section('content')
<br><br><br>
<div class="container">
    <h1>Welcome, Doctor!</h1>
    <div class="search-container">
    <h2>Search Appointments</h2>
    <br>
        <form method="GET" action="{{ route('doctorHome') }}">
            <div class="form-row">
                <div>
                    <label for="name">Patient Name:</label>
                    <input type="text" id="name" name="name" value="{{ request('name') }}" placeholder="Enter patient name">
                </div>
                <div>
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" value="{{ request('date') }}">
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="comment">Comment:</label>
                    <input type="text" id="comment" name="comment" value="{{ request('comment') }}" placeholder="Enter comment">
                </div>
                <div>
                    <label for="morningMed">Morning Med:</label>
                    <input type="text" id="morningMed" name="morningMed" value="{{ request('morningMed') }}" placeholder="Enter morning medication">
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="afternoonMed">Afternoon Med:</label>
                    <input type="text" id="afternoonMed" name="afternoonMed" value="{{ request('afternoonMed') }}" placeholder="Enter afternoon medication">
                </div>
                <div>
                    <label for="nightMed">Night Med:</label>
                    <input type="text" id="nightMed" name="nightMed" value="{{ request('nightMed') }}" placeholder="Enter night medication">
                </div>
            </div>
            <button type="submit">Search</button>
        </form>
    </div>

    <h2>Past Appointments</h2>
    <div class="past-container">
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
    </div>
    <h2>Current and Future Appointments</h2>
    <div class="future-container">
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
</div>
@endsection