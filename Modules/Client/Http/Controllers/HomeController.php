<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Modules\Client\Models\InsuranceOption;
use Modules\Client\Models\Post;

class HomeController extends BaseClientController
{

    private const POSTS_PER_PAGE_COUNT = 3;

    private const INSURANCE_OPTIONS_PER_PAGE_COUNT = 8;

    public function __invoke(): Renderable
    {
        return $this->view('home.home', [
            'posts' => $this->getNews(),
            'insuranceOptions' => $this->getInsuranceOptions(),
        ]);
    }

    private function getNews(): Collection
    {
        return Post::published()->latest()->limit(self::POSTS_PER_PAGE_COUNT)->get();
    }

    private function getInsuranceOptions(): Collection
    {
        return InsuranceOption::displayable()->limit(self::INSURANCE_OPTIONS_PER_PAGE_COUNT)->get();
    }
}
