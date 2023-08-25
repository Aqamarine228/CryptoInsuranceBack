<?php

namespace App\Models;

use App\Enums\Currency;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Payable
{
    public function getPrice(): float;

    public function getCurrency(): Currency;

    public function getId(): int;

    public function getUserId(): int;

    public function paid(): void;
}
