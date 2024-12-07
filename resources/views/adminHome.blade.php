<style>

.container.admin-dashboard {
    border-left: 5px solid #4db8ff;
    background-color: #eef7fc;
}

.container.admin-dashboard h1 {
    color: #4db8ff;
}

</style>
@extends('layouts.app')
@include('layouts.navigation')
<link rel="stylesheet" href="{{ asset('CSS/employeesHomes.css') }}">
<br><br><br><br><br><br><br><br>

@section('content') 
    <div class="container admin-dashboard">
        <h1>Welcome, Admin!</h1>
        <p>This is the Admin Dashboard.</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
@endsection


                        