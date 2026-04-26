<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComplaintController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Staff login entry point — used in welcome emails.
// If an admin (or anyone) is already logged in, logs them out first,
// then shows the standard login page so the new staff member can sign in.
Route::get('/staff-login', [AuthController::class, 'showStaffLogin'])->name('staff.login.entry');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile',           [ProfileController::class, 'show'])->name('profile.index');
    Route::get('/profile/edit',      [ProfileController::class, 'show'])->name('profile.edit');
    Route::put('/profile',           [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/email',     [ProfileController::class, 'updateEmail'])->name('profile.email');
    Route::put('/profile/password',  [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/resend',   [ProfileController::class, 'resendVerification'])->name('profile.resend');
    Route::post('/profile/photo',    [ProfileController::class, 'uploadPhoto'])->name('profile.photo');
 
    Route::get('/verify-email', [AuthController::class, 'showVerification'])->name('verification.notice');
    Route::get('/verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])->middleware(['throttle:6,1'])->name('verification.send');
    Route::post('/verify-email/update', [ProfileController::class, 'updateEmail'])->name('verification.update_email');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/structure',                         [AdminController::class, 'structure'])->name('structure');
    Route::post('/structure',                        [AdminController::class, 'storeStructure'])->name('structure.store');
    Route::post('/structure/floors',                 [AdminController::class, 'storeFloor'])->name('structure.storeFloor');
    Route::post('/structure/rooms/generate',         [AdminController::class, 'generateRooms'])->name('structure.generateRooms');
    Route::put('/structure/floors/{floor_id}',          [AdminController::class, 'updateFloor'])->name('structure.updateFloor');
    Route::delete('/structure/floors/{floor_id}',       [AdminController::class, 'destroyFloor'])->name('structure.destroyFloor');
    Route::put('/structure/rooms/{room_id}',            [AdminController::class, 'updateRoom'])->name('structure.updateRoom');
    Route::delete('/structure/rooms/{room_id}',         [AdminController::class, 'destroyRoom'])->name('structure.destroyRoom');
    Route::put('/structure/washrooms/{washroom_id}',    [AdminController::class, 'updateWashroom'])->name('structure.updateWashroom');
    Route::delete('/structure/washrooms/{washroom_id}', [AdminController::class, 'destroyWashroom'])->name('structure.destroyWashroom');

    Route::get('/tasks',                  [AdminController::class, 'tasks'])->name('tasks');
    Route::get('/tasks/export',           [AdminController::class, 'exportTasks'])->name('tasks.export');
    Route::post('/tasks/assign',          [AdminController::class, 'assignTasks'])->name('tasks.assign');
    Route::post('/tasks/bulk',            [AdminController::class, 'assignBulkTasks'])->name('tasks.bulk');
    Route::post('/tasks/{task_id}/complete', [AdminController::class, 'completeTask'])->name('tasks.complete');
    Route::delete('/tasks/{task_id}',        [AdminController::class, 'destroyTask'])->name('tasks.destroy');

    Route::get('/users',         [AdminController::class, 'users'])->name('users');
    Route::get('/users/export',  [AdminController::class, 'exportUsers'])->name('users.export');
    Route::post('/users',        [AdminController::class, 'createUser'])->name('users.store');
    Route::delete('/users/{user_id}',[AdminController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/staff/create',  [AdminController::class, 'showCreateStaff'])->name('create-staff');
    Route::post('/staff',        [AdminController::class, 'storeStaff'])->name('store-staff');
    Route::post('/users/{user_id}/resend-welcome', [AdminController::class, 'resendStaffWelcome'])->name('users.resend-welcome');

    Route::get('/complaints',                         [AdminController::class, 'showComplaints'])->name('complaints');
    Route::get('/complaints/export',                  [AdminController::class, 'exportComplaints'])->name('complaints.export');
    Route::post('/complaints/bulk',                   [AdminController::class, 'bulkActionComplaints'])->name('complaints.bulk');
    Route::patch('/complaints/{complaint_id}',        [AdminController::class, 'updateComplaintStatus'])->name('complaints.update');
    Route::post('/complaints/{complaint_id}/resolve', [AdminController::class, 'resolveComplaint'])->name('complaints.resolve');
    Route::get('/complaints/print-all',               [AdminController::class, 'printComplaints'])->name('complaints.print_all');
    Route::get('/print-manifest',                     [AdminController::class, 'printCleaningManifest'])->name('print');

    Route::get('/registry/users',  [AdminController::class, 'usersRegistry'])->name('registry.users');
    Route::get('/registry/logs',   [AdminController::class, 'operationLogs'])->name('registry.logs');
    Route::get('/registry/assets', [AdminController::class, 'assetDatabase'])->name('registry.assets');

    Route::get('/database/users',      [AdminController::class, 'databaseUsers'])->name('database.users');
    Route::get('/database/floors',     [AdminController::class, 'databaseFloors'])->name('database.floors');
    Route::get('/database/floors/export', [AdminController::class, 'exportFloors'])->name('database.floors.export');
    Route::get('/database/rooms',      [AdminController::class, 'databaseRooms'])->name('database.rooms');
    Route::get('/database/tasks',      [AdminController::class, 'databaseTasks'])->name('database.tasks');
    Route::get('/database/complaints', [AdminController::class, 'databaseComplaints'])->name('database.complaints');
});

Route::middleware(['auth', 'verified', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard',    [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/tasks',        [StaffController::class, 'tasks'])->name('tasks');
    Route::post('/tasks/{task}/start',    [StaffController::class, 'startTask'])->name('tasks.start');
    Route::post('/tasks/{task}/complete', [StaffController::class, 'completeTask'])->name('tasks.complete');
    Route::post('/tasks/bulk-complete',   [StaffController::class, 'bulkCompleteTasks'])->name('tasks.complete.bulk');
    Route::get('/print',          [StaffController::class, 'printManifest'])->name('print');
    Route::get('/complaints',     [StaffController::class, 'complaints'])->name('complaints');
    Route::post('/complaints/bulk',                [StaffController::class, 'bulkActionComplaints'])->name('complaints.bulk');
    Route::post('/complaints/{complaint}/start',   [StaffController::class, 'startComplaint'])->name('complaints.start');
    Route::post('/complaints/{complaint}/resolve', [StaffController::class, 'resolveComplaint'])->name('complaints.resolve');
    Route::get('/complaints/print-all',            [StaffController::class, 'printComplaints'])->name('complaints.print_all');
});

Route::middleware(['auth', 'verified'])->prefix('complaints')->name('complaints.')->group(function () {
    Route::get('/',            [ComplaintController::class, 'index'])->name('index');
    Route::get('/create',      [ComplaintController::class, 'create'])->name('create');
    Route::post('/',           [ComplaintController::class, 'store'])->name('store');
    Route::get('/{complaint}', [ComplaintController::class, 'show'])->name('show');
    Route::get('/{complaint}/print', [ComplaintController::class, 'print'])->name('print');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});
