@extends('layouts.app')
@include('layouts.navigation')
<br><br><br><br>
@section('content')
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