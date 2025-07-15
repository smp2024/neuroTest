<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormLink;
use App\Models\FormPatient;
use App\Models\Patient;
use App\Models\PatientPerson;
use App\Notifications\FormLinkNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
class PatientController extends Controller
{

    public function index()
    {
        $patients = Patient::withCount([
            'getPersons as forms_count',
            'getPersons as answered_count' => function($q) {
                $q->whereHas('formLink', function($q2) {
                    $q2->whereNotNull('expires_at');
                });
            }
        ])->get();
        return view('patients.index', compact('patients'));
    }

    public function show($id)
    {
        // dd('show' , $id);
        $patient = Patient::with(['getPersons.formLink.form', 'getDirection'])->findOrFail($id);
        // dd($patient);
        $forms_count = $patient->getPersons->count();
        $answered_count = $patient->getPersons->filter(function($p) {
            return optional($p->formLink)->expires_at !== null;
        })->count();
        $age = $patient->birth_date ? \Carbon\Carbon::parse($patient->birth_date)->age : null;

        // Obtener datos reales de respuestas para la gráfica con detalles
        // Inicializar datos para la gráfica
        $scatterData = [];

        // Obtener todas las respuestas de form_patients relacionadas con el paciente
        $formPatients = FormPatient::where('patient_id', $patient->id)
            ->get();
            // dd($formPatients[4]->resp);
            $i = 1;
        foreach ($formPatients as $fp) {
            $person = $patient->getPersons->where('id', $fp->patient_person_id)->first();
            $form = Form::find($fp->form_id);

            // Obtener todas las respuestas por pregunta
            $details = [];
            // if (is_string($fp->resp)) {
            //     $decoded = json_decode($fp->resp, true);
            //     if (is_array($decoded)) {
            //         $details = $decoded;
            //     }
            // } elseif (is_array($fp->resp)) {
            //     $details = $fp->resp;
            // }
            $details = $fp->resp;
            $score = is_array($details) ? array_sum($details) : 0;

            $scatterData[] = [
            'x' => $i++,
            'y' => $details,
            'label' => $person ? ($person->name_companion . ' ' . $person->surname_companion) : '',
            'form' => $form ? $form->name : '',
            'details' => $details,
            'comments' => $fp->comments,
            ];
        }
        // dd($scatterData);
        foreach ($patient->getPersons as $idx => $person) {
            if (optional($person->formLink)->answered_at) {
                $formPatients = \App\Models\FormPatient::where('relative_id', $person->id)
                    ->where('answered', 1)
                    ->get();
                foreach ($formPatients as $fp) {
                    $score = 0;
                    $details = [];
                    if (is_string($fp->answers)) {
                        $decoded = json_decode($fp->answers, true);
                        if (is_array($decoded)) {
                            $score = array_sum($decoded);
                            $details = $decoded;
                        }
                    } elseif (is_array($fp->answers)) {
                        $score = array_sum($fp->answers);
                        $details = $fp->answers;
                    }
                    $scatterData[] = [
                        'x' => $idx+1,
                        'y' => $score,
                        'label' => $person->name_companion . ' ' . $person->surname_companion,
                        'form' => optional($person->formLink->form)->name,
                        'details' => $details
                    ];
                }
            }
        }
        return view('patients.profile', compact('patient', 'forms_count', 'answered_count', 'age', 'scatterData'));
    }

