@extends('layouts.app')
@include('layouts.navigation')
<br><br><br><br><br><br><br><br>
@section('content')
<div class="container">
    <h1>Family Member's Home</h1>
    <p>Please fill both family code and patient ID to see patient details.</p>

    <form id="familyForm" method="POST" action="{{ route('family.details') }}">
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
        <h2>Patient Information</h2>
        <p>Name: {{ $patientInfo->first_name }} {{ $patientInfo->last_name }}</p>
        <p>Caregroup: {{ $patientInfo->caregroup }}</p>
        <!-- <p>Admission Date: {{ $patientInfo->admission_date }}</p> -->
        <!-- <p>Amount Due: {{ $patientInfo->amount_due }}</p> -->

        @if ($schedule && $schedule->isNotEmpty())
            <h2>Patient Schedule for {{ $date }}</h2>
            <table class="table">
                <thead>
                    <tr>
                        <!-- <th>Date</th> -->
                        <th>Morning Medicine</th>
                        <th>Afternoon Medicine</th>
                        <th>Night Medicine</th>
                        <th>Breakfast</th>
                        <th>Lunch</th>
                        <th>Dinner</th>
                        <th>Caregiver</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedule as $item)
                        <tr>
                            <!-- <td>{{ $item->particular_date }}</td> -->
                            <td><input type="checkbox" {{ $item->m_med ? 'checked' : '' }} disabled></td>
                            <td><input type="checkbox" {{ $item->a_med ? 'checked' : '' }} disabled></td>
                            <td><input type="checkbox" {{ $item->n_med ? 'checked' : '' }} disabled></td>
                            <td><input type="checkbox" {{ $item->breakfast ? 'checked' : '' }} disabled></td>
                            <td><input type="checkbox" {{ $item->lunch ? 'checked' : '' }} disabled></td>
                            <td><input type="checkbox" {{ $item->dinner ? 'checked' : '' }} disabled></td>
                            <td>{{ $item->caregiver_first_name }} {{ $item->caregiver_last_name }}</td>
                        </tr>
                    @endforeach
                </tbody>                
            </table>
            <div>
                <a href="{{ route('familyHome', ['id' => $user->id]) }}">Return to Form</a>
            </div>
        @else
            <p>No schedule found for this patient on {{ $date }}.</p>
        @endif
    @endif
</div>
@endsection
