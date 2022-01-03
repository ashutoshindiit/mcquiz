<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Question;
use App\Models\UserQuestionAnswer;
use App\Models\Quiz;
use App\Models\UserAttemptQuiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Quiz as SaveQuizOption;
use App\Http\Services\SaveQuizOption as Services;

class QuizController extends Controller
{
    public function __construct( Quiz $quiz, Option $option, Question $question)
    {
        $this->quiz = $quiz;
        $this->option = $option;
        $this->question = $question;
    }

    public function index()
    {
        $quizs = $this->quiz;
        $quizs = $quizs->withCount('is_attempt')->where('department_id',Auth::user()->department_id)->where('department_id','!=',null)->whereDate('quiz_date',Carbon::today())->withCount('questions')->get();
        return view('user.quiz.index', ['quizs' => $quizs]);        
    }

    public function view(Request $request, $slug)
    {
        $quiz = $this->quiz->withCount('is_attempt')->with('questions.options')->where('slug', $slug)->firstOrFail();
        if($quiz->is_attempt_count !=1){
           return view('user.quiz.view', ['quiz' => $quiz]);  
        }
        else{
             abort(404);
        }    
    }
    
    public function answer(Request $request,$slug)
    {
        $user_id = Auth::user()->id;
        $quiz_id = $this->quiz->where('slug',$slug)->first()->id;
        $requestValues = $request->all();
        $data = [];
        
        foreach($requestValues as $question_id => $answer) {
            if ($question_id == '_token') {
                break;
            }

            //dd(is_numeric($answer));
            //for checkboxes
            if (is_array($answer)) {
                $right_answer = Option::where('question_id', $question_id)
                                        ->where('is_right_option', 1)->pluck('id')->toArray();
                

                if (empty(array_diff($right_answer,$answer))) {
                    $is_right = 1;
                } else {
                    $is_right = 0;
                }

                foreach($answer as $q_id => $ans) {

                    $data[] =[
                        'user_id' => $user_id,
                        'question_id' => (int) $question_id,
                        'option_id' => $ans,
                        'is_right' => $is_right
                    ];
                }
            } else if (is_numeric($answer)) {
                //for radio buttons
                $right_answer = Option::where('question_id', $question_id)
                                        ->where('is_right_option', 1)->first();

                if ($right_answer->id == $answer) {
                     $is_right = 1;
                } else {
                    $is_right = 0;
                }
                
                $data[] = [
                    'user_id' => $user_id,
                    'question_id' => (int)$question_id,
                    'option_id' => (int)$answer,
                    'is_right' => $is_right
                ];
            } else {
                $data[] = [
                    'user_id' => $user_id,
                    'question_id' => (int)$question_id,
                    'option_id' => 0,
                    'is_right' => 0
                ];
            }
        }
        $isSaved = UserQuestionAnswer::insert($data);
        $userAttemp = new UserAttemptQuiz();
        $userAttemp->quiz_id = $quiz_id;
        $userAttemp->user_id = $user_id;
        $userAttemp->save();
        return redirect()->route('user.quiz')->with('success', 'Quiz attempt successfully.');
    }
}
