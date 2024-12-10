<style>
    /* public/css/employeeList.css */

.container {
    max-width: 1000px;
    overflow-y: auto;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}
.employee-container{
    max-height: 400px; 
    overflow-y: auto; 
    border: 1px solid #ccc;
}
th {
    background-color: #f4f4f4;
    position: sticky; /* Keeps header fixed during scroll */
    top: 0;
    z-index: 1;
}
h1 {
    text-align: center;
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
}

.employeelist {
    margin-bottom: 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: space-between;
    background-color: #ffffff;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.employeelist div {
    flex: 1 1 220px;
}

.employeelist label {
    font-weight: bold;
    color: #555;
    display: block;
    margin-bottom: 5px;
}

.employeelist input {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.employeelist button {
    margin-top:auto;
    align-self: bottom;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.employeelist button:hover {
    background-color: #0056b3;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table thead th {
    background-color: #0056b3;
    color: white;
    padding: 10px;
    font-size: 14px;
    text-align: left;
}

table tbody td {
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 14px;
    color:black;
}

table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tbody tr:hover {
    background-color: lightgrey;
}

form div input[type="number"] {
    width: calc(100% - 70px);
    display: inline-block;
}

.employeelist div button {
    margin-left: 10px;
    background-color: #007bff;
    color: white;
}

.employeelist div button:hover {
    background-color: #0056b3;
}

@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    .employeelist {
        flex-direction: column;
        align-items: stretch;
    }

    .employeelist div {
        flex: 1 1 100%;
    }

    h1 {
        font-size: 24px;
    }

    table tbody td {
        font-size: 12px;
    }

    .employeelist button {
        font-size: 12px;
        padding: 8px 12px;
    }
}
</style>
@extends('layouts.app')
@include('layouts.navigation')
<br><br><br>
@section('content')
    <div class="container">
        <h1>Employee List</h1>
        <form class="employeelist" method="GET" action="{{ route('employeeList') }}">
            <div>
                <label for="employee_id">Employee ID:</label>
                <input type="text" id="employee_id" name="employee_id" value="{{ request('employee_id') }}" placeholder="Enter Employee ID">
            </div>
            <div>
                <label for="name">Employee Name:</label>
                <input type="text" id="name" name="name" value="{{ request('name') }}" placeholder="Enter employee name">
            </div>
            <div>
                <label for="role">Role:</label>
                <input type="text" id="role" name="role" value="{{ request('role') }}" placeholder="Enter Job Title">
            </div>
            <div>
                <label for="salary">Salary:</label>
                <input type="text" id="salary" name="salary" value="{{ request('salary') }}" placeholder="Enter salary">
            </div>
            <button type="submit">Search</button>
        </form>
        <div class="employee-container">
        <table> 
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                @foreach($adminEmployeeList as $user)
                    <tr>
                        <td>{{ $user->employee->emp_id }}</td>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <form action="{{ route('admin.submitSalary', ['id' => $user->employee->emp_id]) }}" method="POST">
                                @csrf
                                @php
                                    $authUser = auth()->user();
                                    $authRole = \App\Models\Role::where('role', $authUser->role)->first();
                                @endphp
                                @if ($authRole->access_level === 1)
                                    <div>
                                        <input type="number" id="salary-{{ $user->employee->emp_id }}" 
                                               value="{{ $user->employee->salary ?? '' }}" 
                                               name="salary" 
                                               required 
                                               min="0">
                                        <button type="submit">Submit</button>
                                    </div>
                                @else
                                    <input type="number" id="salary-{{ $user->employee->emp_id }}" 
                                           value="{{ $user->employee->salary ?? '' }}" 
                                           name="salary" 
                                           readonly>
                                @endif
                            </form>
                        </td> 
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
@endsection