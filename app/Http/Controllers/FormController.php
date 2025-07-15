<?php

namespace App\Http\Controllers;

use App\Models\FormLink;
use App\Models\FormPatient;
use App\Models\FormQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Form;

class FormController extends Controller
{
    public function responderFormulario($token)
    {
        $link = FormLink::where('token', $token)->firstOrFail();

        if ($link->used) {
            abort(403, 'Formulario ya fue contestado.');
        }

        if (now()->greaterThan($link->expires_at)) {
            abort(403, 'El enlace ha expirado.');
        }

        return view('formulario.familiares', [
            'patient' => $link->patient,
            'relative' => $link->relative
        ]);
    }

    public function mostrar($token)
    {
        $link = FormLink::where('token', $token)->firstOrFail();

        if ($link->used) {
            abort(403, 'Este formulario ya fue contestado.');
        }

        if (now()->greaterThan($link->expires_at)) {
            abort(403, 'El formulario ha expirado.');
        }

        $questions = FormQuestion::all();

        return view('formulario.familiares', [
            'token' => $token,
            'patient' => $link->patient,
            'relative' => $link->relative,
            'questions' => $questions
        ]);
    }

    public function guardar(Request $request, $token)
    {
        $link = FormLink::where('token', $token)->firstOrFail();

        if ($link->used || now()->greaterThan($link->expires_at)) {
            return abort(403, 'No puedes enviar este formulario.');
        }

        foreach ($request->answers as $question_id => $answer) {
            FormPatient::create([
                'form_id' => $link->form_id,
                'form_question_id' => $question_id,
                'patient_id' => $link->patient_id,
                'relative_id' => $link->relative_id,
                'question_id' => $question_id,
                'answer' => $answer
            ]);
        }

        $link->used = true;
        $link->save();

        return view('formulario.gracias');
    }


    public function index()
    {
        $forms = Form::latest()->get();
        return view('forms.index', compact('forms'));
    }

    public function create()
    {
        return view('forms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:todas_edades,edad_especifica',
            'group' => 'required|in:1,2,3',
        ]);

        $form =  Form::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . uniqid()),
            'description' => $request->description,
            'type' => $request->type,
            'group' => $request->group,
        ]);

        // return redirect()->route('forms.index')->with('success', 'Formulario creado');

        return redirect()->route('forms.questions.create', ['form' => $form->id])->with('success', 'Formulario creado con éxito');
    }

    public function edit(Form $form)
    {
        return view('forms.edit', compact('form'));
    }

    public function update(Request $request, Form $form)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:todas_edades,edad_especifica',
            'group' => 'required|in:1,2,3',
        ]);

        $form->update($request->only(['name', 'description', 'type', 'group']));

        return redirect()->route('forms.index')->with('success', 'Formulario actualizado');
    }

    public function destroy(Form $form)
    {
        $form->delete();
        return back()->with('success', 'Formulario eliminado');
    }

    public function storeRespuestas(Request $request, $token)
    {
        $link = FormLink::where('token', $token)->firstOrFail();

        foreach ($request->answers as $question_id => $value) {
            FormPatient::create([
                'form_id' => $link->form_id,
                'form_question_id' => $question_id,
                'form_id' => $link->form_id,
                'form_question_id' => $question_id,
                'patient_person_id' => $link->patient_id,
                'value' => $value
            ]);
        }

        $link->update(['used_at' => now()]);

        return view('formulario.gracias');
    }

    public function formFam($token)
    {
        $tk= Str::replaceFirst(' ', '', $token);
        $token = Str::replaceFirst(' ', '', $tk);
        $link = FormLink::where('token', $token)->firstOrFail();
        $questions = formQuestion::all();

        if ($link->used) {
            abort(403, 'Este formulario ya fue contestado.');
        }

        if (now()->greaterThan($link->expires_at)) {
            abort(403, 'El formulario ha expirado.');
        }
        $data = [
            'token' => $token,
            'patient' => $link->patient,
            'relative' => $link->relative,
            'questions' => $questions,
            'link' => $link
        ];
        // dd($data);
        return view('forms.familiares', $data);

    }
    public function storeRespuestasFamiliares(Request $request, $token)
    {
        // dd($request->all());
        $link = FormLink::where('token', $token)->first();
        if ($link->used_at || now()->greaterThan($link->expires_at)) {
            return abort(403, 'No puedes enviar este formulario.');
        }
        $resp = $request->answers;
        if (empty($resp)) {
            return redirect()->back()->with('error', 'No se han enviado respuestas.');
        }
        // dd($resp);
        foreach ($request->answers as $question_id => $answer) {
            // FormPatient::create([
            //     'form_id' => $link->form_id,
            //     'form_question_id' => $question_id,
            //     'patient_id' => $link->patient_id,
            //     'relative_id' => $link->relative_id,
            //     'question_id' => $question_id,
            //     'answer' => $answer
            // ]);
            $fp = new FormPatient();
            $fp->form_id = $link->form_id;
            $fp->form_question_id = $question_id;
            $fp->patient_id = $link->patient_id;
            $fp->patient_person_id = $link->relative_id;
            $fp->question_id = $question_id;
            $fp->answered = $answer;
            $fp->comments = $request->{'comment_' . $question_id} ?? null;
            $fp->save();
        }
        $link->used_at = true;
        $link->save();
        return view('forms.gracias');
    }
}
