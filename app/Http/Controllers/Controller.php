<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @var \Illuminate\Foundation\Auth\Access\AuthorizesRequests
     * Ini adalah "trait" yang memberikan method ->authorize()
     */
    use AuthorizesRequests, ValidatesRequests;
}