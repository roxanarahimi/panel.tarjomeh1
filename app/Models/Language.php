<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function translatesTo()
    {
        return $this->hasMany(LanguageNameTranslate::class,  'to_language_id', 'id');
//            ->orderByDesc('id');
    }

    public function translateFrom()
    {
        return $this->hasMany(LanguageNameTranslate::class,  'language_id', 'id');
//            ->orderByDesc('id');
    }

}
