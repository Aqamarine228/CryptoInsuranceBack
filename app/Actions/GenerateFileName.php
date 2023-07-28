<?php

namespace App\Actions;

use Exception;

class GenerateFileName
{
    /**
     * @throws Exception
     */
    public static function execute(string $fileExtension): string
    {
        return date('Y-m-d_H:i:s') . '_' . random_int(1, 9999) . '.' . $fileExtension;
    }
}
