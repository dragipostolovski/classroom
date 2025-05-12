<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\ClassModel;
use App\Models\Score;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index($classId)
    {
        $class = ClassModel::findOrFail($classId);
        $quizzes = $class->quizzes;
        return view('quizzes.index', compact('class', 'quizzes'));
    }

    public function create($classId)
    {
        $class = ClassModel::findOrFail($classId);
        return view('quizzes.create', compact('class'));
    }

    public function store(Request $request, $classId)
    {
        $class = ClassModel::findOrFail($classId);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $class->quizzes()->create($validated);
        // return redirect()->route('classes.quizzes.index', $classId)->with('success', 'Quiz created successfully!');
        return redirect()->route('classes.show', $classId)->with('success', 'Quiz created successfully!');
    }

    public function edit($classId, $id)
    {
        $class = ClassModel::findOrFail($classId);
        $quiz = $class->quizzes()->findOrFail($id);
        return view('quizzes.edit', compact('class', 'quiz'));
    }

    public function update(Request $request, $classId, $id)
    {
        $class = ClassModel::findOrFail($classId);
        $quiz = $class->quizzes()->findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $quiz->update($validated);
        return redirect()->route('classes.quizzes.index', $classId)->with('success', 'Quiz updated successfully!');
    }

    public function destroy($classId, $id)
    {
        $class = ClassModel::findOrFail($classId);
        $quiz = $class->quizzes()->findOrFail($id);
        $quiz->delete();
        return redirect()->route('classes.quizzes.index', $classId)->with('success', 'Quiz deleted successfully!');
    }

    public function show($classId, $quizId)
    {
        $class = ClassModel::findOrFail($classId);
        $quiz = $class->quizzes()->findOrFail($quizId);
        return view('quizzes.show', compact('class', 'quiz'));
    }

    public function submit(Request $request, $quizId)
    {
        $userId = auth()->id();
        var_dump($request->input('answers'));
        $result = $this->calculateResult($request->input('answers'), $quizId);

        Score::create([
            'quiz_id' => $quizId,
            'user_id' => $userId,
            'result' => $result,
        ]);

        // Assuming you have access to the classId, you need to pass it along with quizId
        $quiz = Quiz::findOrFail($quizId); // Adjust this line based on your actual relationship
        $classId = $quiz->class_id; // Adjust this line based on your actual relationship
        
        return redirect()->route('classes.quizzes.index', $classId)->with('success', 'Quiz deleted successfully!');
    }

    private function calculateResult($answers, $quizId)
    {
        // Retrieve the quiz and its questions
        $quiz = Quiz::findOrFail($quizId);
        $questions = $quiz->questions;
        $score = 0;
        $totalQuestions = count($questions);

        // Compare submitted answers with correct answers
        foreach ($questions as $question) {
            $submittedAnswer = $answers[$question->id] ?? null;
            if ($submittedAnswer && $submittedAnswer == $question->correct_option) {
                $score++;
            }
        }

        // Calculate percentage score
        $percentageScore = $totalQuestions > 0 ? ($score / $totalQuestions) * 100 : 0;
        return $percentageScore;
    }
}