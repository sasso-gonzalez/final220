<style>
.container1{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
.container.supervisor-dashboard {
    border-left: 5px solid #5cb85c;
    background-color: #f4fbf4;
    padding: 25px;
    width:100%;
}

.container.supervisor-dashboard h1 {
    color: #5cb85c;
    text-align: center;
    font-size: 32px;
    margin-bottom: 20px;
    font-weight: bold;
}

.container.supervisor-dashboard p {
    color: #444;
    text-align: center;
    font-size: 18px;
    margin-bottom: 30px;
}

.container.supervisor-dashboard {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

</style>
@extends('layouts.app')
@include('layouts.navigation')
<link rel="stylesheet" href="{{ asset('CSS/employeesHomes.css') }}">
<br><br><br>

@section('content')
<div class="container1">
    <div class="container supervisor-dashboard">
        <h1>Welcome, Supervisor!</h1>
        <p>This is the Supervisor Dashboard.</p>
    </div>
</div>
@endsection
