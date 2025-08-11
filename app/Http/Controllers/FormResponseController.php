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

    public function show($id)
    {
        $formLink = FormLink::findOrFail($id);
        $form = $formLink->form;
        $person = $formLink->person;

        $respuestas = $form->questions()->with(['answers' => function($q) use ($formLink) {
            $q->where('patient_id', $formLink->patient_id)->where('patient_person_id', $formLink->relative_id);
        }])->get();
        return view('admin.respuestas.show', compact('formLink', 'respuestas', 'person', 'form'));
    }
}


