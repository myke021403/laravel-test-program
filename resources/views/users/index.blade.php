@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('User List') }}</div>

                <div class="card-body">
                    @include('includes/message')


                    <p>
                        <a href="{{ route('testCreate') }}" class="btn btn-primary">Add New User</a>
                    </p>

                    @if($users->isNotEmpty())
                        <table class="table">
                            @foreach($users as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->type }}</td>
                                    <td>
                                        <a href="{{ route('userShow', $row->id) }}">View</a>
                                        <a href="">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>
                            No users has been added.
                        </p>
                    @endif

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
