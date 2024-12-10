<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="{{ asset('CSS/navbar.css') }}">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f7fafc;
        }

        .navbar {
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        form {
            max-width: 450px;
            width: 100%;
            margin-top: 100px;
            padding: 40px;
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
            margin-left: 20px; 
            margin-right: 20px; 
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        select {
            width: calc(100% - 40px);
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            margin-left: 20px; 
            margin-right: 20px; 
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="date"]:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        .input-error {
            font-size: 12px;
            color: red;
            margin-top: 5px;
            margin-left: 20px; /* Align with inputs */
            margin-right: 20px; /* Align with inputs */
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        button {
            background-color: #0056b3;
            color: white;
            padding: 10px 60px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0f283a;
        }

        a {
            display: block;
            text-align: center;
            color: #007bff;
            margin-top: 10px;
            margin-bottom: 10px;
            text-decoration: none;
            padding: 10px 20px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
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
</head>
<body>
    @extends('layouts.app')
    @include('layouts.navigation')

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <h1>Register</h1>

        <div>
            <label for="first_name">First Name</label>
            <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus>
            @error('first_name')
                <span class="input-error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="last_name">Last Name</label>
            <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required>
            @error('last_name')
                <span class="input-error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="role">Role</label>
            <select name="role" id="role" required>
                <option value="" disabled selected>Select a role</option>
                @foreach($roles as $role)
                    @if ($role->role !== 'admin')
                        <option value="{{ $role->role }}">{{ $role->role }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <span class="input-error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="phone">Phone</label>
            <input id="phone" type="text" name="phone" value="{{ old('phone') }}">
            @error('phone')
                <span class="input-error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="date_of_birth">Date of Birth</label>
            <input id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
            @error('date_of_birth')
                <span class="input-error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <span class="input-error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
            @error('password_confirmation')
                <span class="input-error">{{ $message }}</span>
            @enderror
        </div>

        <div id="fields" class="fields">
            <label for="family_code">Family Code</label>
            <input id="family_code" type="text" name="family_code">
            @error('family_code')
                <span class="input-error">{{ $message }}</span>
            @enderror

            <label for="emergency_contact">Emergency Contact</label>
            <input id="emergency_contact" type="text" name="emergency_contact">
            @error('emergency_contact')
                <span class="input-error">{{ $message }}</span>
            @enderror

            <label for="relation_emergency_contact">Relation to Emergency Contact</label>
            <input id="relation_emergency_contact" type="text" name="relation_emergency_contact">
            @error('relation_emergency_contact')
                <span class="input-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="button-container">
            <button type="submit">Register</button>
        </div>
        <div class="button-container">
            <a href="{{ route('login') }}">Already registered?</a>
        </div>
    </form>
</body>
</html>