<?php

namespace App\Models;

use Framework\Core\Model;

class Equipment extends Model
{
    protected int $id;
    protected string $serial_number;
    protected string $name;
    protected string $category;
    protected ?int $box_id = null;
    protected string $status;

    public function getId(): int { return $this->id; }
    
    public function getSerialNumber(): string { return $this->serial_number; }
    public function setSerialNumber(string $serial_number): void { $this->serial_number = $serial_number; }

    public function getName(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }

    public function getCategory(): string { return $this->category; }
    public function setCategory(string $category): void { $this->category = $category; }

    public function getBoxId(): ?int { return $this->box_id; }
    public function setBoxId(?int $box_id): void { $this->box_id = $box_id; }

    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): void { $this->status = $status; }

    public function getBoxObj(): ?Box {
        return $this->box_id ? Box::getOne($this->box_id) : null;
    }
}