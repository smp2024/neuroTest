@extends('welcome')

@section('content')
<div class="container">
    <h2>Editar Información del Paciente</h2>
    <form action="{{ route('patients.update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- Datos del paciente -->
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $patient->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="dob" class="form-label">Fecha de Nacimiento</label>
            <input type="date" name="dob" class="form-control" value="{{ old('birth_date', $patient->birth_date) }}" required>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Género</label>
            <select name="gender" class="form-control" required>
                <option value="M" {{ old('gender', $patient->gender) == 'M' ? 'selected' : '' }}>Masculino</option>
                <option value="F" {{ old('gender', $patient->gender) == 'F' ? 'selected' : '' }}>Femenino</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $patient->address) }}">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" name="phone" class="form-control" value="{{ old('mobile', $patient->mobile) }}">
        </div>

        <hr>
        <h4>Personas Relacionadas</h4>
        @foreach($relatives as $i => $person)
        <div class="card mb-3">
            <div class="card-body">
                <input type="hidden" name="relatedPersons[{{ $i }}][id]" value="{{ $person->id }}">
                <div class="mb-2">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="relatedPersons[{{ $i }}][name]" class="form-control" value="{{ old("relatedPersons.$i.name_companion", $person->name_companion) }}" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Relación</label>
                    <input type="text" name="relatedPersons[{{ $i }}][relation]" class="form-control" value="{{ old("relatedPersons.$i.relationship_companion", $person->relationship_companion) }}" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="relatedPersons[{{ $i }}][phone]" class="form-control" value="{{ old("relatedPersons.$i.mobile_companion", $person->mobile_companion) }}">
                </div>
            </div>
        </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
