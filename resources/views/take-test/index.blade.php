@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Test List') }}</div>

                <div class="card-body">
                    @include('includes/message')

                    @if($test->isNotEmpty())
                        <ul>
                            @foreach($test as $row)
                                <li>
                                    <p>
                                        {{ $row->name }}
                                    </p>
                                    <div>
                                        <p>
                                            <!-- Result: XX -->
                                            <!-- <br> -->
                                            Status: <strong>{{ $row->submitted_date == '' ? 'Not yet taken' : 'Taken' }}</strong>
                                            <br>
                                            Date Started: {{ $row->start_date == '' ? '--' : $row->start_date }}
                                            <br>
                                            Date Submitted/Finish: {{ $row->submitted_date == '' ? '--' : $row->submitted_date }}
                                        </p>
                                    </div>
                                    @if($row->submitted_date == NULL)
                                        <p>
                                            <a href="{{ route('takeTestShow', $row->test_id) }}">Take Test Now</a>
                                        </p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>
                            No test available yet.
                        </p>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
