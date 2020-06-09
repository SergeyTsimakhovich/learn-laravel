<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\CommonMarkConverter;

class Question extends Model
{
    use Traits\VotableTrait;

    protected $fillable = ['title', 'body'];

    protected $appends = [
        'created_date',
        'is_favorited',
        'favorites_count',
        'body_html',
        'status',
        'excerpt'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('votes_count', 'desc');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites');//, 'question_id', 'user_id');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = $value;
    }

    public function getUrlAttribute()
    {
        return route('questions.show', $this->id . "-" . $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return "answered_accepted";
            }
            return "answered";
        }

        return "unanswered";
    }

    public function acceptBestAnswer($answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function isFavorited()
    {
        if (Auth::check()) {
            return $this->favorites->contains('id', auth('api')->id()) ? 'favorited' : '';
        }
        return '';
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getBodyHtmlAttribute()
    {
        return $this->bodyHtml();
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    protected function excerpt($limit)
    {
        return Str::limit(strip_tags($this->bodyHtml()), $limit, '...');
    }

    protected function bodyHtml()
    {
        $markdown = new CommonMarkConverter(['allow_unsafe_links' => false]);
        return clean($markdown->convertToHtml($this->body));
    }
    
}
