<style>

body {
    font-family: 'Arial', sans-serif;
    background-color: #f7fafc;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 30px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 2em;
    color: #333;
    text-align: center;
    margin-bottom: 30px;
}

form {
    display: flex;
    flex-direction: column;
}

input[type="date"],
input[type="datetime-local"],
select {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

input[type="date"]:focus,
input[type="datetime-local"]:focus,
select:focus {
    border-color: #007bff;
    outline: none;
}

#caregroup-div {
    margin-bottom: 20px;
    display: none;
}

#caregroup-div label {
    font-size: 14px;
    color: #333;
}

select {
    background-color: #f9f9f9;
}

select option {
    font-size: 14px;
}

button[type="submit"] {
    background-color: #007bff;
    color: white;
    padding: 12px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    border: none;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

.alert {
    background-color: #f8d7da;
    color: #721c24;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.alert ul {
    list-style-type: none;
    padding: 0;
}

.alert li {
    margin-bottom: 5px;
}

@media (max-width: 768px) {
    .container {
        padding: 20px;
        width: 90%;
    }

    h1 {
        font-size: 1.5em;
    }

    input[type="date"],
    input[type="datetime-local"],
    select {
        font-size: 12px;
        padding: 8px;
    }

    button[type="submit"] {
        font-size: 14px;
        padding: 10px 18px;
    }
}
</style>
@extends('layouts.app')
@include('layouts.navigation')
<br><br><br>

@section('content')
<br><br><br>
<div class="container">
    <h1>Create Shift</h1>
    <form id="shift-form" action="{{ route('shifts.store') }}" method="POST">
        @csrf
        <input type="date" name="shift_date" id="shift_date" required>
        <input type="datetime-local" name="shift_start" required>
        <input type="datetime-local" name="shift_end" required>
        <div id="caregroup-div">
            <label for="caregroup">Care Group:</label>
            <select name="caregroup" id="caregroup" required>
                @foreach ($allCaregroups as $caregroup)
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
    document.getElementById('shift_date').addEventListener('change', function() {
        const date = this.value;
        fetchAvailableEmployees(date);
    });

    function fetchAvailableEmployees(date) {
        fetch(`/shifts/available-employees?date=${date}`)
            .then(response => response.json())
            .then(data => {
                const empSelect = document.getElementById('emp_id');
                empSelect.innerHTML = '<option value="">Select Employee</option>';
                data.employees.forEach(employee => {
                    const option = document.createElement('option');
                    option.value = employee.emp_id;
                    option.textContent = `${employee.user.first_name} ${employee.user.last_name}`;
                    option.setAttribute('data-role', employee.user.role);
                    empSelect.appendChild(option);
                });
                updateRole();
            });
    }

    function updateRole() {
        const selectedOption = document.querySelector('#emp_id option:checked');
        const role = selectedOption.getAttribute('data-role');
        document.getElementById('role').value = role;

        // Show or hide caregiver group dropdown based on role
        const caregroupDiv = document.getElementById('caregroup-div');
        const caregroupInput = document.getElementById('caregroup');

        if (role === 'Caregiver') {
            caregroupDiv.style.display = 'block';
            caregroupInput.setAttribute('required', 'required');
        } else {
            caregroupDiv.style.display = 'none';
            caregroupInput.value = '';
            caregroupInput.removeAttribute('required');
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