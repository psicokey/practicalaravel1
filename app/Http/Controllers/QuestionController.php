<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $request->validate ([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $question = Question::create([
            'user_id' => 20,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('question.show', $question);
    }

    public function show(Question $question)
    {
        $userId = 20;

        $question->load([
            'user',
            'category',
            'answers' => fn ($query) => $query->with([
                'user',
                'hearts'=> fn ($query)=> $query->where('user_id', $userId),
                'comments' => fn ($query) => $query->with([
                    'user',
                    'hearts' => fn ($query) => $query->where('user_id', $userId),
                ]),

            ]),
            'comments' => fn ($query) => $query->with([
                'user',
                'hearts' => fn ($query) => $query->where('user_id', $userId),
            ]),
            'hearts' => fn ($query) => $query->where('user_id', $userId),
        ]);

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
