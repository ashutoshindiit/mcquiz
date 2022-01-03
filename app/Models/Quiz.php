<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Quiz extends Model
{
    protected $table = 'quiz';
    protected $dates = ['quiz_date'];
    protected $fillable = [
        'name',
        'quiz_date',
        'departments_id',
        'user_id'
    ];

    public function questions() {
        return $this->hasMany(Question::Class);
    }

    public function is_attempt(){
        return $this->hasMany(UserAttemptQuiz::Class)->where('user_id',Auth::user()->id);
    }

    public function userAttemptQuiz()
    {
        return $this->hasMany(UserAttemptQuiz::Class);
    }
}