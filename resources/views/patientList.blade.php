@extends('layouts.app')
@include('layouts.navigation')
<br><br><br><br><br><br>

@section('content')
    <div class="container">
        <h1>Patient List</h1>
        <form method="GET" action="{{ route('patientList') }}">
            <div>
                <label for="patient_id">Patient ID:</label>
                <input type="text" id="patient_id" name="patient_id" value="{{ request('patient_id') }}" placeholder="Enter patient ID">
            </div>
            <div>
                <label for="patient_name">Patient Name:</label>
                <input type="text" id="patient_name" name="name" value="{{ request('name') }}" placeholder="Enter patient name">
            </div>
            <div>
                <label for="age">Age:</label>
                <input type="text" id="age" name="age" value="{{ request('age') }}" placeholder="Enter Age">
            </div>
            <div>
                <label for="emergency_contact">Emergency Contact:</label>
                <input type="text" id="emergency_contact" name="emergency_contact" value="{{ request('emergency_contact') }}" placeholder="Contact Name">
            </div>
            <div>
                <label for="relation_emergency_contact">Emergency Contact Relation:</label>
                <input type="text" id="relation_emergency_contact" name="relation_emergency_contact" value="{{ request('relation_emergency_contact') }}" placeholder="Enter Relation">
            </div>
            <div>
                <label for="admission_date">Admission Date:</label>
                <input type="date" id="admission_date" name="admission_date" value="{{ request('admission_date') }}">
            </div>
            <div>
                <label for="additional_info">Additional Information:</label>
                <input type="text" id="additional_info" name="additionalInfo" value="{{ request('additionalInfo') }}" placeholder="Care Group">
            </div>
            <button type="submit">Search</button>
        </form>

        <table> 
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Emergency Contact</th>
                    <th>Emergency Contact Name</th>
                    <th>Admission Date</th>
                    <th>Additional Info</th>
                </tr>
            </thead>
            <tbody>
                @forelse($adminPatientList as $user)
                    <tr>
                        <td>{{ $user->patient->patient_id }}</td>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($user->date_of_birth)->age }}</td>
                        <td>{{ $user->emergency_contact }}</td>
                        <td>{{ $user->relation_emergency_contact ?? 'N/A' }}</td>
                        <td>{{ $user->patient->admission_date ?? 'N/A' }}</td>
                        <td>
                            @if ($user->patient->caregroup == null)
                                <a href="{{ route('additionalInfo', ['id'=>$user->patient->patient_id]) }}">Additional Details Page</a>
                            @else
                                Caregroup Assigned: {{ $user->patient->caregroup }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No patients found matching the filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection