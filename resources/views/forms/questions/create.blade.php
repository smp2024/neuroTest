@extends('welcome')

@section('content')
<div class="container">
    <h4>Agregar Pregunta a {{ $form->name }}</h4>
    <form action="{{ route('forms.questions.store', $form) }}" method="POST">@csrf
        <div class="form-group">
            <label>Categoría:</label>
            <select name="category" class="form-control" required>
                <option value="">Seleccione una categoría</option>
                <option value="alimentacion">Alimentación</option>
                <option value="habla">Habla</option>
                <option value="cognitiva">Cognitiva</option>
                <option value="motora">Motora</option>
                <option value="emocional">Emocional</option>
                <option value="social">Social</option>
            </select>
        </div>

        <div class="form-group">
            <label>Texto de la pregunta:</label>
            <textarea name="question_text" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Tipo de campo:</label>
            <select name="question_type" class="form-control">
                <option value="radio">Opción única</option>
                <option value="checkbox">Opción múltiple</option>
                <option value="text">Texto</option>
                <option value="number">Número</option>
                <option value="date">Fecha</option>
                <option value="select">Desplegable</option>
            </select>
        </div>

        <div class="form-group">
            <label>Opciones (solo si aplica, separadas por coma):</label>
            <input type="text" name="options" class="form-control" placeholder="Nunca, Poco, Algo, Mucho">
        </div>

        <div class="form-group">
            <label>Orden:</label>
            <input type="number" name="order" min="1" class="form-control" value="1" required>
        </div>

        <div class="form-group form-check">
            <input type="checkbox" name="active" class="form-check-input" checked>
            <label class="form-check-label">Activo</label>
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('forms.questions.index', $form) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
