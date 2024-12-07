@extends('layouts.app')
@include('layouts.navigation')
<br><br><br><br><br><br><br><br><br><br>
@section('content')
<div class="container">
    <h1>Scheduling Appointment</h1>
    <form action="{{ route('appointment.store') }}" method="POST">
        @csrf
        <div class="form-group row">
            <label for="patient_id" class="col-sm-2 col-form-label">Patient ID</label>
            <div class="col-sm-4">
                <input 
                    type="text" 
                    class="form-control" 
                    id="patient_id" 
                    name="patient_id" 
                    required>
            </div>

            <label for="patient_name" class="col-sm-2 col-form-label">Patient Name</label>
            <div class="col-sm-4">
                <input 
                    type="text" 
                    class="form-control" 
                    id="patient_name" 
                    name="patient_name" 
                    readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="app_date" class="col-sm-2 col-form-label">Appointment Date</label>
            <div class="col-sm-10">
                <input 
                    type="date" 
                    class="form-control" 
                    id="app_date" 
                    name="app_date" 
                    required>
            </div>
        </div>

        <div class="form-group row">
            <label for="doctor_id" class="col-sm-2 col-form-label">Doctor</label>
            <div class="col-sm-10">
                <select class="form-control" id="doctor_id" name="doctor_id" required>
                    <!--Options should pop up here -->
                </select>
            </div>
        </div>

        <p class="text-muted">
            This page is accessed by Admin and Supervisor after the registration is approved for a patient.
        </p>

        <div class="form-group row">
            <div class="col-sm-12 text-right">
                <button type="submit" class="btn btn-success" id="submit_button">Ok</button>
                <a href="{{ route('appointment.create') }}" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </form>
</div>
@if ($errors->any())
    <script>
        alert('{{ $errors->first() }}');
    </script>
@endif
<script>
    document.getElementById('patient_id').addEventListener('change', function() {
        var patientId = this.value;
        if (patientId) {
            fetch(`/patients/${patientId}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        var patientNameInput = document.getElementById('patient_name');
                        var admissionDateInput = document.getElementById('admission_date');

                        if (patientNameInput) {
                            patientNameInput.value = data.first_name + ' ' + data.last_name;
                        }
                        if (admissionDateInput) {
                            admissionDateInput.value = data.admission_date;
                        }
                    } else {
                        console.error('Patient data not found');
                    }
                })
                .catch(error => {
                    console.error('Error fetching patient data:', error);
                });
        }
    });

    document.getElementById('app_date').addEventListener('change', function() {
        var appDate = this.value;
        if (appDate) {
            fetch(`/doctors/scheduled/${appDate}`)
                .then(response => response.json())
                .then(data => {
                    var doctorSelect = document.getElementById('doctor_id');
                    var submitButton = document.getElementById('submit_button');
                    doctorSelect.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(function(doctor) {
                            var option = document.createElement('option');
                            option.value = doctor.doctor_id;
                            option.text = doctor.first_name + ' ' + doctor.last_name;
                            doctorSelect.appendChild(option);
                        });
                        submitButton.disabled = false;
                    } else {
                        var option = document.createElement('option');
                        option.text = 'No doctors available';
                        doctorSelect.appendChild(option);
                        submitButton.disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error fetching doctor data:', error);
                });
        }
    });
</script>
@endsection