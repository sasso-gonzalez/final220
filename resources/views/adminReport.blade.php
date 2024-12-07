@extends('layouts.app')
@include('layouts.navigation')
<br><br><br><br><br><br><br><br><br>

@section('content')
    <div class="container">
        <h1>Admin Report</h1>

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
                        <th>Patient Name</th>
                        <th>Caregiver Name</th>
                        <th>Date</th>
                        <th>Morning Medicine</th>
                        <th>Afternoon Medicine</th>
                        <th>Night Medicine</th>
                        <th>Breakfast</th>
                        <th>Lunch</th>
                        <th>Dinner</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($missedActivities as $activity)
                        <tr>
                            <td>{{ $activity->patient->user->first_name }} {{ $activity->patient->user->last_name }} ({{ $activity->patient_id }})</td>
                            <td></td>
                            <td>{{ $activity->employee->user->first_name }} {{ $activity->employee->user->last_name }} ({{ $activity->caregiver_id }})</td>
                            <td>{{ $activity->particular_date }}</td>
                            <td>{{ $activity->m_med ? 'Yes' : 'No' }}</td>
                            <td>{{ $activity->a_med ? 'Yes' : 'No' }}</td>
                            <td>{{ $activity->n_med ? 'Yes' : 'No' }}</td>
                            <td>{{ $activity->breakfast ? 'Yes' : 'No' }}</td>
                            <td>{{ $activity->lunch ? 'Yes' : 'No' }}</td>
                            <td>{{ $activity->dinner ? 'Yes' : 'No' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection