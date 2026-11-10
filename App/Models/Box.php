<?php

namespace App\Models;

use Framework\Core\Model;

class Box extends Model
{
    protected int $id;
    protected string $code;
    protected string $description;

    public function getId(): int { return $this->id; }

    public function getCode(): string { return $this->code; }
    public function setCode(string $code): void { $this->code = $code; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }

    /** @return Equipment[] */
    public function getEquipment(): array
    {
        return Equipment::getAll('box_id = ?', [$this->id]);
    }
}