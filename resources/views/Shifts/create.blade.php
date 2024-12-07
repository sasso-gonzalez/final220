@extends('layouts.app')
@include('layouts.navigation')
<br><br><br><br><b><br><br><br><br>

@section('content')
<div class="container">
    <h1>Create Shift</h1>
    <form action="{{ route('shifts.store') }}" method="POST">
        @csrf
        <input type="date" name="shift_date" required>
        <input type="datetime-local" name="shift_start" required>
        <input type="datetime-local" name="shift_end" required>
        <div id="caregroup-div">
            <label for="caregroup">Care Group:</label>
            <select name="caregroup" id="caregroup" required>
                @foreach ($availableCaregroups as $caregroup)
                    <option value="{{ $caregroup }}">{{ $caregroup }}</option>
                @endforeach
            </select>
        </div>
        <label for="emp_id">Employee:</label>
        <select name="emp_id" id="emp_id" required onchange="updateRole()">
            <option value="">Select Employee</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->emp_id }}" data-role="{{ $employee->user->role }}">
                    {{ $employee->user->first_name }} {{ $employee->user->last_name }}
                </option>
            @endforeach
        </select>
        <input type="hidden" id="role" name="role">
        <button type="submit">Create Shift</button>
    </form>
</div>

<script>
    function updateRole() {
        const selectedOption = document.querySelector('#emp_id option:checked');
        const role = selectedOption.getAttribute('data-role');
        document.getElementById('role').value = role;

        // Show or hide caregiver group dropdown based on role
        const caregroupDiv = document.getElementById('caregroup-div');
        const caregroupInput = document.getElementById('caregroup'); // Assuming this is the input for the caregiver group

        if (role === 'Caregiver') {
            caregroupDiv.style.display = 'block';
            caregroupInput.required = true; // Make caregroup input required for caregivers
        } else {
            caregroupDiv.style.display = 'none';
            caregroupInput.value = ''; // Clear the caregiver group value
            caregroupInput.required = false; // Remove required attribute for non-caregivers
        }
    }

    // Initialize the form based on the selected employee
    document.addEventListener('DOMContentLoaded', function() {
        updateRole();
    });
</script>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
