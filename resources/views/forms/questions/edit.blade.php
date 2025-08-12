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
            <option value="alimentacion" {{ old('category', $question->category) == 'alimentacion' ? 'selected' : '' }}>Alimentación</option>
            <option value="habla" {{ old('category', $question->category) == 'habla' ? 'selected' : '' }}>Habla</option>
            <option value="cognitiva" {{ old('category', $question->category) == 'cognitiva' ? 'selected' : '' }}>Cognitiva</option>
            <option value="motora" {{ old('category', $question->category) == 'motora' ? 'selected' : '' }}>Motora</option>
            <option value="emocional" {{ old('category', $question->category) == 'emocional' ? 'selected' : '' }}>Emocional</option>
            <option value="social" {{ old('category', $question->category) == 'social' ? 'selected' : '' }}>Social</option>
            <option value="sueño" {{ old('category', $question->category) == 'sueño' ? 'selected' : '' }}>Sueño</option>
            <option value="sensorial" {{ old('category', $question->category) == 'sensorial' ? 'selected' : '' }}>Sensoria</option>
            <option value="memoria" {{ old('category', $question->category) == 'memoria' ? 'selected' : '' }}>Memoria</option>
            <option value="lecura" {{ old('category', $question->category) == 'lecura' ? 'selected' : '' }}>Lecura</option>
            <option value="escritura" {{ old('category', $question->category) == 'escritura' ? 'selected' : '' }}>Escritura</option>
            </select>
        </div>

        <div class="mb-3 form-group">
            <label for="question" class="form-label">Pregunta</label>
            <input type="text" class="form-control" id="question" name="question" value="{{ old('question', $question->question_text) }}" required>
        </div>

        {{-- <div class="mb-3 form-group">
            <label for="type" class="form-label">Tipo</label>
            <select class="form-control" id="type" name="type" required>
                <option value="text" {{ $question->type == 'text' ? 'selected' : '' }}>Texto</option>
                <option value="multiple" {{ $question->question_type == 'multiple' ? 'selected' : '' }}>Radio</option>
            </select>
        </div> --}}

        {{-- <div class="mb-3 form-group">
            <label for="order" class="form-label">Orden</label>
            <input type="number" class="form-control" id="order" name="order" min="1" value="{{ old('order', $question->order) }}" required>
        </div> --}}
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="active" name="active" {{ $question->active ? 'checked' : '' }}>
            <label class="form-check-label" for="active">Activo</label>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('forms.questions.index', $question->form_id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