    public function edit(Request $request, $id)
    {
        $patient = Patient::with(['getPersons'])->findOrFail($id);
        // dd($patient->getPersons);
        $relatives = $patient->getPersons ?? collect();
        return view('patients.edit', compact('patient', 'relatives'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        // dd('papa',$patient);
        // Validar y actualizar los datos del paciente
        $patient->update($request->all());
        return redirect()->route('patient.edit', $id)->with('message', 'Paciente actualizado correctamente');
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {

        $rules = [
            'name'      => 'required|string',
            'paternal_surname'   => 'required|string',
            'maternal_surname'   => 'required|string',
            'gender'    => 'required',
            'birth_date' => 'required|date',
            'postal_code' => 'required',
            'state'     => 'required',
            'city'      => 'required',
            'colony'    => 'required',
            'relatives' => 'required|array',
            'relatives.*.type_person' => 'required',
            'relatives.*.name' => 'required|string',
            'relatives.*.surname' => 'required|string',
            // 'relatives.*.email' => 'nullable|email',
            'relatives.*.mobile' => 'nullable|string',
            'relatives.*.relationship' => 'nullable|string',
        ];

        $messages = [
            'name.required' => 'El nombre es obligatorio.',
            'paternal_surname.required' => 'El apellido paterno es obligatorio.',
            'maternal_surname.required' => 'El apellido materno es obligatorio.',
            'gender.required' => 'El género es obligatorio.',
            'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
            'postal_code.required' => 'El código postal es obligatorio.',
            'state.required' => 'El estado es obligatorio.',
            'city.required' => 'La ciudad es obligatoria.',
            'colony.required' => 'La colonia es obligatoria.',
            'relatives.required' => 'Los familiares son obligatorios.',
            'relatives.*.type_person.required' => 'El tipo de persona es obligatorio.',
            'relatives.*.type_person.in' => 'El tipo de persona debe ser uno de los siguientes: Titular, Conyuge, Hijo, Padre, Madre, Otro.',
            'relatives.*.name.required' => 'El nombre del familiar es obligatorio.',
            'relatives.*.surname.required' => 'El apellido del familiar es obligatorio.',
            'relatives.*.email.email' => 'El correo electrónico del familiar debe ser una dirección de correo válida.',
            'relatives.*.mobile.string' => 'El número de móvil del familiar debe ser una cadena de texto.',
            'relatives.*.relationship.string' => 'La relación del familiar debe ser una cadena de texto.',
            'relatives.*.email.email' => 'El correo electrónico del familiar debe ser una dirección de correo válida.',
            'relatives.*.mobile.string' => 'El número de móvil del familiar debe ser una cadena de texto.',
            'relatives.*.relationship.string' => 'La relación del familiar debe ser una cadena de texto.',
            'relatives.*.name.required' => 'El nombre del familiar es obligatorio.',
            'relatives.*.surname.required' => 'El apellido del familiar es obligatorio.',
            'relatives.*.type_person.required' => 'El tipo de persona es obligatorio.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withInput();
        } else {

            // Guardar avatar
            $avatar = null;
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar')->store('avatars', 'public');
            }

            // Generar número de expediente
            $n_document = strtoupper(substr($request->surname, 0, 3)) .
                        strtoupper(substr($request->name, 0, 3)) .
                        strtoupper(substr($request->state, 0, 3)) .
                        rand(100, 999);

            // Crear paciente
            $patient = Patient::create([
                'name'      => $request->name,
                'surname'   => $request->surname,
                'paternal_surname' => $request->paternal_surname,
                'maternal_surname' => $request->maternal_surname,
                'email'     => $request->email,
                'mobile'    => $request->mobile,
                'gender'    => $request->gender,
                'education' => $request->education,
                'birth_date' => $request->birth_date,
                'avatar'    => $avatar,
                'n_document' => $n_document,

            ]);
            // Guardar dirección del paciente
            $patient->getDirection()->create([
                'postal_code' => $request->postal_code,
                'state'       => $request->state,
                'city'        => $request->city,
                'colony'      => $request->colony,
            ]);


            $familiaresData = $request->input('relatives', []);
            $titular = null;
            foreach ($familiaresData as $f) {
                $persona = new PatientPerson();
                $persona->name_companion = $f['name'];
                $persona->surname_companion = $f['surname'];
                $persona->email_companion = $f['email'] ?? null;
                $persona->mobile_companion = $f['mobile'] ?? null;
                $persona->relationship_companion = $f['relationship'] ?? null;
                $persona->type_person = $f['type_person'];
                $persona->patient_id = $patient->id;
                $persona->save();

                if ($f['type_person'] === '2') {
                    $form = Form::where('type', 'todas_edades')
                        ->where('group', 2)
                        ->first();
                } else {
                    $form = Form::where('type', 'todas_edades')
                        ->where('group', 1)
                        ->first();
                }

                // Enviar link al familiar
                $formLink = FormLink::create([
                    'patient_id' => $patient->id,
                    'relative_id' => $persona->id,
                    'token' => Str::uuid(),
                    'expires_at' => now()->addDays(7),
                    'form_id' => $form->id,

                ]);

                // Enviar por correo
                // Notification::route('mail', $persona->email)->notify(new FormLinkNotification($formLink));

                // Opcional: generar link WhatsApp
                $url = route('form.familiares', $formLink->token);
                $msg = urlencode("Hola {$persona->nombre}, contesta el cuestionario aquí: $url");
                $per = PatientPerson::find($persona->id);
                $per->whatsapp_link = "https://wa.me/52{$persona->telefono}?text=$msg";
                $per->form_link = $url;
                $per->token = $formLink->token;

                $per->save();



            }
            $formLinkTitular = PatientPerson::where('patient_id', $patient->id)
                ->where('type_person', 0)
                ->first();
                // dd($formLinkTitular);
            if (!$formLinkTitular) {
                    return back()->with('message', 'No se encontró el enlace del titular')->with('typealert', 'danger');
            }
            return redirect()->route('form.familiares', $formLinkTitular->token);
        }



    }

    public function validateCP(Request $request)
    {
        $cp = $request->cp;
        $jsonPath = base_path('public/cp_mexico.json');

        if (!file_exists($jsonPath)) {
            return response()->json(['error' => 'Base de datos CP no disponible'], 404);
        }

        $json = json_decode(file_get_contents($jsonPath), true);
        $info = collect($json)->firstWhere('codigo_postal', $cp);

        if (!$info) {
            return response()->json(['error' => 'Código postal no encontrado'], 404);
        }

        return response()->json([
            'estado'   => $info['estado'],
            'municipio'=> $info['municipio'],
            'colonias'=> explode('|', $info['colonias'])
        ]);
    }


}
