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
                        {{ optional($pregunta->answers->first())->resp ?? 'Sin responder' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
