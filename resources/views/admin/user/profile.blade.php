@extends('welcome')

@section('content')
<div class="container">

    {{-- Fila 1: Perfil --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{ $user->photo_url ? asset('storage/'.$user->photo_url) : 'https://ui-avatars.com/api/?name='.urlencode($user->name.' '.$user->paternal_surname) }}"
                        class="rounded-circle mb-3"
                        width="120"
                        height="120"
                        onerror="this.onerror=null;this.src='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/person-circle.svg';this.style.background='#f0f0f0';this.style.objectFit='contain';">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="card-text">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Datos Generales</div>
                <div class="card-body">
                    <p><strong>Teléfono:</strong> {{ $user->phone }}</p>
                    <p><strong>Fecha de Nacimiento:</strong> {{ $user->birth_date }}</p>
                    <p><strong>Rol:</strong> {{ $user->role }}</p>
                    <p><strong>Estado:</strong> {{ $user->status }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Fila 2: Consultorio Activo --}}
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">Consultorio Activo</div>
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p><strong>Número de Consultorio:</strong> {{ $user->consultorio->numero ?? 'No asignado' }}</p>
                        <p><strong>Médico a Cargo:</strong> {{ $user->consultorio->medico->name ?? 'Sin médico asignado' }}</p>
                        @if($user->consultorio && $user->consultorio->citasHoy)
                            <p><strong>Citas del Día:</strong> {{ $user->consultorio->citasHoy->count() }}</p>
                        @else
                            <p><strong>Citas del Día:</strong> 0</p>
                        @endif
                    </div>
                    @if($user->consultorio && $user->consultorio->citasHoy->count())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->consultorio->citasHoy as $cita)
                                    <tr>
                                        <td>{{ $cita->paciente->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No hay citas programadas para hoy.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="citasModal" tabindex="-1" aria-labelledby="citasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="citasModalLabel">Citas del Día</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            @if($user->consultorio && $user->consultorio->citasHoy->count())
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->consultorio->citasHoy as $cita)
                            <tr>
                                <td>{{ $cita->paciente->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No hay citas programadas para hoy.</p>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>


    {{-- Fila 3: Proyectos actuales --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">Proyectos Actuales</div>
                <div class="card-body">
                    <table id="projectsTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre de Proyecto</th>
                                <th>Rol</th>
                            </tr>
                        </thead>
                            <tbody>
                                @forelse($user->projects as $project)
                                    <tr>
                                        <td>{{ $project->name }}</td>
                                        <td>{{ $project->client }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Sin proyectos activos</td>
                                    </tr>
                                @endforelse
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#projectsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            }
        });
    });
</script>
@endsection

@section('css')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection
