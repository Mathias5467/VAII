<?php

namespace App\Controllers;

use App\Models\Box;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class BoxController extends BaseController
{
    public function index(Request $request): Response
    {
        return $this->html(['boxes' => Box::getAll()]);
    }

    public function create(Request $request): Response
    {
        return $this->html(['box' => null], 'form');
    }

    public function edit(Request $request): Response
    {
        $id = $_GET['id'] ?? null;
        return $this->html(['box' => Box::getOne($id)], 'form');
    }

    public function store(Request $request): Response
    {
        $id = $_POST['id'] ?? null;
        $box = $id ? Box::getOne($id) : new Box();

        $box->setCode($_POST['code'] ?? '');
        $box->setDescription($_POST['description'] ?? '');
        $box->save();

        return $this->redirect('?c=box');
    }

    public function delete(Request $request): Response
    {
        $id = $_GET['id'] ?? null;
        $box = Box::getOne($id);
        if ($box) $box->delete();

        return $this->redirect('?c=box');
    }
}