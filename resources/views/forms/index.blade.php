@extends('welcome')

@section('content')
<div class="container">
    <h3>Formularios</h3>
    <a href="{{ route('forms.create') }}" class="btn btn-primary mb-3">Nuevo Formulario</a>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th><th>Grupo</th><th>Tipo</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($forms as $form)
            <tr>
                <td>{{ $form->name }}</td>
                <td>{{ $form->group }}</td>
                <td>{{ $form->type }}</td>
                <td>
                    <a href="{{ route('forms.edit', $form) }}" class="btn btn-sm btn-warning">Editar</a>
                    <a href="{{ route('forms.questions.index', $form) }}" class="btn btn-sm btn-info">Preguntas</a>
                    <form method="POST" action="{{ route('forms.destroy', $form) }}" class="d-inline">
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
