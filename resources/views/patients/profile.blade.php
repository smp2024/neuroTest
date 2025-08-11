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
<script>
    // console.log('scatterData');

    var scatterData = [
        @foreach($scatterData as $point)
            {
                x: {{ $point['x'] }},
                y: {{ $point['y'] }},
                label: "{{ $point['label'] }}",
                form: "{{ $point['form'] }}",
                details: {!! json_encode($point['details']) !!}
            },
        @endforeach
    ];
    var data = {
        datasets: [{
            label: 'Respuestas',
            data: scatterData,
            backgroundColor: 'rgba(54, 162, 235, 0.6)'
        }]
    };
    var config = {
        type: 'scatter',
        data: data,
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var d = context.raw;
                            return d.label + ' | ' + d.form + ' | Puntaje: ' + d.y;
                        }
                    }
                }
            },
            onClick: function(evt, elements) {
                if (elements.length > 0) {
                    var idx = elements[0].index;
                    var d = scatterData[idx];
                    var html = '<h5>Detalles de respuestas de ' + d.label + '</h5>';
                    html += '<ul>';
                    for (const [q, val] of Object.entries(d.details)) {
                        html += '<li><strong>Pregunta ' + q + ':</strong> ' + val + '</li>';
                    }
                    html += '</ul>';
                    document.getElementById('scatterDetails').innerHTML = html;
                }
            },
            scales: {
                x: { title: { display: true, text: 'Preguntas' } },
                y: { title: { display: true, text: 'Puntaje' } }
            }
        }
    };
    var chart = new Chart(document.getElementById('scatterChart'), config);
</script>
@endsection
