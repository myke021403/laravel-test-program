@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Test List') }}</div>

                <div class="card-body">
                    @include('includes/message')

                    <p>
                        <a href="{{ route('testIndex') }}" class="btn btn-default">Back</a>
                    </p>
                    <form action="{{ route('testStore') }}" method="POST">
                        @csrf
                        <div>
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="">
                        </div>
                        <div>
                            <label for="type">Type</label>    
                            <select class="form-select" name="type" id="type">
                                <option value="logic">Logic</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>
                        <div>
                            <label for="time_limit">Time Limit</label>
                            <input type="text" id="time_limit" name="time_limit" class="form-control" value="">
                        </div>
                        <div>
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
