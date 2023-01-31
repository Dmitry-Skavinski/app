<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Progress extends Model
{
    protected $fillable = [ 'data' ];

    protected $casts = [ 'data' => 'array'];

    protected $hidden = [ 'user', 'nonogram' ];

    public function nonogram()
    {
        return $this->belongsTo(Nonogram::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
