@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $test->name }}</div>

                <div class="card-body">
                    @include('includes/message')
                    
                    <p>
                        <a href="{{ route('testQuestionCreate', $test->id) }}" class="btn btn-primary">Add Question</a>
                    </p>

                    <p>
                        Name: {{ $test->name }}
                    </p>                    
                    <p>
                        Type: {{ $test->type }}
                    </p>

                    <div>
                        @if(!empty($questions))
                            <table class="table">
                                @foreach($questions as $row)
                                    <tr>
                                        <td>{{ $row['id'] }}</td>
                                        <td>
                                            {{ $row['type'] }}
                                        </td>
                                        <td>
                                            <div>
                                                <p>
                                                    Question: {{ $row['question'] }}
                                                </p>
                                            </div>
                                            @if(!empty($row['answer']))
                                                <div>
                                                    Choices:
                                                    <ul>
                                                        @foreach($row['answer'] as $ans)
                                                            <li>
                                                                {{ $ans['answer'] }} {{ $ans['correct'] ? ' - Correct Answer' : '' }}
                                                            </li>
                                                        @endforeach                                                   
                                                    </ul>
                                                    <ul>
                                                        
                                                    </ul>
                                                </div>
                                            @else
                                                <p>
                                                    No choices.
                                                </p>
                                            @endif
                                            
                                        </td>
                                        <td>
                                            <a href="">DELETE</a>
                                        </td>
                                    </tr>

                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
