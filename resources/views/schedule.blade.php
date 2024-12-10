@extends('layouts.app')
@include('layouts.navigation')
<br><br><br>
@section('content')
    <div class="container">
        <h1>Patient Schedule</h1>

        @if($schedule)
            <h2>Schedule for {{ $schedule->patient->user->first_name }} {{ $schedule->patient->user->last_name }} on {{ $schedule->particular_date }}</h2>
            <form action="{{ route('caregiver.saveSchedule') }}" method="POST">
                @csrf
                <input type="hidden" name="patient_id[]" value="{{ $schedule->patient_id }}">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Medication</th>
                            <th>Meal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Morning</td>
                            <td><input type="checkbox" name="m_med[]" value="{{ $schedule->patient_id }}" {{ $schedule->m_med ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="breakfast[]" value="{{ $schedule->patient_id }}" {{ $schedule->breakfast ? 'checked' : '' }}></td>
                        </tr>
                        <tr>
                            <td>Afternoon</td>
                            <td><input type="checkbox" name="a_med[]" value="{{ $schedule->patient_id }}" {{ $schedule->a_med ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="lunch[]" value="{{ $schedule->patient_id }}" {{ $schedule->lunch ? 'checked' : '' }}></td>
                        </tr>
                        <tr>
                            <td>Night</td>
                            <td><input type="checkbox" name="n_med[]" value="{{ $schedule->patient_id }}" {{ $schedule->n_med ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="dinner[]" value="{{ $schedule->patient_id }}" {{ $schedule->dinner ? 'checked' : '' }}></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Submit Button -->
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Save Schedule</button>
                </div>
            </form>
        @else
            <p>No schedule found for this patient.</p>
        @endif

        <a href="{{ route('caregiverHome', ['id' => $schedule->employee->user->id]) }}" class="btn btn-secondary">Back to Home</a>
    </div>
@endsection