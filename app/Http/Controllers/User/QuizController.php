<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
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
        $quizs = $quizs->where('department_id',Auth::user()->department_id)->whereDate('created_at', Carbon::today())->withCount('questions')->get();
        return view('user.quiz.index', ['quizs' => $quizs]);        
    }

    public function view(Request $request, $slug)
    {
        $quiz = $this->quiz->with('questions.options')->where('slug', $slug)->firstOrFail();
        return view('user.quiz.view', ['quiz' => $quiz]);        
    }

}
