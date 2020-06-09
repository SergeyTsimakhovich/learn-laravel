<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;

class Answer extends Model
{
    use Traits\VotableTrait;

    protected $fillable = ['body', 'user_id', 'votes_count'];

    protected $appends = [
        'created_date',
        'body_html',
        'is_best',
        'status'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($answer) {
            $answer->question->increment('answers_count');
        });

        static::deleted(function ($answer) {
            $answer->question->decrement('answers_count');
        });
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = $value;
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getBodyHtmlAttribute()
    {
        return $this->bodyHtml();
    }

    public function getStatusAttribute()
    {
        return $this->id === $this->question->best_answer_id ? 'vote-accepted' : '';
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function isBest()
    {
        return $this->id === $this->question->best_answer_id;
    }

    protected function bodyHtml()
    {
        $markdown = new CommonMarkConverter(['allow_unsafe_links' => false]);
        return clean($markdown->convertToHtml($this->body));
    }

    
}
