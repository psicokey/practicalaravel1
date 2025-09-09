<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Category;
use App\Models\Question;
use App\Support\QuestionShowLoader;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with(['user', 'category'])
            ->withCount('answers')
            ->latest()
            ->paginate(10);

        return view('questions.index', [
            'questions' => $questions,
        ]);
    }
    public function create()
    {
        $categories = Category::all();
        return view('questions.create', [
            'categories' => $categories,
        ]);
    }
    public function store(StoreQuestionRequest $request)
    {

        $question = Question::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('question.show', $question);
    }
    public function edit(Question $question)
    {
        $categories = Category::all();
        return view('questions.edit', [
            'question' => $question,
            'categories' => $categories,
        ]);
    }

    public function update(UpdateQuestionRequest $question, Request $request)
    {
        $request->validate ([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $question->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('question.show', $question);
    }

    public function show(Question $question, QuestionShowLoader $loader)
    {

        $loader->load($question);
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
