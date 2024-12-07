@extends('layouts.app')
@include('layouts.navigation')
<br><br><br><br><br><br><br><br><br><br><br><br>

@section('content')
    <br><br><br><br>
    <h1>Pending Accounts</h1>
    <table> 
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendingUsers as $user)
                <tr>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.approve', $user->id) }}">
                            @csrf
                            <button type="submit">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.deny', $user->id) }}">
                            @csrf
                            <button type="submit">Deny</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
