<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Models\User;
use App\Models\Test;
use App\Models\UserTest;

class UserController extends Controller
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
        $this->params['users'] = User::all();

        return view('users.index', $this->params);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->params['user'] = User::where('id', $id)->first();

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
            ->where('user_tests.user_id', $id)
            ->get();

        $this->params['id'] = $id;
        $this->params['test'] = $getTest;
        // dd($this->params);

        return view('users.show', $this->params);
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

    public function assignTest($id)
    {
        $test = [];

        $getTest = DB::table('tests')
            ->select(
                'tests.id as test_id',
                'tests.name',
                'tests.type' ,
                'user_tests.test_score',
                'user_tests.start_date',
                'user_tests.submitted_date'
            )
            ->leftJoin('user_tests', 'tests.id', '=', 'user_tests.test_id')
            ->whereNotNull('tests.id')
            ->get();

        // print_r($getTest);
        // die();

        $this->params['id'] = $id;
        $this->params['test'] = $getTest;

        // dd($getTest);

        return view('users.assign-test', $this->params);

    }

    public function assignTestSubmit($userId, $testId)
    {
        $save = new UserTest;
        $save->user_id = $userId;
        $save->test_id = $testId;
        $save->save();

        return redirect(route('userAssignTest', $userId))->with('status', 'Test has been assigned.');

    }
}
