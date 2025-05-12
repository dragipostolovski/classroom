@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="display-4">{{ $quiz->title }}</h1>
        </div>
        <div class="col-auto">
            <div id="timer" class="h4">Time Remaining: <span id="time">00:00</span></div>
        </div>
    </div>

    <form id="quizForm" action="" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                @if($questions->count() > 0)
                    <div class="list-group">
                        @foreach($questions as $index => $question)
                            <div class="list-group-item">
                                <h5 class="mb-3">{{ $index + 1 }}. {{ $question->title }}</h5>
                                
                                <div class="answers-container ml-4">
                                    @if($question->multiple_answers)
                                        @foreach($question->answers as $answer)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" 
                                                    name="answers[{{ $question->id }}][]" 
                                                    value="{{ $answer->id }}" 
                                                    id="answer-{{ $answer->id }}">
                                                <label class="form-check-label" for="answer-{{ $answer->id }}">
                                                    {{ $answer }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach(json_decode($question->options) as $answer)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" 
                                                    name="answers[{{ $question->id }}]" 
                                                    value="{{ $answer }}" 
                                                    id="answer-{{ $answer }}">
                                                <label class="form-check-label" for="answer-{{ $answer }}">
                                                    {{ $answer }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Finish Quiz</button>
                    </div>
                @else
                    <div class="text-center text-muted">
                        <p>No questions available.</p>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>

@endsection