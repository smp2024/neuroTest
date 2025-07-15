@extends('welcome')

@section('content')
<div class="container">
    <h2>Editar Pregunta</h2>
    <form action="{{ route('forms.questions.update', [$question->form_id, $question->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3 form-group">
            <label for="category" class="form-label">Categoría</label>
            <select class="form-control" id="category" name="category" required>
                <option value="">Seleccione una categoría</option>
                <option value="alimentacion" {{ $question->category == 'alimentacion' ? 'selected' : '' }}>Alimentación</option>
                <option value="habla" {{ $question->category == 'habla' ? 'selected' : '' }}>Habla</option>
                <option value="cognitiva" {{ $question->category == 'cognitiva' ? 'selected' : '' }}>Cognitiva</option>
                <option value="motora" {{ $question->category == 'motora' ? 'selected' : '' }}>Motora</option>
                <option value="emocional" {{ $question->category == 'emocional' ? 'selected' : '' }}>Emocional</option>
                <option value="social" {{ $question->category == 'social' ? 'selected' : '' }}>Social</option>
            </select>
        </div>

        <div class="mb-3 form-group">
            <label for="question" class="form-label">Pregunta</label>
            <input type="text" class="form-control" id="question" name="question" value="{{ old('question', $question->question_text) }}" required>
        </div>

        <div class="mb-3 form-group">
            <label for="type" class="form-label">Tipo</label>
            <select class="form-control" id="type" name="type" required>
                <option value="text" {{ $question->type == 'text' ? 'selected' : '' }}>Texto</option>
                <option value="multiple" {{ $question->question_type == 'multiple' ? 'selected' : '' }}>Opción múltiple</option>
                <option value="boolean" {{ $question->question_type == 'boolean' ? 'selected' : '' }}>Verdadero/Falso</option>
                <option value="radio"  {{ $question->question_type == 'radio' ? 'selected' : '' }}>Opción única</option>
                <option value="number"  {{ $question->question_type == 'number' ? 'selected' : '' }}>Número</option>
                <option value="date"  {{ $question->question_type == 'date' ? 'selected' : '' }}>Fecha</option>
                <option value="select"  {{ $question->question_type == 'select' ? 'selected' : '' }}>Desplegable</option>
            </select>
            </select>
        </div>

        <div class="mb-3 form-group">
            <label for="order" class="form-label">Orden</label>
            <input type="number" class="form-control" id="order" name="order" min="1" value="{{ old('order', $question->order) }}" required>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="active" name="active" {{ $question->active ? 'checked' : '' }}>
            <label class="form-check-label" for="active">Activo</label>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('forms.questions.index', $question->form_id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
