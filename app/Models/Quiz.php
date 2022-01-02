<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
