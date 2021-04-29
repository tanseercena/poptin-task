<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $appends = ['script'];

    protected $fillable = [
        'alert_text',
        'user_id',
    ];

    public function getScriptAttribute()
    {
        return '&lt;script src="'.config("app.url").'/js/alert-embed.js?id=123"&gt;&lt;/script&gt;';
    }

    public function conditions()
    {
        return $this->hasMany(Condition::class);
    }
}
