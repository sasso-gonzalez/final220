<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f7fafc;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 2em;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }


    .btn {
        background-color: #0056b3;
        color: white;
        padding: 10px 20px;
        font-size: 14px;
        text-decoration: none;
        margin-right: 10px;
    }
    .button-container {
        display: flex;
        gap: 10px; 
        flex-wrap: wrap;
        text-align:left;
        margin-top:10px;
    }
    .btn-primary {
        background-color: #0056b3;
        border-radius: 5px;
        cursor: pointer;
        border: 2px solid black;
        height:fit-content;
        margin-top:auto;
    }

    .btn-primary:hover {
        background-color: #0f283a;
    }

    .btn-secondary {
        background-color: #0056b3;
        border-radius: 5px;
        cursor: pointer;
        border: 2px solid black;
    }

    .btn-secondary:hover {
        background-color: #0f283a;
        border-radius: 5px;

    }

    button[type="submit"] {
        background-color: #0056b3;
        color: white;
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 5px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #0f283a;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-size: 14px;
        color: #333;
    }

    input[type="date"] {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    input[type="date"]:focus {
        border-color: #007bff;
        outline: none;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th,
    table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: #f1f1f1;
        font-size: 14px;
        color: #333;
    }

    table td {
        font-size: 14px;
        color: #555;
    }

    table tbody tr:hover {
        background-color: #f9f9f9;
    }

    @media (max-width: 768px) {
        .container {
            padding: 15px;
            width: 90%;
        }

        h1 {
            font-size: 1.5em;
        }

        .btn {
            font-size: 12px;
            padding: 8px 15px;
        }

        table th,
        table td {
            font-size: 12px;
            padding: 10px;
        }
    }
</style>

@extends('layouts.app')
@include('layouts.navigation')
<br><br><br>

@section('content')
<br><br><br>
    <div class="container">
        <h1>Shift Roster</h1>
        <div class="button-container">
            @if(auth()->user()->hasRole(['admin', 'Supervisor']))
                    <a href="{{ route('shifts.create') }}" class="btn btn-primary">Add Employee Shift</a>
            @endif
        </div>
        <div class="button-container">
            <form action="{{ route('shifts.index') }}" method="GET" class="mb-4">
                <div class="form-group">
                    <label for="date">Search Shifts by Date:</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{ route('shifts.index') }}" class="btn btn-secondary">Show All</a>
            </form>
            <!-- <form method="GET" action="{{ route('shifts.index') }}">
                @csrf
                <button type="submit" class="btn btn-secondary">Show All</button>
            </form> -->
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Shift Date</th>
                    <th>Role</th>
                    <th>Caregroup</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shifts as $shift)
                    <tr>
                        <td>{{ $shift->employee->user->first_name }} {{ $shift->employee->user->last_name }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($shift->shift_start)->format('M d, Y h:i A') }} - 
                            {{ \Carbon\Carbon::parse($shift->shift_end)->format('h:i A') }}
                        </td>
                        <td>{{ $shift->employee->user->role }}</td>
                        <td>{{ $shift->caregroup ?? '' }}</td>
                        <td>
                            @if(auth()->user()->hasRole(['admin', 'Supervisor']))
                                <a href="{{ route('shifts.edit', $shift->id) }}" class="btn btn-secondary">Edit</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection