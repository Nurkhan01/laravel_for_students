<?php
namespace App\Http\Controllers\Category;

use App\Services\Category\CategoryService;

class BaseController extends \App\Http\Controllers\Controller
{
    protected $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }
}
