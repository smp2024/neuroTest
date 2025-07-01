@extends('welcome')
@section('content')
<div class="container"></div>
    <h4>Editar Formulario</h4>
    <form action="{{ route('forms.update', $form) }}" method="POST">
    @csrf @method('PUT')
    <input type="text" name="name" value="{{ $form->name }}" ...>
    <textarea name="description">{{ $form->description }}</textarea>
    <!-- lo demás igual -->
    <div class="form-group">
        <label>Nombre:</label>
        <input type="text" name="name" class="form-control" value="{{ $form->name }}" required>
    </div>
    <div class="form-group">
        <label>Descripción:</label>
        <textarea name="description" class="form-control">{{ $form->description }}</textarea>
    </div>
    <div class="form-group">
        <label>Tipo:</label>
        <select name="type" class="form-control" required>
            <option value="todas_edades" {{ $form->type == 'todas_edades' ? 'selected' : '' }}>Todas las edades</option>
            <option value="edad_especifica" {{ $form->type == 'edad_especifica' ? 'selected' : '' }}>Edad específica</option>
        </select>
    </div>
    <div class="form-group">
        <label>Grupo:</label>
        <select name="group" class="form-control" required>
            <option value="1" {{ $form->group == '1' ? 'selected' : '' }}>Grupo 1</option>
            <option value="2" {{ $form->group == '2' ? 'selected' : '' }}>Grupo 2</option>
            <option value="3" {{ $form->group == '3' ? 'selected' : '' }}>Grupo 3</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('forms.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>

</div>
@endsection
