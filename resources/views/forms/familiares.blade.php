@extends('welcome')

@section('content')
<div class="container mt-4 mb-5">
    <h3>Formulario de Familiares</h3>
    <p>Por favor, responde las siguientes preguntas sobre tus familiares.</p>

    <form method="POST" action="{{ route('familiares.store', ['token' => $token]) }}" id="form_familiares">
        {{-- CSRF Token --}}
        @csrf

        @foreach($questions as $q)

            <div class="form-group">
                <label>{{ $q->question_text }}</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="answers[{{ $q->id }}]" value="0" required> Nunca
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="answers[{{ $q->id }}]" value="1"> Poco
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="answers[{{ $q->id }}]" value="2"> Algo
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="answers[{{ $q->id }}]" value="3"> Mucho
                </div>
                <div class="form-group">
                    <label for="comments">Comentarios adicionales:</label>
                    <textarea class="form-control" id="comments" name="comments[{{ $q->id }}]" rows="3"></textarea>
                </div>
            </div>
        @endforeach

        <input type="hidden" name="form_link_id" value="{{ $link->form_id }}">



        <button class="btn btn-primary" type="submit">Enviar respuestas</button>

    </form>
</div>

@endsection
