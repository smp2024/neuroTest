@extends('welcome')

@section('content')
<div class="container">
    <h4>Crear Formulario</h4>
    <form action="{{ route('forms.store') }}" method="POST">@csrf

        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>Tipo:</label>
            <select name="type" class="form-control" id="type-select" required>
                <option value="todas_edades">Todas las edades</option>
                <option value="edad_especifica">Edad específica</option>
            </select>
        </div>

        <div class="form-group" id="edad-especifica-group" style="display: none;">
            <label>Edad:</label>
            <select name="edad_especifica" class="form-control">
                @for ($i = 0; $i <= 18; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label>Grupo:</label>
            <select name="group" class="form-control" required>
                <option value="1">Grupo 1</option>
                <option value="2">Grupo 2</option>
                <option value="3">Grupo 3</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('forms.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type-select');
        const edadGroup = document.getElementById('edad-especifica-group');
        typeSelect.addEventListener('change', function() {
            if (this.value === 'edad_especifica') {
                edadGroup.style.display = 'block';
            } else {
                edadGroup.style.display = 'none';
            }
        });
    });
    </script>
</div>
@endsection
