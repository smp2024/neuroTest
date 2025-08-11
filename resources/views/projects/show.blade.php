
@extends('welcome')

@section('content')
<div class="container">
    <h4>Detalle del Proyecto</h4>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $project->name }}</h5>
            <p class="card-text"><strong>Descripción:</strong> {{ $project->description }}</p>
            <p class="card-text"><strong>Fechas:</strong> {{ $project->start_date }} - {{ $project->end_date }}</p>
            <p class="card-text"><strong>Lugar:</strong> {{ $project->location }}</p>
            <p class="card-text"><strong>Responsable:</strong> {{ $responsable ? $responsable->name : '-' }}</p>
            <p class="card-text"><strong>Integrantes:</strong>
                @foreach($integrantes as $integrante)
                    <span class="badge badge-info">{{ $integrante->name }}</span>
                @endforeach
            </p>
        </div>
    </div>
    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Volver al listado</a>
</div>
@endsection
