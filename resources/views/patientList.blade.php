<style>

.container {
    max-width: 1300px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}
.patient-container{
    max-height: 400px; 
    overflow-y: auto; 
    border: 1px solid #ccc;
}
th {
    background-color: #f4f4f4;
    position: sticky; 
    top: 0;
    z-index: 1;
}
h1 {
    text-align: center;
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
}

.patientlist {
    margin-bottom: 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: space-between;
    background-color: #ffffff;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.patientlist div {
    flex: 1 1 220px;
}

.patientlist label {
    font-weight: bold;
    color: #555;
    display: block;
    margin-bottom: 5px;
}

.patientlist input {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.patientlist button {
    margin-top:auto;
    align-self: bottom;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

 button:hover {
    background-color: #0056b3;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table thead th {
    background-color: #0056b3;
    color: white;
    padding: 10px;
    font-size: 14px;
    text-align: left;
}

table tbody td {
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 14px;
    color:black;
}

table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tbody tr:hover {
    background-color: lightgrey;
}

table tbody td a {
    color: #007bff;
    text-decoration: none;
}

table tbody td a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    form {
        flex-direction: column;
        align-items: stretch;
    }

    form div {
        flex: 1 1 100%;
    }

    h1 {
        font-size: 24px;
    }

    table tbody td {
        font-size: 12px;
    }

    form button {
        font-size: 12px;
        padding: 8px 12px;
    }
}
</style>

@extends('layouts.app')
@include('layouts.navigation')
<br><br><br>
<link href="{{ asset('../CSS/customerHomes.css') }}" rel="stylesheet">

@section('content')
<br><br><br>
    <div class="container">
        <h1>Patient List</h1>
        <form class="patientlist" method="GET" action="{{ route('patientList') }}">
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
        <div class="patient-container">
        <table> 
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Emergency Contact</th>
                    <th>Emergency Contact Relation</th>
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
    </div>
@endsection