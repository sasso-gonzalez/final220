<?php


    use App\Http\Controllers\Auth\RegisteredUserController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\AdminAccountController;
    use App\Http\Controllers\Supervisor\SupervisorHomeController;
    use App\Http\Controllers\Doctor\DoctorController;
    use App\Http\Controllers\Caregiver\CaregiverHomeController;
    use App\Http\Controllers\Patient\PatientController;
    use App\Http\Controllers\AdminRolesController;
    use App\Http\Controllers\ShiftController;
    use App\Http\Controllers\AppointmentController;
    use App\Http\Controllers\AdminPaymentController;
    use App\Http\Controllers\AdminReportController;
    use App\Http\Controllers\FamilyMemberController;

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/unauthorized', function () {
        return view('unauthorized');
    })->name('unauthorized');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // admin Account Routes
    Route::middleware(['auth', 'role:1'])->group(function () {
        Route::get('/admin/home', [AdminAccountController::class, 'adminHome'])->name('adminHome');
        Route::get('/admin/roles', [AdminRolesController::class, 'index'])->name('adminRoles');
        Route::post('/admin/store', [AdminRolesController::class, 'store'])->name('admin.store');
        //admin salary update on mployee/patient list page
        Route::post('/admin/submitSalary/{id}', [AdminAccountController::class, 'submitSalary'])->name('admin.submitSalary');
        //Admin Payment Page Routes
        Route::get('/admin/payment', [AdminPaymentController::class, 'index'])->name('adminPayment');
        Route::get('/api/patients/{id}/payment-details', [AdminPaymentController::class, 'fetchPaymentDetails']);
        Route::post('/admin/payment/submit', [AdminPaymentController::class, 'submitPayment'])->name('admin.payment.submit');
        Route::get('/admin/payment/cancel', [AdminPaymentController::class, 'cancel'])->name('admin.payment.cancel');
        Route::post('/api/patients/{id}/update-charges', [AdminPaymentController::class, 'updateCharges']);
    });

    // Supervisor Routes
    Route::middleware(['auth', 'role:2'])->group(function () {
        Route::get('/supervisor/home', [SupervisorHomeController::class, 'supervisorHome'])->name('supervisorHome');
    });

    // Doctor Routes
    Route::middleware(['auth', 'role:3'])->group(function () {
        Route::get('/doctor/home', [DoctorController::class, 'index'])->name('doctorHome');
        Route::get('/doctor/appointments', [DoctorController::class, 'index'])->name('doctorAppointments');
        Route::post('/doctor/{appointmentId}/prescriptions', [DoctorController::class, 'savePrescription'])->name('prescriptions.save');
        //patientOfDoctor page
        Route::get('/patientOfDoctor/{appointment}', [DoctorController::class, 'showPatientDetails'])->name('patientOfDoctor');
    });

    // Caregiver Routes
    Route::middleware(['auth', 'role:4'])->group(function () {
        Route::get('/caregiver/home/{id}', [CaregiverHomeController::class, 'showCaregiverHome'])->name('caregiverHome');
        Route::get('/caregiver/schedule/{id}', [CaregiverHomeController::class, 'showSchedule'])->name('caregiver.schedule');
        Route::post('/caregiver/schedule/save', [CaregiverHomeController::class, 'savePatientSchedule'])->name('caregiver.saveSchedule');
    });


    // Patient Routes
    Route::middleware(['auth', 'role:5'])->group(function () {
        Route::get('/patient/home/{id}', [PatientController::class, 'patientHome'])->name('patientHome');
    });


    // familyMember Routes
    Route::middleware(['auth', 'role:6'])->group(function () {
        Route::get('/family/home/{id}', [FamilyMemberController::class, 'index'])->name('familyHome');
        Route::post('/family-details', [FamilyMemberController::class, 'show'])->name('family.details');
    });

    // roster related routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/shifts/index', [ShiftController::class, 'index'])->name('shifts.index');
        Route::post('/shifts/store', [ShiftController::class, 'store'])->name('shifts.store');
        Route::get('/shifts/{id}/edit', [ShiftController::class, 'edit'])->name('shifts.edit');
    });

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);






    // Roster creation and management routes for admin/supervisor
    Route::middleware(['auth', 'role:1, 2'])->group(function () {
        //account approval
        Route::get('/admin/pending_accounts', [AdminAccountController::class, 'index'])->name('admin.pending');
        Route::post('/admin/approve/{id}', [AdminAccountController::class, 'approve'])->name('admin.approve');
        Route::post('/admin/deny/{id}', [AdminAccountController::class, 'deny'])->name('admin.deny');

        //shifts
        Route::get('/shifts/create', [ShiftController::class, 'create'])->name('shifts.create');
        Route::get('/shifts', [ShiftController::class, 'index'])->name('shifts.index');//probably dont need this here -serena
        Route::post('/shifts', [ShiftController::class, 'store'])->name('shifts.store');
        Route::get('/shifts/{id}/edit', [ShiftController::class, 'edit'])->name('shifts.edit');
        Route::put('/shifts/{id}', [ShiftController::class, 'update'])->name('shifts.update');
        
        //List of Patient/addditionalifo and employees/salary. Accessible to both admin/supervisor (supervisor cant change salary however) -serena
        Route::get('/employeelist', [AdminAccountController::class, 'adminEmployeeList'])->name('employeeList');

        Route::get('/additionalInfo/{id}', [PatientController::class, 'patientDetails'])->name('additionalInfo');
        Route::post('/additionalInfo/{id}', [PatientController::class, 'updatingDetails'])->name('updatingDetails');

        //appointments
        Route::get('/appointment/create', [AppointmentController::class, 'create'])->name('appointment.create');
        Route::post('/appointment/store', [AppointmentController::class, 'store'])->name('appointment.store');
        Route::get('/patients/{id}', [AppointmentController::class, 'getPatient']);
        Route::get('/doctors/scheduled/{date}', [AppointmentController::class, 'getScheduledDoctors']);

        //adminReport Routes
        Route::get('/admin-report', [AdminReportController::class, 'index'])->name('admin.report');//supposed to be under supervisor and admin

        //filtering for patient lists
        Route::get('/patients', [AdminAccountController::class, 'patientList'])->name('patientList');
        Route::get('/patient-list', [AdminAccountController::class, 'patientList'])->name('patientList');
    });
    Route::middleware(['auth', 'role:1, 2, 3, 4'])->group(function () {
        Route::get('/patientlist', [AdminAccountController::class, 'adminPatientList'])->name('patientList');
    });

    Route::get('/unauthorized', function () {
        return view('unauthorized');
    })->name('unauthorized');
    
    Route::get('/api/patients/{id}/payment-details', [AdminPaymentController::class, 'fetchPaymentDetails']);


    Route::get('/roster', [ShiftController::class, 'roster'])->name('roster');

    Route::get('/shifts', [ShiftController::class, 'index'])->name('shifts.index');

    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');
    
    Route::get('/privacy', function () {
        return view('privacy');
    })->name('privacy');
    

    require __DIR__.'/auth.php';