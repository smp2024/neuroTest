@extends('welcome')

@section('content')
<div class="p-3">
    <h3>Agregar Paciente</h3>
    <form  method="POST" action="{{ route('patients.store') }}" enctype="multipart/form-data" id="form_patient">
        {{-- CSRF Token --}}
        @csrf

        {{-- DATOS DEL PACIENTE --}}
        <div class="card mb-4 p-4">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Nombre</label>
                    <input type="text" name="name" class="form-control" >
                </div>
                <div class="form-group col-md-3">
                    <label>Apellido Paterno</label>
                    <input type="text" name="paternal_surname" class="form-control" >
                </div>
                <div class="form-group col-md-3">
                    <label>Apellido Materno</label>
                    <input type="text" name="maternal_surname" class="form-control" >
                </div>
                <div class="form-group col-md-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" >
                </div>
                <div class="form-group col-md-3">
                    <label>Teléfono</label>
                    <input type="text" name="mobile" class="form-control" >
                </div>
                <div class="form-group col-md-3">
                    <label>Fecha de nacimiento</label>
                    <input type="date" name="birth_date" class="form-control" >
                </div>
                <div class="form-group col-md-2">
                    <label>Género</label><br>
                    <select name="gender" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Male">Hombre</option>
                        <option value="Female">Mujer</option>
                        <option value="Other">Otro</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>Nivel Escolar</label>
                    <select name="education_level" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Maternal">Maternal</option>
                        <option value="Kinder">Kinder</option>
                        <option value="Primaria">Primaria</option>
                        <option value="Secundaria">Secundaria</option>
                        <option value="Preparatoria">Preparatoria</option>
                        <option value="Licenciatura">Licenciatura</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>Grado Escolar</label>
                    <select name="education_grade" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>

                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Foto</label>
                    <input type="file" name="avatar" class="form-control-file">
                </div>
                <div class="form-group col-md-3">
                    <label>Código Postal</label>
                    <div class="input-group">
                        <input type="text" id="postal_code" name="postal_code" class="form-control" >
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" id="validate_cp">Validar C.P.</button>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label>Estado</label>
                    <select name="state" id="state" class="form-control" ></select>
                </div>
                <div class="form-group col-md-3">
                    <label>Ciudad</label>
                    <select name="city" id="city" class="form-control" ></select>
                </div>
                <div class="form-group col-md-3">
                    <label>Colonia</label>
                    <select name="colony" id="colony" class="form-control" ></select>
                </div>
                <div class="form-group col-md-4">
                    <label>Dirección</label>
                    <input type="text" name="street" class="form-control">
                </div>

                <div class="form-group col-md-1">
                    <label>No. Ext</label>
                    <input type="text" name="interior_number" class="form-control">
                </div>

                <div class="form-group col-md-1">
                    <label>No. Int</label>
                    <input type="text" name="exterior_number" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Referencias</label>
                    <input type="text" name="reference" class="form-control">
                </div>
            </div>

        </div>

        {{-- FAMILIARES --}}
        <h4>Responsable / Familiares</h4>
        <div id="relatives-container">
            <div class="card p-3 mb-3 relative-row">
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label>Tipo de persona</label>
                        <select name="relatives[0][type_person]" class="form-control type-person" >
                            <option value="0">Titular</option>
                            <option value="1">Familiar</option>
                            <option value="2">Especialista</option>
                        </select>
                    </div>
                    <div class="form-group col-md-1">
                        <label>Parentezco</label>
                        <select name="relatives[0][relationship]" class="form-control" >
                            <option value="Padre">Padre</option>
                            <option value="Madre">Madre</option>
                            <option value="Hermano">Hermano</option>
                            <option value="Tío">Tío</option>
                            <option value="Abuelo">Abuelo</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Nombre(s)</label>
                        <input type="text" name="relatives[0][name]" class="form-control" >
                    </div>
                    <div class="form-group col-md-2">
                        <label>Apellido(s)</label>
                        <input type="text" name="relatives[0][surname]" class="form-control" >
                    </div>
                    <div class="form-group col-md-2">
                        <label>Teléfono(celular)</label>
                        <input type="text" name="relatives[0][mobile]" class="form-control" >
                    </div>
                    <div class="form-group col-md-2">
                        <label>Email</label>
                        <input type="email" name="relatives[0][email]" class="form-control" >
                    </div>
                    <div class="form-group col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-relative d-none">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" id="add-relative" class="btn btn-outline-primary mb-3">+ Agregar Persona</button>
        <br>
        {{-- <button type="submit" class="btn btn-success">Guardar</button> --}}
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmModal">
            Siguiente
        </button>
        <!-- Modal de confirmación -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar envío</h5>
                </div>
                <div class="modal-body">
                    Se enviará un link del cuestionario a los familiares registrados. ¿Deseas continuar?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success sumit-form">Aceptar y Continuar</button>
                </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
let relativeIndex = 1;

$('#add-relative').click(function() {
    const newRelative = $('.relative-row:first').clone();
    newRelative.find('input, select').each(function() {
        const name = $(this).attr('name');
        const newName = name.replace(/\[0\]/, `[${relativeIndex}]`);
        $(this).attr('name', newName).val('');
    });
    newRelative.find('.remove-relative').removeClass('d-none');
    $('#relatives-container').append(newRelative);
    relativeIndex++;
});

$(document).on('click', '.remove-relative', function() {
    $(this).closest('.relative-row').remove();
});
$(document).on('click', '.submit-form', function() {
    $('#form_patient').submit();
});

// VALIDAR CP CON AJAX
$('#validate_cp').click(function() {
    let cp = $('#postal_code').val();
    $.ajax({
        url: '{{ url("/api/cp-validar") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            cp: cp
        },
        success: function(data) {
            $('#state').html(`<option value="${data.state}">${data.state}</option>`);
            $('#city').html(`<option value="${data.municipality}">${data.municipality}</option>`);
            $('#colony').html('');
            data.colonies.forEach(colonia => {
                $('#colony').append(`<option value="${colonia.name}">${colonia.name}</option>`);
            });
        },
        error: function() {
            alert('Código postal no encontrado.');
            console.log(data);

        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');

    form.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            console.log('Enter key pressed, preventing default form submission.');
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endsection
