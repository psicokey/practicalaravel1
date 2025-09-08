<?php

namespace App\Models;

use App\Traits\HasHeart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory, HasHeart;

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
    ];
    protected static function booted()
    {
        static::deleting(function ($question) {

            $question->hearts()->delete();

            // Eliminar comentarios asociados
            $question->comments()->get()->each (function ($comment) {
                $comment->hearts()->delete();
                $comment->delete();
            });
            // Eliminar respuestas asociadas
            $question->answers()->get()->each(function ($answer) {
                $answer->hearts()->delete();
                // Eliminar comentarios de cada respuesta
                $answer->comments()->get()->each(function ($comment) {
                    $comment->hearts()->delete();
                    $comment->delete();
                });
            });
        });
    }
}
