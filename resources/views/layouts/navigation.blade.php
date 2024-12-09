
<link rel="stylesheet" href="{{ asset('CSS/navbar.css') }}">




<div class="navbar">
    <div class="navbar_items">
        <nav>
        <div class="ranch-container">
                <img src="https://files.oaiusercontent.com/file-NKNuAU3HS5YCd9hUPeohMB?se=2024-12-06T13%3A43%3A07Z&sp=r&sv=2024-08-04&sr=b&rscc=max-age%3D604800%2C%20immutable%2C%20private&rscd=attachment%3B%20filename%3Dc988095a-7a4b-46ca-806a-76a1c72d75f4.webp&sig=IxcO8ABtmAJ7QG6YE6ulgg%2BTgh0yK0DtOhcq%2BM98dJE%3D" alt="" class="wrinkle-ranch" >
            </div>
            <ul>
                
                @if(Auth::check())
                    @php
                        $user = Auth::user();
                        $role = \App\Models\Role::where('role', $user->role)->first();
                        $access = $role->access_level;
                    @endphp

                    <!-- admin Links (access_level 1) -->
                    @if($access === 1)
                        <li><a href="{{ route('adminHome') }}">Home</a></li>
                        <li><a href="{{ route('adminRoles') }}">Manage Roles</a></li>
                        <li><a href="{{ route('adminPayment') }}">Patient Payment</a></li>
                    @endif



                    <!-- Supervisor Links (access_level 2) -->
                    @if($access == 2)
                        <div><a href="{{ route('supervisorHome') }}">Supervisor Home</a></div>
                    @endif     
                    
                    

                    <!-- Doctor Links (access_level 3) -->
                    @if($access == 3)
                        <li><a href="{{ route('doctorHome') }}">Doctor Home</a></li>
                        <li><a href="{{ route('shifts.index') }}">Roster</a></li>
                    @endif

                    <!-- Caregiver Links (access_level 4) -->
                    @if($access == 4)
                        <li><a href="{{ route('caregiverHome', ['id' => $user->id]) }}">Caregiver Home</a></li> <!--  -->
                        <li><a href="{{ route('shifts.index') }}">Roster</a></li>
                    @endif

                    <!-- Patient Links (access_level 5) -->
                    @if($access == 5)
                        <li><a href="{{ route('patientHome', ['id' => $user->id]) }}">Patient Home</a></li>
                        <li><a href="{{ route('shifts.index') }}">Roster</a></li>
                    @endif

                    <!-- family Member Links (access_level 6) -->
                    @if($access == 6)
                        <li><a href="{{ route('familyHome', ['id' => $user->id]) }}">Home</a></li>
                    @endif

                    <!-- access for admins and Supervisors -->
                    @if(in_array($access, [1, 2]))
                        <li><a href="{{ route('admin.pending') }}">Accounts Status</a></li>
                        <li><a href="{{ route('shifts.index') }}">Roster</a></li>
                        <li><a href="{{ route('appointment.create') }}">Schedule Doctor's Appointment</a></li>
                        <li><a href="{{ route('admin.report') }}">Reports</a></li>
                        <li><a href="{{ route('employeeList') }}">Employee List</a></li>

                    @endif
                    <!-- access for employees -->
                    @if(in_array($access, [1, 2, 3, 4]))
                        <li><a href="{{ route('patientList') }}">Patient List</a></li>
                    @endif

                    <div id="logout" style="background-color:white">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                @endif
            </ul>
        </nav>
    </div>
</div>









