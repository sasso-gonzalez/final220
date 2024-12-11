<style>
    /* public/css/appointmentDetails.css */

.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
}

h3 {
    color: #555;
    font-size: 20px;
    margin-top: 30px;
    margin-bottom: 10px;
}

p {
    font-size: 16px;
    color: #555;
}

.table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

.table thead th {
    background-color: #0056b3;
    color: white;
    padding: 10px;
    text-align: left;
}

.table tbody td {
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 14px;
    color:black;
}

.table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.table tbody tr:hover {
    background-color: lightgrey;
}

.form-group {
    margin-bottom: 15px;
}

label {
    font-weight: bold;
    color: #555;
    display: block;
    margin-bottom: 5px;
}

textarea.form-control, input.form-control {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

textarea.form-control {
    min-height: 100px;
}

button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    margin-right: 10px;
}

button:hover {
    background-color: #0056b3;
}

a.btn-danger {
    padding: 10px 20px;
    background-color: #dc3545;
    text-decoration: none;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    margin-right: 10px;
}

a.btn-danger:hover {
    background-color: #c82333;
}

.alert.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    padding: 10px;
    border-radius: 5px;
    margin-top: 20px;
}

.alert.alert-danger ul {
    margin: 0;
    padding: 0;
}

.alert.alert-danger ul li {
    list-style: none;
}

@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    h1 {
        font-size: 24px;
    }

    h3 {
        font-size: 18px;
    }

    .table tbody td {
        font-size: 12px;
    }

    button {
        font-size: 12px;
        padding: 8px 12px;
    }

    textarea.form-control {
        min-height: 80px;
    }
}
</style>
@extends('layouts.app')
@include('layouts.navigation')
<br><br><br>

@section('content')
<br><br><br>
    <div class="container">
        <h1>Appointment Details</h1>

        <p>Patient: {{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}</p>
        <p>Date: {{ $appointment->app_date }}</p>

        <h3>Previous Prescriptions</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Comment</th>
                    <th>Morning Med</th>
                    <th>Afternoon Med</th>
                    <th>Night Med</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patientAppointments as $appt)
                    @if($appt->prescriptions->isNotEmpty())
                        @php
                            $prescription = $appt->prescriptions->first();
                        @endphp
                        <tr>
                            <td>{{ $prescription->created_at->toDateString() }}</td>
                            <td>{{ $prescription->doc_notes }}</td>
                            <td>{{ $prescription->m_med }}</td>
                            <td>{{ $prescription->a_med }}</td>
                            <td>{{ $prescription->n_med }}</td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="5">No previous prescriptions.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3>New Prescription</h3>
        <form action="{{ route('prescriptions.save', $appointment->appointment_id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="doc_notes">Comment</label>
                <textarea id="doc_notes" name="doc_notes" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="m_med">Morning Medicine</label>
                <input id="m_med" name="m_med" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="a_med">Afternoon Medicine</label>
                <input id="a_med" name="a_med" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="n_med">Night Medicine</label>
                <input id="n_med" name="n_med" type="text" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Ok</button>
            <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
        </form>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection