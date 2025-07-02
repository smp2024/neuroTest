<?php

use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormQuestionController;
use App\Http\Controllers\FormResponseController;

Route::get('/', function () {
    return view('patients.create');
});
Route::get('/pacientes/crear', [PatientController::class, 'create'])->name('create');
Route::post('/pacientes/guardar', [PatientController::class, 'store'])->name('store');
Route::post('/cp/validar', [PatientController::class, 'validateCP']);

Route::get('/formulario/{token}', [FormController::class, 'mostrar']);
Route::post('/formulario/{token}', [FormController::class, 'guardar'])->name('formulario.guardar');

Route::prefix('admin/forms')->name('forms.')->group(function () {
    Route::get('/', [FormController::class, 'index'])->name('index');
    Route::get('/create', [FormController::class, 'create'])->name('create');
    Route::post('/', [FormController::class, 'store'])->name('store');
    Route::get('/{form}/edit', [FormController::class, 'edit'])->name('edit');
    Route::put('/{form}', [FormController::class, 'update'])->name('update');
    Route::delete('/{form}', [FormController::class, 'destroy'])->name('destroy');

    // Preguntas
    Route::get('/{form}/questions', [FormQuestionController::class, 'index'])->name('questions.index');
    Route::get('/{form}/questions/create', [FormQuestionController::class, 'create'])->name('questions.create');
    Route::post('/{form}/questions', [FormQuestionController::class, 'store'])->name('questions.store');
    Route::get('/{form}/questions/{question}/edit', [FormQuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/{form}/questions/{question}', [FormQuestionController::class, 'update'])->name('questions.update');
    Route::delete('/{form}/questions/{question}', [FormQuestionController::class, 'destroy'])->name('questions.destroy');
});

Route::get('/formulario/{token}/familiares', [FormController::class, 'formFam'])->name('form.familiares');
Route::post('/formulario/{token}/familiares', [FormController::class, 'storeRespuestasFamiliares'])->name('familiares.store');


Route::get('/admin/respuestas', [FormResponseController::class, 'index'])->name('respuestas.index');
Route::get('/admin/respuestas/{formLink}', [FormResponseController::class, 'show'])->name('respuestas.show');
