@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Question</div>

                <div class="card-body">
                    @include('includes/message')

                    <p>
                        <a href="{{ route('testIndex') }}" class="btn btn-default">Back</a>
                    </p>

                    <form action="{{ route('testQuestionStore', $testId) }}" method="POST">
                        @csrf
                        <div>
                            <label for="question">Question</label>    
                            <textarea id="question" name="question" class="form-control"></textarea>
                        </div>

                        <div>
                            <label for="type">Type</label>    
                            <select class="form-select" name="type" id="type">
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="coding">Coding</option>

                            </select>
                        </div>
                        <div class="input-group">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" value="1" aria-label="Radio button for following text input" name="correct_answer[]">
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with radio button" name="answer[]">
                        </div>
                        <div class="input-group">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" value="2" aria-label="Radio button for following text input" name="correct_answer[]">
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with radio button" name="answer[]">
                        </div>
                        <div class="input-group">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" value="3" aria-label="Radio button for following text input" name="correct_answer[]">
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with radio button" name="answer[]">
                        </div>
                        <div class="input-group">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" value="4" aria-label="Radio button for following text input" name="correct_answer[]">
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with radio button" name="answer[]">
                        </div>
                        
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
