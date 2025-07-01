@extends('welcome')

@section('content')
<div class="container">
    <h4>Preguntas de: {{ $form->name }}</h4>
    <a href="{{ route('forms.questions.create', $form) }}" class="btn btn-primary mb-2">Nueva Pregunta</a>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table">
        <thead>
            <tr><th>Pregunta</th><th>Tipo</th><th>Orden</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            @foreach($questions as $q)
            <tr>
                <td>{{ $q->question_text }}</td>
                <td>{{ $q->question_type }}</td>
                <td>{{ $q->order }}</td>
                <td>
                    <a href="{{ route('forms.questions.edit', [$form, $q]) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('forms.questions.destroy', [$form, $q]) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
