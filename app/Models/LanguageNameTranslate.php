<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageNameTranslate extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
    public function toLanguage()
    {
        return $this->belongsTo(Language::class, 'to_language_id', 'id');
    }
}
