@extends('layouts.app')
@include('layouts.navigation')
<link rel="stylesheet" href="{{ asset('CSS/employeesHomes.css') }}">
<br><br><br>

@section('content')
<br><br><br>
    <div class="container caregiver-dashboard">
        <h1>Caregiver Home</h1>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Patient Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr>
                        <td>{{ $patient->patient_id }}</td>
                        <td>{{ $patient->user->first_name }} {{ $patient->user->last_name }}</td>
                        <td>
                            <a href="{{ route('caregiver.schedule', ['id' => $patient->patient_id]) }}" style="text-decoration:none;" class="btn btn-primary">Go to Schedule</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No patients found for this caregiver.</td>
                    </tr>
                @endforelse 
            </tbody>
        </table>
    </div>
@endsection