<?php

namespace App\Enums;

enum PostMediaType: string
{

    use EnumToArray;

    case None = 'none';
    case Photo = 'photo';
    case Video = 'video';
}
