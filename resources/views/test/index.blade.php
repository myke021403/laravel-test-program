@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Test List') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        <a href="{{ route('testCreate') }}" class="btn btn-primary">Add New Test</a>
                    </p>

                    @if($test->isNotEmpty())
                        <table class="table">
                            @foreach($test as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->time_in_minutes }} Minutes</td>

                                    <td>{{ $row->type }}</td>
                                    <td>
                                        <form action="{{ route('testDelete', $row->id) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                        
                                            <a href="{{ route('testShow', $row->id) }}">View</a>
                                            <input type="submit" name="submit" class="btn btn-danger">
                                        </form>
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
