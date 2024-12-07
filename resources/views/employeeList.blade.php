@extends('layouts.app')
@include('layouts.navigation')
<br><br><br><br><br><br>
@section('content')
    <div class="container">
        <h1>Employee List</h1>
        <form method="GET" action="{{ route('employeeList') }}">
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
@endsection