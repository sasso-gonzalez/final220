<style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    form {
        max-width: 450px;
        width: 100%;
        padding: 30px;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    label {
        font-size: 14px;
        color: #333;
        margin-bottom: 5px;
        display: block;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #007bff;
        outline: none;
    }

    .input-error {
        font-size: 12px;
        color: red;
        margin-top: 5px;
    }

    .button-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    button {
        background-color: #0056b3;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #0f283a;
    }

    a {
        text-align: center;
        display: block;
        color: #007bff;
        margin-top: 10px;
        margin-bottom: 10px;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .navbar_items {
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
        }

        nav ul {
            flex-direction: column;
            margin-top: 10px;
        }

        nav ul li {
            margin-bottom: 15px;
        }

        form {
            width: 90%;
            padding: 20px;
        }

        button {
            font-size: 14px;
            padding: 8px 15px;
        }
    }

</style>

@extends('layouts.app')
@include('layouts.navigation')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <h1>Login</h1>

            <!-- Email Address -->
            <div style="margin-left:20px; margin-right:20px;">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                    <span class="input-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div style="margin-left:20px; margin-right:20px;">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="input-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="button-container">
                <button type="submit">Log in</button>
            </div>

            <a href="{{ route('register') }}">Not registered? Click here.</a>
        </form>
    </div>
@endsection