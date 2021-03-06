<?php

namespace App\Http\Controllers\Backend;

use App\Models\Quiz;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Services\Quiz as SaveQuizOption;
use App\Models\Department;
use App\Models\UserAttemptQuiz;
use App\Models\UserQuestionAnswer;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function __construct(
        Quiz $quiz,
        Option $option,
        Question $question
    ){
        $this->quiz = $quiz;
        $this->option = $option;
        $this->question = $question;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::get();
        $quizs = $this->quiz;
        if(Auth::user()->hasRole('Super Admin')){
            $quizs = $quizs->all();
        }else{
            $quizs = $quizs->where('department_id',Auth::user()->department_id)->get();
        }
        return view('backend.quiz.index', ['quizs' => $quizs,'departments'=>$departments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $quizs = $this->quiz->all();

        return view('backend.quiz.create', ['quizs' => $quizs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'quiz_date' => 'required'
        ]);
        if(!Auth::user()->hasRole('Super Admin')){
            $request->department = Auth::user()->department_id;
        }
        $slug = $this->makeSlug($request->name);
        $quiz = new $this->quiz;
        $user_id = Auth::user()->id;
        $quiz->name = $request->name;
        $quiz->quiz_date = $request->quiz_date;
        $quiz->department_id = $request->department;
        $quiz->user_id = $user_id;
        $quiz->slug = $slug;
        $quiz->save();
        
        return redirect()->action([QuizController::Class, 'index']);
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
    public function edit($slug, Request $request)
    {

        $type = $request->type;
        
        $quiz = $this->quiz->where('slug', $slug)->firstOrFail();
        
        $questions = $this->question->with('options')
                                ->where('quiz_id', $quiz->id)->get();

        return view('backend.quiz.edit', [
                                        'quiz' => $quiz,
                                        'questions' => $questions,
                                        'type' => $type
                                    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($slug, Request $request)
    {
        // DB::transaction(function() use ($slug, $request) {
            
            $this->validate($request, [
                    'question' => 'required',
                    'options.*' => 'required'
                ]);
            
            $type = $request->type;
            
            $quiz = $this->quiz->where('slug', $slug)->firstOrFail();

            //update question to db
            $question = new Question;
            $question->quiz_id  = $quiz->id;
            $question->question = $request->question;
            $question->type = $request->type;
            $question->is_active = 1;
            $question->save();

            $saveOption = (new SaveQuizOption)->saveOptions($request, $question, $type);
            
        // });
        if($request->submit == "add_new"){
            return redirect()->back();
        }
        return redirect()->route('quiz.edit', $slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        DB::transaction(function() use ($request){
            $quiz = $this->quiz->with('questions.options')->where('id', $request->id);
            $quiz->delete();
        });

        return redirect()->route('quiz.index')->with('success', 'Record deleted successfully.');
    }

    /** make slug from title */
    public function makeSlug($name)
    {

        $slug = Str::slug($name);

        $count = Quiz::where('slug', 'LIKE', '%'. $slug . '%')->count();

        $addCount = $count + 1;

        return $count ? "{$slug}-{$addCount}" : $slug;
    }

    public function report(Request $request,$slug)
    {
        $quiz = $this->quiz->with('userAttemptQuiz')->where('slug', $slug)->firstOrFail();
        $quiz_id = $quiz->id;
        return view('backend.quiz.report', ['quiz' => $quiz]);
    }

    public function reportUser(Request $request,$slug,$id)
    {
        $quiz = $this->quiz->where('slug', $slug)->firstOrFail();
        $questionAnswers = UserQuestionAnswer::where('user_id',$id)->where('quiz_id',$quiz->id)->with('questions.options')
                                    ->paginate(15);
        return view('backend.quiz.user-report', ['questionAnswers' => $questionAnswers,'slug'=>$slug]);
    }
}
