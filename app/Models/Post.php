<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'hash',
        'user_id',
        'post_id',
        'title',
        'content',
        'group',
        'reaction',
        'comment',
        'password',
        'time_join',
        'view',
        'unlock',
        'spam',
        'status',
    ];

    const STATUS_DRAFT = 'draft';
    const STATUS_UNPUBLISHED = 'unpublished';
    const STATUS_PUBLISHED = 'published';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
