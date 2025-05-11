<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $questions = $quiz->questions;
        return view('questions.index', compact('quiz', 'questions'));
    }

    public function create($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        return view('questions.create', compact('quiz'));
    }

    public function store(Request $request, $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'options' => 'required|json',
            'correct_option' => 'required|string',
        ]);
        $quiz->questions()->create($validated);
        return redirect()->route('quizzes.questions.index', $quizId)->with('success', 'Question created successfully!');
    }

    public function edit($quizId, $id)
    {
        $quiz = Quiz::findOrFail($quizId);
        $question = $quiz->questions()->findOrFail($id);
        return view('questions.edit', compact('quiz', 'question'));
    }

    public function update(Request $request, $quizId, $id)
    {
        $quiz = Quiz::findOrFail($quizId);
        $question = $quiz->questions()->findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'options' => 'required|json',
            'correct_option' => 'required|string',
        ]);
        $question->update($validated);
        return redirect()->route('quizzes.questions.index', $quizId)->with('success', 'Question updated successfully!');
    }

    public function destroy($quizId, $id)
    {
        $quiz = Quiz::findOrFail($quizId);
        $question = $quiz->questions()->findOrFail($id);
        $question->delete();
        return redirect()->route('quizzes.questions.index', $quizId)->with('success', 'Question deleted successfully!');
    }
}