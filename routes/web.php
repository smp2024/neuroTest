<?php

use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormQuestionController;
use App\Http\Controllers\FormResponseController;

Route::get('/', function () {
    return view('patients.create');
});
Route::get('/pacientes/crear', [PatientController::class, 'create'])->name('patients.create');
Route::post('/pacientes/guardar', [PatientController::class, 'store'])->name('patients.store');
Route::post('/cp/validar', [PatientController::class, 'validateCP']);
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
// Route::post('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');
// Route::post('/patient/{id}', [PatientController::class, 'edit'])->name('patient.edit');
Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');
Route::get('/patient/{id}', [PatientController::class, 'edit'])->name('patient.edit');
Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');

Route::get('/formulario/{token}', [FormController::class, 'mostrar']);
Route::post('/formulario/{token}', [FormController::class, 'guardar'])->name('formulario.guardar');

// Route::prefix('admin/forms')->name('forms.')->group(function () {
    Route::get('/forms', [FormController::class, 'index'])->name('forms.index');
    Route::get('/forms/create', [FormController::class, 'create'])->name('forms.create');
    Route::post('/forms', [FormController::class, 'store'])->name('forms.store');
    Route::get('/{form}/edit', [FormController::class, 'edit'])->name('forms.edit');
    Route::put('/{form}', [FormController::class, 'update'])->name('forms.update');
    Route::delete('/{form}', [FormController::class, 'destroy'])->name('forms.destroy');

    // Preguntas
    Route::get('/{form}/questions', [FormQuestionController::class, 'index'])->name('forms.questions.index');
    Route::get('/{form}/questions/create', [FormQuestionController::class, 'create'])->name('forms.questions.create');
    Route::post('/{form}/questions', [FormQuestionController::class, 'store'])->name('forms.questions.store');
    Route::get('/{form}/questions/{question}/edit', [FormQuestionController::class, 'edit'])->name('forms.questions.edit');
    Route::put('/{form}/questions/{question}', [FormQuestionController::class, 'update'])->name('forms.questions.update');
    Route::delete('/{form}/questions/{question}', [FormQuestionController::class, 'destroy'])->name('forms.questions.destroy');

    // Respuestas
    Route::get('/respuestas', [FormResponseController::class, 'index'])->name('respuestas.index');
    Route::get('/respuestas/{formLink}', [FormResponseController::class, 'show'])->name('respuestas.show');
    Route::get('/respuestas/{formLink}/export', [FormResponseController::class, 'export'])->name('respuestas.export');
// });

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/formulario/{token}/familiares', [FormController::class, 'formFam'])->name('form.familiares');
Route::post('/formulario/{token}/familiares', [FormController::class, 'storeRespuestasFamiliares'])->name('familiares.store');



