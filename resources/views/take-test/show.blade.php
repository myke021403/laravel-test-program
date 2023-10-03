@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Test List') }}</div>

                <div class="card-body">
                    @include('includes/message')

                    @if($minutes < 0)
                        <p>
                            Your time is up! Sorry. Hope you submitted on time.
                        </p>
                    @else
                        @if(!empty($questions))
                            <div id="demo"></div>
                            @if($test->type == 'advanced')
                                <form action="{{ route('takeTestStoreAdvanced', $testId) }}" method="POST">
                            @else
                                <form action="{{ route('takeTestStore', $testId) }}" method="POST">
                            @endif
                                @csrf
                                <ol>
                                    @foreach($questions as $row)
                                        <li>
                                            <p>
                                                {{ $row['question'] }}
                                            </p>
                                            @if($test->type == 'advanced')
                                                <div class="mb-3">
                                                    <label for="exampleFormControlTextarea1" class="form-label">Answer here</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="answer_{{ $row['id'] }}[]"></textarea>
                                                </div>
                                            @else
                                                @foreach($row['answer'] as $ans)
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-text ">
                                                            <input class="form-check-input mt-0" type="radio" value="question_{{ $row['id'] }}_{{ $ans['id'] }}" aria-label="Radio button for following text input" name="choices_{{ $row['id'] }}[]" required>
                                                        </div>
                                                        <span class="input-group-text" id="basic-addon2">{{ $ans['answer'] }}</span>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                                <input type="submit" name="submit" class="btn btn-primary">
                            </form>
                        @else
                            <p>
                                No questions available.
                            </p>
                        @endif
                    @endif

                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var afterSomeMinutes = new Date(new Date().getTime() + {{ $minutes }} * 60000);
    // console.log(afterSomeMinutes);
    // Set the date we're counting down to
    var countDownDate = new Date(afterSomeMinutes).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

      // Get today's date and time
      var now = new Date().getTime();


      // Find the distance between now and the count down date
      var distance = countDownDate - now;
        
      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
      // Output the result in an element with id="demo"
      // document.getElementById("demo").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
      document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";
        
      // If the count down is over, write some text 
      if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "TIMES UP!";
      }
    }, 1000);
    </script>
@endsection
