<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Form;
use App\Models\FormQuestion;

class FormQuestionsSeeder extends Seeder
{
    public function run(): void
    {
        // Creamos o encontramos un formulario base
        $form = Form::firstOrCreate([
            'name' => 'Cuestionario Familiar',
        ], [
            'slug' => 'cuestionario-familiar',
            'description' => 'Formulario general para padres y familiares',
            'type' => 'todas_edades',
            'group' => '1',
        ]);

        $preguntas = [
            ['text' => '¿Tu hijo te mira a los ojos cuando le hablas?'],
            ['text' => '¿Tu hijo responde a su nombre cuando lo llamas?'],
            ['text' => '¿Tu hijo sonríe espontáneamente al verte?'],
            ['text' => '¿Tu hijo hace gestos para comunicar algo?'],
            ['text' => '¿Tu hijo imita gestos o sonidos?'],
            ['text' => '¿Tu hijo entiende instrucciones simples?'],
            ['text' => '¿Tu hijo señala objetos para mostrártelos?'],
            ['text' => '¿Tu hijo muestra interés por otros niños?'],
        ];

        foreach ($preguntas as $index => $p) {
            FormQuestion::create([
                'form_id' => $form->id,
                'question_text' => $p['text'],
                'question_type' => 'radio',
                'options' => 'Nunca, Poco, Algo, Mucho',
                'order' => $index + 1,
                'active' => true,
            ]);
        }
    }
}
