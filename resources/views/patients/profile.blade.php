@extends('welcome')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $patient->avatar ? asset('storage/'.$patient->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($patient->name.' '.$patient->paternal_surname) }}"
                        class="rounded-circle mb-3"
                        width="120"
                        height="120"
                        onerror="this.onerror=null;this.src='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/person-circle.svg';this.style.background='#f0f0f0';this.style.objectFit='contain';">
                    <h3>{{ $patient->name }} {{ $patient->paternal_surname }} {{ $patient->maternal_surname }}</h3>
                    <p><strong>Edad:</strong> {{ $age ?? '-' }}</p>
                    <p><strong>Género:</strong> {{ $patient->gender }}</p>
                    <p><strong># Formularios:</strong> {{ $forms_count }}</p>
                    <p><strong># Cuestionarios contestados:</strong> {{ $answered_count }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h4>Formularios de familiares</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Cuestionario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patient->getPersons as $person)
                    <tr>
                        <td>{{ $person->name_companion }} {{ $person->surname_companion }}</td>
                        <td>{{ $person->type_person }}</td>
                        <td>{{ optional(optional($person->formLink)->form)->name ?? '-' }}</td>
                        <td>
                            @if(optional($person->formLink->expires_at))
                                <span class="badge bg-success">Contestado</span>
                            @else
                                <span class="badge bg-warning">Pendiente</span>
                            @endif
                        </td>
                        <td>
                            @if(optional($person->formLink)->token)
                                <a href="{{ route('respuestas.show', $person->formLink) }}" class="btn btn-primary btn-sm">Ver respuestas</a>
                            @endif
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#linkModal{{ $person->id }}">
                            Ver Link
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="linkModal{{ $person->id }}" tabindex="-1" role="dialog" aria-labelledby="linkModalLabel{{ $person->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="linkModalLabel{{ $person->id }}">Link de formulario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    <strong>Link:</strong>
                                    <a href="{{ $person->form_link }}" target="_blank">{{ $person->form_link }}</a>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <form action="" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Volver a enviar</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                            </div>
                        </div>
                        </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h4 class="mt-4">Gráfica de dispersión de respuestas</h4>
            <canvas id="scatterChart" width="400" height="200"></canvas>
            <div id="scatterDetails" class="mt-3"></div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Simulación de datos para la gráfica de dispersión
    var scatterData = [
        @foreach($scatterData as $point)
            {
                x: {{ $point['x'] }},
                y: @switch($point['y'])
                    @case(0) 50 @break
                    @case(1) 35 @break
                    @case(2) 25 @break
                    @case(3) 15 @break
                    @default {{ $point['y'] }}
                @endswitch,
                label: "{{ $point['label'] }}",
                form: "{{ $point['form'] }}",
                details: {!! json_encode($point['details']) !!}
            },
        @endforeach
    ];

console.log('scatterData', scatterData);

const ctx = document.getElementById('scatterChart').getContext('2d');
const scatterChart = new Chart(ctx, {
    type: 'line',
    data: {
        datasets: [{
            label: 'Respuestas',
            data: scatterData,
            backgroundColor: 'rgba(54, 162, 235, 0.6)'
        }]
    },
    options: {
        scales: {
            x: {
                type: 'linear',
                position: 'bottom',
                title: { display: true, text: 'Eje X' }
            },
            y: {
                title: { display: true, text: 'Eje Y' }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = scatterData[context.dataIndex].label || '';
                        return label + ': (' + context.parsed.x + ', ' + context.parsed.y + ')';
                    }
                }
            }
        }
    }
});
</script>
@endsection
