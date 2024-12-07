@extends('layouts.app')
@include('layouts.navigation')
<br><br><br><br><b><br><br><br><br>

@section('content')
<div class="container">
    <h1>Edit Shift</h1>
    <form action="{{ route('shifts.update', $shift->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="date" name="shift_date" value="{{ $shift->shift_date }}" required>
        <input type="datetime-local" name="shift_start" value="{{ $shift->shift_start }}" required>
        <input type="datetime-local" name="shift_end" value="{{ $shift->shift_end }}" required>
        <div id="caregroup-div">
            <label for="caregroup">Care Group:</label>
            <select name="caregroup" id="caregroup" required>
                @foreach ($availableCaregroups as $caregroup)
                    <option value="{{ $caregroup }}" {{ $shift->caregroup == $caregroup ? 'selected' : '' }}>{{ $caregroup }}</option>
                @endforeach
            </select>
        </div>
        <label for="emp_id">Employee:</label>
        <select name="emp_id" id="emp_id" required onchange="updateRole()">
            <option value="">Select Employee</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->emp_id }}" data-role="{{ $employee->user->role }}" {{ $shift->emp_id == $employee->emp_id ? 'selected' : '' }}>
                    {{ $employee->user->first_name }} {{ $employee->user->last_name }}
                </option>
            @endforeach
        </select>
        <input type="hidden" id="role" name="role" value="{{ $shift->employee->user->role }}">
        <button type="submit">Update Shift</button>
    </form>
</div>

<script>
function updateRole() {
    const selectedOption = document.querySelector('#emp_id option:checked');
    const role = selectedOption.getAttribute('data-role');
    document.getElementById('role').value = role;

    const caregroupDiv = document.getElementById('caregroup-div');
    const caregroupInput = document.getElementById('caregroup');

    if (role === 'Caregiver') {
        caregroupDiv.style.display = 'block';
        caregroupInput.required = true;
    } else {
        caregroupDiv.style.display = 'none';
        caregroupInput.value = '';
        caregroupInput.required = false;
    }
}

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