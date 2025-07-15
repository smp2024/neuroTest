<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormQuestion;
use Illuminate\Http\Request;

class FormQuestionController extends Controller
{
    public function index(Form $form)
    {
        $questions = $form->questions()->orderBy('order')->get();
        return view('forms.questions.index', compact('form', 'questions'));
    }

    public function create(Form $form)
    {
        return view('forms.questions.create', compact('form'));
    }

    public function store(Request $request, Form $form)
    {

        $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:text,number,date,select,checkbox,radio',
            'order' => 'nullable|integer',
        ]);

        $form->questions()->create($request->only([
            'question_text', 'question_type', 'options', 'order'
        ]) + ['active' => (bool)$request->input('active')]);

        return redirect()->route('forms.questions.index', $form)->with('success', 'Pregunta creada');
    }

    public function edit(Form $form, FormQuestion $question)
    {
        // dd($question);
        return view('forms.questions.edit', compact('form', 'question'));
    }

    public function update(Request $request, Form $form, FormQuestion $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:text,number,date,select,checkbox,radio',
            'order' => 'nullable|integer',
        ]);

        $question->update($request->only([
            'question_text', 'question_type', 'options', 'order', 'active'
        ]) + ['active' => $request->has('active')]);

        return redirect()->route('forms.questions.index', $form)->with('success', 'Pregunta actualizada');
    }

    public function destroy(Form $form, FormQuestion $question)
    {
        $question->delete();
        return back()->with('success', 'Pregunta eliminada');
    }
}

