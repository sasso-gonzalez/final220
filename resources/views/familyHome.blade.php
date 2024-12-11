<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    #familyForm {
        background-color: #f9f9f9;
        color:black;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
    }

    #familyForm .form-group {
        margin-bottom: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #familyForm label {
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 14px;
        text-align: center;
    }

    #familyForm input {
        width: 100%;
        max-width: 400px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    #familyForm .actions {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        width: 100%;
    }

    #familyForm button {
        width: 45%;
        padding: 10px;
        font-size: 14px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .ok {
        background-color: #007bff;
        color: white;
    }

    .ok:hover {
        background-color: #0056b3;
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
        color:black;
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
    }
    .table td {
        color:black;
    }
    .table td:hover{
        background-color:lightblue;
    }

    .patient-info {
        margin-top: 20px;
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
    height: 20px;
    width: 20px;
    border-radius: 4px black;
    }

</style>
@extends('layouts.app')
@include('layouts.navigation')
<br><br><br>

@section('content')
<br><br><br>

<div class="container">
    <form id="familyForm" method="POST" action="{{ route('family.details') }}">
        <h2>Patient Info</h2>
        <p>Please fill both family code and patient ID to see patient details.</p>
        @csrf
        <div class="form-group">
            <label for="family_code">Family Code (For Patient Family Member)</label>
            <input type="number" id="family_code" name="family_code" required>
        </div>

        <div class="form-group">
            <label for="patient_id">Patient ID (For Patient Family Member)</label>
            <input type="number" id="patient_id" name="patient_id" required>
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" required>
        </div>

        <div class="actions">
            <button type="submit" class="ok">Ok</button>
            <button type="reset" class="cancel">Cancel</button>
        </div>
    </form>

    @if (isset($patientInfo))
        <script>
            document.getElementById('familyForm').style.display = 'none';
        </script>
        <div class="table-container">
            <h2>Patient Schedule</h2>
            <p><strong>Name:</strong> {{ $patientInfo->first_name }} {{ $patientInfo->last_name }}</p>
            <p><strong>ID:</strong> {{ $patientInfo->patient_id }}</p>
            <p><strong>Caregroup:</strong> {{ $patientInfo->caregroup }}</p>

            @if ($schedule && $schedule->isNotEmpty())
                <h2>Patient Schedule for {{ $date }}</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Morning Medicine</th>
                                <th>Afternoon Medicine</th>
                                <th>Night Medicine</th>
                                <th>Breakfast</th>
                                <th>Lunch</th>
                                <th>Dinner</th>
                                <th>Caregiver</th>
                                <th>Doctor</th>
                                <th>Appointment Status</th>
                                <th>Prescription Status</th>
                                <th>Attended</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedule as $item)
                                <tr>
                                    <td><input type="checkbox" {{ $item->m_med ? 'checked' : '' }} disabled></td>
                                    <td><input type="checkbox" {{ $item->a_med ? 'checked' : '' }} disabled></td>
                                    <td><input type="checkbox" {{ $item->n_med ? 'checked' : '' }} disabled></td>
                                    <td><input type="checkbox" {{ $item->breakfast ? 'checked' : '' }} disabled></td>
                                    <td><input type="checkbox" {{ $item->lunch ? 'checked' : '' }} disabled></td>
                                    <td><input type="checkbox" {{ $item->dinner ? 'checked' : '' }} disabled></td>
                                    <td>{{ $item->caregiver_first_name }} {{ $item->caregiver_last_name }}</td>
                                    @if ($loop->first)
                                        <td rowspan="{{ $schedule->count() }}">{{ $doctorUser ? $doctorUser->first_name . ' ' . $doctorUser->last_name : 'N/A' }}</td>
                                        <td rowspan="{{ $schedule->count() }}">{{ $latestAppointment ? 'Scheduled' : 'Not Scheduled' }}</td>
                                        <td rowspan="{{ $schedule->count() }}">{{ $prescriptionsGiven ? 'Given' : 'Not Given' }}</td>
                                        <td rowspan="{{ $schedule->count() }}"><input type="checkbox" {{ $attended ? 'checked' : '' }} disabled></td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>                
                    </table>
                </div>
                <div class="return-link">
                    <a href="{{ route('familyHome', ['id' => $user->id]) }}">Return to Form</a>
                </div>
            @else
                <p>No schedule found for this patient on {{ $date }}.</p>
            @endif
        </div>
    @endif
</div>
@endsection