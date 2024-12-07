@extends('layouts.app')
@include('layouts.navigation')
<br><br><br><br><br><br><br><br>

@section('content')

    <div class="container">
        <h1>Roster</h1>
        @if(auth()->user()->hasRole(['admin', 'Supervisor']))
            <a href="{{ route('shifts.create') }}" class="btn btn-primary">Add Shift</a>
        @endif

        <form action="{{ route('roster') }}" method="GET" class="mb-4">
            <div class="form-group">
                <label for="date">Search Shifts by Date:</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <form method="GET" action="{{ route('roster') }}">
            @csrf
            <button type="submit">Show All</button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Shift Date</th>
                    <!-- <th>Shift End</th> -->
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