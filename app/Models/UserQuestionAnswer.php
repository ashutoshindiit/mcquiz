<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuestionAnswer extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'user_question_answer';
    
    public $timestamps = true;

    public function questions() {
        return $this->belongsTo(Question::Class, 'question_id');
    }

}
