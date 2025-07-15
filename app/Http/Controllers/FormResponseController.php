<?php
namespace App\Http\Controllers;

use App\Models\FormLink;

class FormResponseController extends Controller
{
    public function index()
    {
        $links = FormLink::with(['person', 'form'])
                    ->latest()
                    ->get();
        // dd($links);
        $data = [
            'links' => $links,
        ];
        return view('admin.respuestas.index',  $data);
    }

    public function show(FormLink $formLink)
    {
        $form = $formLink->form;
        $person = $formLink->person;

        // $respuestas = $form->questions()->with(['respuestas' => function($q) use ($formLink) {
        // Replace 'respuestas' with the correct relationship name defined in FormQuestion model, e.g., 'answers'
        $respuestas = $form->questions()->with(['answers' => function($q) use ($formLink) {
            $q->where('patient_id', $formLink->patient_id);
        }])->get();
        // dd($respuestas);
        return view('admin.respuestas.show', compact('formLink', 'respuestas', 'person', 'form'));
    }
}


