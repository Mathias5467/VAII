<?php

namespace App\Controllers;

use App\Models\Equipment;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class EquipmentController extends BaseController
{
    public function index(Request $request): Response
    {
        // Opravené: Načítame zoznam všetkých záznamov pre tabuľku
        $equipment = Equipment::getAll();

        return $this->html([
            'equipment' => $equipment
        ]);
    }

    public function create(Request $request): Response
    {
        return $this->html([
            'equipment' => null
        ], 'form');
    }

    public function edit(Request $request): Response
    {
        $id = $request->value('id');
        $equipment = Equipment::getOne($id);
        return $this->html(['equipment' => $equipment], 'form');
    }

    public function store(Request $request): Response
    {
        $id = $request->value('id');

        $equipment = ($id) ? Equipment::getOne($id) : new Equipment();

        $equipment->setSerialNumber($request->value('serial_number'));
        $equipment->setName($request->value('name'));
        $equipment->setCategory($request->value('category'));
        $equipment->setBox($request->value('box'));
        $equipment->setStatus($request->value('status'));

        $equipment->save();

        return $this->redirect('?c=equipment');
    }

    public function delete(Request $request): Response
    {
        $id = $request->value('id');
        $equipment = Equipment::getOne($id);

        if ($equipment) {
            $equipment->delete();
        }

        return $this->redirect('?c=equipment');
    }
}