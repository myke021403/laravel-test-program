<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;

use App\Models\Test;
use App\Models\UserTest;
use App\Models\TestQuestion;
use App\Models\TestQuestionAnswer;
use App\Models\UserTestAnswer;

class TakeTestController extends Controller
{
    public $params = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $test = [];

        $getTest = DB::table('user_tests')
            ->select(
                'tests.id as test_id',
                'tests.name',
                'tests.type' ,
                'user_tests.test_score',
                'user_tests.start_date',
                'user_tests.submitted_date'
            )
            ->join('tests', 'tests.id', '=', 'user_tests.test_id')
            ->where('user_tests.user_id', Auth::id())
            ->get();

        // dd($getTest);

        $this->params['test'] = $getTest;
     
        return view('take-test.index', $this->params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $testId)
    {
        $totalQuestions = 0;
        $userCorrectAnswer = 0;

        $validated = $request->validate([
            'choices_*' => 'required',
        ]);



        foreach($request->all() as $key => $value){
            if(str_contains($key,'choices')){
                $correctAnswer = false;

                $valueExplode = explode('_', $value[0]);

                $questionId = $valueExplode[1];
                $answerId = $valueExplode[2];

                // check if the answer is correct.
                $getAnswer = TestQuestionAnswer::where('id', $answerId)->where('test_question_id', $questionId)->where('correct_answer', 1)->first();
                if($getAnswer){
                    $correctAnswer = true;
                    $userCorrectAnswer++;
                }

                $saveAnswers = new UserTestAnswer;
                $saveAnswers->user_id = Auth::id();
                $saveAnswers->test_id = $testId;
                $saveAnswers->test_question_id = $questionId;
                $saveAnswers->test_question_answer_id = $answerId;
                $saveAnswers->correct_answer = $correctAnswer;
                $saveAnswers->save();

                $totalQuestions++;
            }
        }

        $averageScore = ( $userCorrectAnswer / $totalQuestions ) * 100;

        // get the user test id first.
        $getUserTest = UserTest::where('test_id', $testId)->where('user_id', Auth::id())->first();

        if($getUserTest){
            $updateUserTest = UserTest::find($getUserTest->id);
            $updateUserTest->test_score = $averageScore;
            $updateUserTest->submitted_date = date('Y-m-d H:i:s', time());
            $updateUserTest->save();
        }

        return redirect(route('takeTestIndex'))->with('status', 'You test has been successfully submitted.');
        
    }

    public function storeAdvanced(Request $request, $testId)
    {
        $validated = $request->validate([
            'answer_*' => '',
        ]);

        // print_r($request->all());

        foreach($request->all() as $key => $value){
            if(str_contains($key,'answer')){
                // $correctAnswer = false;

                $valueExplode = explode('_', $key);

                $questionId = $valueExplode[1];

                // print_r($valueExplode);
                // die();

                
                // $answerId = $valueExplode[2];

                // check if the answer is correct.
                // $getAnswer = TestQuestionAnswer::where('id', $answerId)->where('test_question_id', $questionId)->where('correct_answer', 1)->first();
                // if($getAnswer){
                //     $correctAnswer = true;
                //     $userCorrectAnswer++;
                // }

                $saveAnswers = new UserTestAnswer;
                $saveAnswers->user_id = Auth::id();
                $saveAnswers->test_id = $testId;
                $saveAnswers->test_question_id = $questionId;
                $saveAnswers->answer = $value[0];
                $saveAnswers->save();

                // $totalQuestions++;
            }
        }

        // $averageScore = ( $userCorrectAnswer / $totalQuestions ) * 100;

        // get the user test id first.
        $getUserTest = UserTest::where('test_id', $testId)->where('user_id', Auth::id())->first();

        if($getUserTest){
            $updateUserTest = UserTest::find($getUserTest->id);
            // $updateUserTest->test_score = $averageScore;
            $updateUserTest->submitted_date = date('Y-m-d H:i:s', time());
            $updateUserTest->save();
        }

        return redirect(route('takeTestIndex'))->with('status', 'You test has been successfully submitted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get all the questions
        $testQuestions = [];
        $startDate = '';

        $this->params['test'] = Test::where('id', $id)->first();
        // $getTestQuestions = DB::table('test_questions')->groupBy('id');

        // dd($getTestQuestions);

        $getQuestions = TestQuestion::where('test_id', $id)->get();

        if($getQuestions->isNotEmpty()){
            foreach($getQuestions as $question){
                $answers = [];

                $getAnswers = TestQuestionAnswer::where('test_question_id', $question->id)->get();
                if($getAnswers->isNotEmpty()){
                    foreach($getAnswers as $answer){
                        $answers[] = [
                            'id' => $answer->id,
                            'correct' => $answer->correct_answer,
                            'answer' => $answer->answers
                        ];
                    }
                    
                }
                $testQuestions[] = [
                    'id' => $question->id,
                    'type' => $question->type,
                    'question' => $question->question,
                    'answer' => $answers
                ];
            }
        }

        // start the time
        $checkifUserAlreadyStarted = UserTest::where('test_id', $id)->first();

        if($checkifUserAlreadyStarted){
            $startDate = date('Y-m-d H:i:s', time());

            $updateUserTest = UserTest::find($checkifUserAlreadyStarted->id);
            $updateUserTest->start_date = $startDate;
            $updateUserTest->save();
        } else {
            $startDate = $checkifUserAlreadyStarted->start_date;            
        }

        $datetime_1 = strtotime($startDate);
        $dateNow = time();
        // $datetime_2 = strtotime($startDate . '+30 minutes');

        // $diff = $datetime_2 - $datetime_1;
        // $minutes = floor($diff / 60);

        $timeLeftInMinutes = $this->getTimeLeft($startDate, $this->params['test']->time_in_minutes);
        // echo $diff;
        // echo $minutes;
        // die();

        
        // $this->params['endDate'] = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($startDate)));
        // $this->params['dateNow'] = date('Y-m-d H:i:s', time());

        // $this->params['seconds'] = $diff;
        $this->params['minutes'] = $timeLeftInMinutes;

        $this->params['questions'] = $testQuestions;
        $this->params['testId'] = $id;

        // print_r($this->params);

        return view('take-test.show', $this->params);

    }

    private function getTimeLeft($startDate, $timeInMinutes)
    {
        $datetime_1 = strtotime($startDate);
        $dateNow = time();
        
        return floor( $timeInMinutes - (($dateNow - $datetime_1) / 60) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
