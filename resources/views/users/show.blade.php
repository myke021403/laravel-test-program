@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>

                <div class="card-body">
                    @include('includes/message')
                    
                    <p>
                        <a href="{{ route('userIndex') }}" class="btn btn-default">Back</a>
                    </p>

                    <p>
                        Name: {{ $user->name }}
                    </p>
                    <p>
                        Email: {{ $user->email }}
                    </p>
                    <div class="card">
                        <div class="card-header">
                            List of Test
                        </div>
                        <div class="card-body">
                            <p> 
                                <a href="{{ route('userAssignTest', $user->id) }}" class="btn btn-primary">Assign Test</a>
                            </p>
                            @if($test->isNotEmpty())
                                <table class="table">
                                    @foreach($test as $row)
                                        <tr>
                                            <td>{{ $row->test_id }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->type }}</td>
                                            <td>{{ $row->test_score }}</td>
                                            <td>{{ $row->start_date }}</td>
                                            <td>{{ $row->submitted_date }}</td>

                                            <td>
                                                <a href="">Remove</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                <p>
                                    No test has been added.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
