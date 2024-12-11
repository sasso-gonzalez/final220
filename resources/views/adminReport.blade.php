<style>

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    font-size: 26px;
    color: #333;
    margin-bottom: 20px;
}

form {
    margin-bottom: 20px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 10px;
    width: 100%;
    max-width: 300px;
}

.form-group label {
    font-size: 14px;
    font-weight: bold;
    color: #555;
    margin-bottom: 5px;
}

.form-group input[type="date"] {
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
    box-sizing: border-box;
}

button {
    padding: 10px 15px;
    font-size: 14px;
    border: none;
    border-radius: 5px;
    background-color: #007BFF;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #fff;
}

table thead {
    background-color: #0056b3;
    color: white;
}

table th,
table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
    font-size: 14px;
}

table th {
    font-weight: bold;
}
table tbody{
    color: black;
}

table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}
table tbody tr:hover {
    background-color: lightgrey;
}


p {
    text-align: center;
    font-size: 16px;
    color: #888;
    margin-top: 20px;
}

input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    form {
        flex-direction: column;
        align-items: flex-start;
    }

    .form-group {
        width: 100%;
    }

    table th,
    table td {
        font-size: 12px;
        padding: 8px;
    }
}

</style>
@extends('layouts.app')
@include('layouts.navigation')
<br><br><br>

@section('content')
<br><br><br>
    <div class="container">
        <h1>Daily Report</h1>

        <form method="GET" action="{{ route('admin.report') }}">
            <div class="form-group">
                <label for="date">Filter by Date:</label>
                <input type="date" id="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        @if($missedActivities->isEmpty())
            <p>No missed activities found.</p>
        @else
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Patient Name (ID)</th>
                        <th>Caregiver Name</th>
                        <th>Date</th>
                        <th>Morning Medicine</th>
                        <th>Afternoon Medicine</th>
                        <th>Night Medicine</th>
                        <th>Breakfast</th>
                        <th>Lunch</th>
                        <th>Dinner</th>
                        <th>Doctor</th>
                        <th>Appointment Status</th>
                        <th>Prescription Status</th>
                        <th>Attended</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($missedActivities as $activity)
                        <tr>
                            <td>{{ $activity->patient->user->first_name }} {{ $activity->patient->user->last_name }} ({{ $activity->patient_id }})</td>
                            <td>{{ $activity->employee->user->first_name }} {{ $activity->employee->user->last_name }} ({{ $activity->caregiver_id }})</td>
                            <td>{{ $activity->particular_date }}</td>
                            <td>{{ $activity->m_med ? 'Yes' : 'No' }}</td>
                            <td>{{ $activity->a_med ? 'Yes' : 'No' }}</td>
                            <td>{{ $activity->n_med ? 'Yes' : 'No' }}</td>
                            <td>{{ $activity->breakfast ? 'Yes' : 'No' }}</td>
                            <td>{{ $activity->lunch ? 'Yes' : 'No' }}</td>
                            <td>{{ $activity->dinner ? 'Yes' : 'No' }}</td>
                            <td>{{ $activity->doctorUser ? $activity->doctorUser->first_name . ' ' . $activity->doctorUser->last_name : 'N/A' }}</td>
                            <td>{{ $activity->latestAppointment ? 'Scheduled' : 'Not Scheduled' }}</td>
                            <td>{{ $activity->prescriptionsGiven ? 'Given' : 'Not Given' }}</td>
                            <td><input type="checkbox" {{ $activity->attended ? 'checked' : '' }} disabled></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection