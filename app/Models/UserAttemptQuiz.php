<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAttemptQuiz extends Model
{
    
    use \Awobaz\Compoships\Compoships;

    use HasFactory;

    protected $with=['user'];

    public function user()
    {
        return $this->belongsTo(User::Class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::Class);
    }

    public function userQuestionAnswer()
    {
        return $this->hasMany(UserQuestionAnswer::Class,['quiz_id', 'user_id'], ['quiz_id', 'user_id']);
    }

}
