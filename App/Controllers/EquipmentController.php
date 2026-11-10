<?php

namespace App\Controllers;

use App\Models\Box;
use App\Models\Equipment;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class EquipmentController extends BaseController
{
    public function index(Request $request): Response
    {
        return $this->html([
            'equipment' => Equipment::getAll()
        ]);
    }

    public function create(Request $request): Response
    {
        return $this->html([
            'equipment' => null,
            'boxes' => Box::getAll()
        ], 'form');
    }

    public function edit(Request $request): Response
    {
        $id = $_GET['id'] ?? null;
        return $this->html([
            'equipment' => Equipment::getOne($id),
            'boxes' => Box::getAll()
        ], 'form');
    }

    public function store(Request $request): Response
    {
        $id = $_POST['id'] ?? null;
        $equipment = ($id) ? Equipment::getOne($id) : new Equipment();

        $equipment->setSerialNumber($_POST['serial_number'] ?? '');
        $equipment->setName($_POST['name'] ?? '');
        $equipment->setCategory($_POST['category'] ?? '');
        $equipment->setStatus($_POST['status'] ?? '');

        $box_id = $_POST['box_id'] ?? '';
        $equipment->setBoxId($box_id === '' ? null : (int)$box_id);

        $equipment->save();
        return $this->redirect('?c=equipment');
    }

    public function delete(Request $request): Response
    {
        $id = $_GET['id'] ?? null;
        $equipment = Equipment::getOne($id);

        if ($equipment) {
            $equipment->delete();
        }

        return $this->redirect('?c=equipment');
    }
}