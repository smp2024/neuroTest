@extends('welcome')

@section('content')
<div class="container">
    <h3>Respuestas de Formularios</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Familiar</th>
                <th>Formulario</th>
                <th>Estado</th>
                <th>Fecha de respuesta</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($links as $link)
                <tr>
                    <td>{{ $link->person->patient->name }} {{ $link->person->patient->paternal_sourname }}</td>
                    <td>{{ $link->person->name_companion }}
                        @if ($link->person->type_person == '0' || $link->person->type_person == '1')
                            <span class="badge badge-info">Familiar</span>
                        @else
                            <span class="badge badge-secondary">Especialista</span>
                        @endif
                        {{-- ({{ $link->person->type_person }}) --}}
                    </td>
                    <td>{{ $link->form->name ?? 'N/A' }}</td>
                    <td>
                        @if($link->isUsed())
                            <span class="badge badge-success">Contestada</span>
                        @elseif($link->isExpired())
                            <span class="badge badge-danger">Expirada</span>
                        @else
                            <span class="badge badge-warning">Pendiente</span>
                        @endif
                    </td>
                    <td>
                        @if ($link->isUsed())
                            {{ optional($link->updated_at)->format('d/m/Y H:i') ?? '—' }}

                        @else
                            'Sin respuesta'
                        @endif
                        {{-- {{ optional($link->updated_at    )->format('d/m/Y H:i') ?? '—' }}</td> --}}
                    </td>
                    <td>
                        @if($link->isUsed())
                            <a href="{{ route('respuestas.show', $link) }}" class="btn btn-sm btn-primary">Ver</a>
                        @else
                            —
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
