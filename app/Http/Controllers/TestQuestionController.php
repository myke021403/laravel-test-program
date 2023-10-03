<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TestQuestion;
use App\Models\TestQuestionAnswer;

class TestQuestionController extends Controller
{
    public $params = [];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($testId)
    {
        $this->params['testId'] = $testId;

        // dd($this->params);

        return view('test-question.create', $this->params);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $testId)
    {
        $validated = $request->validate([
            'question' => 'required',
            'type' => 'required',
            'correct_answer' => 'required_if:type,multiple_choice',
            'answer' => 'required_if:type,multiple_choice'
        ]);

        // save test question
        $saveQuestion = new TestQuestion;
        $saveQuestion->test_id = $testId;
        $saveQuestion->type = $request->type;
        $saveQuestion->question = $request->question;
        $saveQuestion->save();

        if($request->type == 'multiple_choice'){
            foreach($request->answer as $key => $value){
                $correctAnswer = intval($request->correct_answer[0]) - 1;
              
                $saveAnswer = new TestQuestionAnswer;
                $saveAnswer->test_question_id = $saveQuestion->id;

                if($key == $correctAnswer){
                    $saveAnswer->correct_answer = 1;
                } else {
                    $saveAnswer->correct_answer = 0;
                }

                $saveAnswer->answers = $value;
                $saveAnswer->save();
            }
        }

        return redirect(route('testShow', $testId))->with('status', 'Test question has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
