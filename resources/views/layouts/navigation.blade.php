<link rel="stylesheet" href="{{ asset('CSS/navbar.css') }}">

<div class="navbar">
    <!-- Logo Section -->
    <div class="logo-container">
        <img src="{{ asset('images/image.png') }}" alt="Logo" class="logo" />
    </div>

    <!-- Navigation Links -->
    <div class="navbar_items">
        <nav>
            <ul>
                @if(Auth::check())
                    @php
                        $user = Auth::user();
                        $role = \App\Models\Role::where('role', $user->role)->first();
                        $access = $role->access_level;
                    @endphp

                    <!-- Admin Links (access_level 1) -->
                    @if($access === 1)
                        <li><a href="{{ route('adminHome') }}">Home</a></li>
                        <li><a href="{{ route('adminRoles') }}">Manage Roles</a></li>
                        <li><a href="{{ route('adminPayment') }}">Patient Payment</a></li>
                    @endif

                    <!-- Supervisor Links (access_level 2) -->
                    @if($access == 2)
                        <li><a href="{{ route('supervisorHome') }}">Home</a></li>
                    @endif

                    <!-- Doctor Links (access_level 3) -->
                    @if($access == 3)
                        <li><a href="{{ route('doctorHome') }}">Home</a></li>
                        <li><a href="{{ route('shifts.index') }}">Roster</a></li>
                    @endif

                    <!-- Caregiver Links (access_level 4) -->
                    @if($access == 4)
                        <li><a href="{{ route('caregiverHome', ['id' => $user->id]) }}">Home</a></li>
                        <li><a href="{{ route('shifts.index') }}">Roster</a></li>
                    @endif

                    <!-- Patient Links (access_level 5) -->
                    @if($access == 5)
                        <li><a href="{{ route('patientHome', ['id' => $user->id]) }}">Home</a></li>
                        <li><a href="{{ route('shifts.index') }}">Roster</a></li>
                    @endif

                    <!-- Family Member Links (access_level 6) -->
                    @if($access == 6)
                        <li><a href="{{ route('familyHome', ['id' => $user->id]) }}">Home</a></li>
                    @endif

                    <!-- Access for Admins and Supervisors -->
                    @if(in_array($access, [1, 2]))
                        <li><a href="{{ route('admin.pending') }}">Accounts Status</a></li>
                        <li><a href="{{ route('shifts.index') }}">Roster</a></li>
                        <li><a href="{{ route('appointment.create') }}">Schedule Appointment</a></li>
                        <li><a href="{{ route('admin.report') }}">Reports</a></li>
                        <li><a href="{{ route('employeeList') }}">Employee List</a></li>
                    @endif

                    <!-- Access for Employees -->
                    @if(in_array($access, [1, 2, 3, 4]))
                        <li><a href="{{ route('patientList') }}">Patient List</a></li>
                    @endif
                @else
                    <li><a href="{{ route('welcome') }}">Home</a></li>
                    @if (Route::has('login'))
                        <li><a href="{{ route('login') }}">Log in</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @endif
                    @endif
                @endif
            </ul>
        </nav>
    </div>
    <!-- Logout Button -->
    @if(Auth::check())
        <div id="logout">
            <li style="list-style-type: none;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </li>
        </div>
    @endif
</div>
