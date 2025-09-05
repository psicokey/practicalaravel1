<?php

namespace App\Http\Controllers;

use App\Models\Question;

class QuestionController extends Controller
{
    public function show(Question $question)
    {
        $question->load('answers', 'category', 'user');

        return view('questions.show', [
            'question' => $question,
        ]);
    }
    public function destroy(Question $question)
    {
        // Aquí podrías agregar lógica para verificar permisos, etc.
        $question->delete();

        return redirect()->route('home');
    }
}
