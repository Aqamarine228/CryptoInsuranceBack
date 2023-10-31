<?php

namespace Modules\Client\Models;

class FAQ extends \App\Models\FAQ
{

    protected array $localizable = [
        'question', 'answer',
    ];
}
