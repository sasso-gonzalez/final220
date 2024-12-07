<link rel="stylesheet" href="{{ asset('CSS/app.css') }}">
<x-guest-layout>
<div class="navbar">
            @if (Route::has('login'))
                <div class="navbar_items">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="word">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="word">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="word">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
<br><br><br><br><br><br>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <!-- First Name -->
        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" class="" type="text" name="first_name" :value="old('first_name')" required autofocus />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div>
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" class="" type="text" name="last_name" :value="old('last_name')" required />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" onchange='patientFields()' required>
                <option value="" disabled selected>Select a role</option>
                @foreach($roles as $role)
                    @if ( $role->role !== 'admin') <!-- making sure you can't just register another admin -serena -->
                    <option value="{{ $role->role }}">{{ $role->role }}</option> 
                    @endif
                @endforeach
            </select>
        </div>


        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="" type="text" name="phone" :value="old('phone')" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Date of Birth -->
        <div class="mt-4">
            <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
            <x-text-input id="date_of_birth" class="" type="date" name="date_of_birth" :value="old('date_of_birth')" />
            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div id="fields" class="fields">
            <x-input-label for="family_code" :value="__('family_code')" />
            <x-text-input id="family_code" type="text" name="family_code" />
            <x-input-error :messages="$errors->get('family_code')" class="mt-2" />
       
            <x-input-label for="emergency_contact" :value="__('emergency_contact')" />
            <x-text-input id="emergency_contact" type="text" name="emergency_contact"  />
            <x-input-error :messages="$errors->get('emergency_contact')" class="mt-2" />
        
            <x-input-label for="relation_emergency_contact" :value="__('relation_emergency_contact')" />
            <x-text-input id="relation_emergency_contact" type="text" name="relation_emergency_contact" />
            <x-input-error :messages="$errors->get('relation_emergency_contact')" class="mt-2" />
        </div>
        <div class="">
            <a class="" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="" type="submit">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    <script>
        function patientFields(){
            var role = document.getElementById('role').value
            var newFields = document.getElementById('fields')
            if(role === 'Patient'){
                newFields.style.display = 'block'
            }   
            else{
                newFields.style.display = 'none'
            }
        }

        function access(){
            var role = document.getElementById('role').value
        }
    </script>
</x-guest-layout>
