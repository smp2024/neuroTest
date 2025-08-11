@extends('welcome')

@section('content')
<div class="container">
    <h3>Listado de Proyectos</h3>
    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Nuevo Proyecto</a>

    <table id="projects-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Fechas</th>
                <th>Lugar</th>
                <th>Responsable</th>
                <th>Integrantes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->description }}</td>
                    <td>{{ $project->start_date }} - {{ $project->end_date }}</td>
                    <td>{{ $project->location }}</td>
                    <td>
                        @php
                            $responsable = $project->users()->wherePivot('role', 'responsable')->first();
                        @endphp
                        {{ $responsable ? $responsable->name : '-' }}
                    </td>
                    <td>
                        @php
                            $integrantes = $project->users()->wherePivot('role', 'integrante')->get();
                        @endphp
                        @foreach($integrantes as $integrante)
                            <span class="badge badge-info">{{ $integrante->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
@section('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#projects-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>
@endsection
