<?php

namespace Modules\Admin\Models;

class FAQ extends \App\Models\FAQ
{

    protected $fillable = [
      'question_en',
      'question_ru',
      'answer_en',
      'answer_ru',
    ];
}
