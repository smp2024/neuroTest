@extends('welcome')
@section('content')
<div class="container">
    <h1>Pacientes</h1>
    <table id="patients-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th># Formularios</th>
                <th># Cuestionarios Contestados</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->paternal_surname }}</td>
                <td>{{ $patient->maternal_surname }}</td>
                <td>{{ $patient->forms_count }}</td>
                <td>{{ $patient->answered_count }}</td>
                <td>
                    <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info btn-sm">Ver perfil</a>
                    <a href="{{ route('patient.edit', $patient->id) }}" class="btn btn-warning btn-sm">Editar paciente</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#patients-table').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });
});
</script>
@endpush
