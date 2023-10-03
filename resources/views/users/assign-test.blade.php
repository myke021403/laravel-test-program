@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Assign Test') }}</div>

                <div class="card-body">
                    @include('includes/message')


                    <p>
                        <a href="{{ route('userShow', $id) }}" class="btn btn-primary">Back</a>
                    </p>

                    @if($test->isNotEmpty())
                        <table class="table">
                            @foreach($test as $row)
                                <tr>
                                    <td>{{ $row->test_id }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->type }}</td>
                                    <td>
                                        <a href="{{ route('userAssignTestSubmit', ['id' => $id, 'testId' => $row->test_id]) }}" class="btn btn-primary">Assign Test</a>
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
@endsection
