<style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #f9f9f9;
    color: #333;
    margin: 0;
    padding: 0;
    line-height: 1.6;
}

.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1, h2, h3 {
    font-weight: bold;
    color: #2d3b45;
}

h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

p.text-muted {
    font-size: 14px;
    color: #6c757d;
    margin-top: 20px;
}

form .form-group {
    margin-bottom: 20px;
}

form .form-control {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    font-size: 14px;
}

form .form-control:focus {
    border-color: #4db8ff;
    box-shadow: 0 0 4px rgba(77, 184, 255, 0.5);
}

form label {
    font-weight: bold;
    color: #333;
}

.btn {
    padding: 10px 20px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    text-transform: uppercase;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-success {
    background-color: #28a745;
    color: #fff;
}

.btn-success:hover {
    background-color: #218838;
    transform: scale(1.05);
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
}

.btn-danger:hover {
    background-color: #c82333;
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .form-group.row {
        flex-direction: column;
        align-items: flex-start;
    }

    .form-group.row label {
        margin-bottom: 10px;
    }
}

</style>
@extends('layouts.app')
@include('layouts.navigation')
<br><br><br><br><br><br><br>
@section('content')
<div class="container additional-info">
    <h1>Additional Information of Patient</h1>
    <form action="{{ route('updatingDetails', ['id' => $patient->patient_id]) }}" method="POST">
        @csrf
        <div class="form-group row">
            <label for="patient_id" class="col-sm-2 col-form-label">Patient ID</label>
            <div class="col-sm-4">
                <input 
                    type="text" 
                    value="{{ $patient->patient_id }}"
                    class="form-control" 
                    id="patient_id" 
                    name="patient_id" 
                    readonly>
            </div>

            <label for="patient_name" class="col-sm-2 col-form-label">Patient Name</label>
            <div class="col-sm-4">
                <input 
                    type="text" 
                    value="{{ $patient->user->first_name }} {{ $patient->user->last_name }}"
                    class="form-control" 
                    id="patient_name" 
                    name="patient_name" 
                    readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="caregroup" class="col-sm-2 col-form-label">Caregroup</label>
            <div class="col-sm-10">
                <select class="form-control" id="caregroup" name="caregroup" required>
                    <option value="A" {{ $patient->caregroup == 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ $patient->caregroup == 'B' ? 'selected' : '' }}>B</option>
                    <option value="C" {{ $patient->caregroup == 'C' ? 'selected' : '' }}>C</option>
                    <option value="D" {{ $patient->caregroup == 'D' ? 'selected' : '' }}>D</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="admission_date" class="col-sm-2 col-form-label">Admission Date</label>
            <div class="col-sm-10">
                <input 
                    type="date" 
                    class="form-control" 
                    id="admission_date" 
                    name="admission_date" 
                    value="{{ $patient->admission_date }}" 
                    required>
            </div>
        </div>

        <p class="text-muted">
            This page is accessed by Admin and Supervisor after the registration is approved for a student.
        </p>

        <div class="form-group row">
            <div class="col-sm-12 text-right">
                <button type="submit" class="btn btn-success">Ok</button>
                <a href="{{ route('patientList') }}" class="btn btn-danger" style="text-decoration: none;">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection