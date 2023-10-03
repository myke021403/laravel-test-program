<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Auth;

use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestQuestionAnswer;
use App\Models\UserTest;
use App\Models\UserTestAnswer;

class TestController extends Controller
{
    public $params = [];

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            if(Auth::user()->user_type == 'users'){
                return redirect('dashboard');
            }
            
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo Auth::user()->user_type;
        $this->params['test'] = Test::all();

        return view('test.index', $this->params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('test.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:tests|max:255',
            'type' => 'required',
            'time_limit' => 'required'
        ]);

        $save = new Test;
        $save->name = $request->name;
        $save->type = $request->type;
        $save->time_in_minutes = $request->time_limit;
        $save->save();

        return redirect(route('testIndex'))->with('status', 'Test has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $testQuestions = [];

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

        $this->params['questions'] = $testQuestions;

        return view('test.show', $this->params);
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
        $getTestQuestions = TestQuestion::where('test_id', $id)->get();
        if($getTestQuestions->isNotEmpty()){
            foreach($getTestQuestions as $testQuestion){
                $getTestQuestionAnswers = TestQuestionAnswer::where('test_question_id', $id)->delete();
            }

        }

        $getTestQuestions = TestQuestion::where('test_id', $id)->delete();
        $getUserTests = UserTest::where('test_id', $id)->delete();
        $getUserTestAnswer = UserTestAnswer::where('test_id', $id)->delete();

        $getTest = Test::find($id);
        $getTest->delete();

        return redirect(route('testIndex'))->with('status', 'Test has been deleted.');
    }
}
