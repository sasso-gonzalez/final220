<style>
.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
}

h3 {
    font-size: 24px;
    color: #333;
    margin-top: 30px;
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
    text-align: left;
}

table tbody td {
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 14px;
    color: black;
}
table tbody {
    background-color: white;}

table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tbody tr:hover {
    background-color: lightgrey;
}

textarea,
input[type="text"],
input[type="date"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

button {
    padding: 8px 15px;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    margin: 5px;
    border: none;
}

.btn.approve {
    background-color: #007bff;
    color: white;
}

.btn.approve:hover {
    background-color: #0056b3;
}

.btn.deny {
    background-color: #dc3545;
    color: white;
}

.btn.deny:hover {
    background-color: #c82333;
}

form {
    margin-top: 20px;
}

.alert {
    margin-top: 20px;
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    padding: 15px;
    border-radius: 5px;
}

@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    h1 {
        font-size: 24px;
    }

    h3 {
        font-size: 20px;
    }

    table tbody td {
        font-size: 12px;
    }

    button {
        font-size: 12px;
        padding: 6px 12px;
    }

    textarea,
    input[type="text"],
    input[type="date"] {
        font-size: 12px;
    }
}
</style>
@extends('layouts.app')
@include('layouts.navigation')
<br><br><br>

@section('content')
<br><br><br>
    <div class="container">
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
                                <button class="btn approve" type="submit">Approve</button>
                            </form>
                            <form method="POST" action="{{ route('admin.deny', $user->id) }}">
                                @csrf
                                <button class="btn deny" type="submit">Deny</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
