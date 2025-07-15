@extends('welcome')

@section('content')
<div class="container">
    <h4>Respuestas de {{ $person->nombre }} para el formulario: {{ $form->name }}</h4>

    <table class="table">
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Pregunta</th>
                <th>Respuesta</th>
            </tr>
        </thead>
        <tbody>
            @foreach($respuestas as $pregunta)
                <tr>
                    <td>{{ $pregunta->category }}</td>
                    <td>{{ $pregunta->question_text }}</td>
                    <td>
                        {{ optional($pregunta->answers->first())->answered ?? 'Sin responder' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('respuestas.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
