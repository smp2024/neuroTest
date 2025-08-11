@extends('welcome')

@section('content')
<div class="container">
    <h4>Crear Proyecto  </h4>
    <form action="{{ route('projects.store') }}" method="POST" >@csrf
        <div class="row">
            <div class="form-group col-6">
                <label>Nombre:</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group col-6">
                <label>Descripción:</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="form-group col-6">
                <label>Fecha de Inicio:</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="form-group col-6">
                <label>Fecha de Fin:</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="form-group col-6">
                <label>Lugar:</label>
                <input type="text" name="location" class="form-control" required>
            </div>
            <div class="form-group col-6">
                <label>Responsable:</label>
                <select name="responsible" class="form-control chosen-select" required>
                    <option value="">Seleccione un responsable</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-6">
                <label>Integrantes:</label>
                <select name="members[]" class="form-control chosen-select" multiple required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>

    @section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <script>
        $(function(){
            $('.chosen-select').chosen({width: '100%'});
        });
    </script>
    @endsection
</div>
@endsection
