<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class HomeController extends BaseController
{
    /**
     * Akcia pre úvodnú stránku (Dashboard s placeholderom)
     * URL: ?c=home
     */
    public function index(Request $request): Response
    {
        return $this->html();
    }

    /**
     * Akcia pre netriviálnu stránku (Evidencia techniky)
     * URL: ?c=home&a=technika
     */
    public function technika(Request $request): Response
    {
        return $this->html();
    }
}