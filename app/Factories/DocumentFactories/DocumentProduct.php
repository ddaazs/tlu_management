<?php

namespace App\Factories\DocumentFactories;

interface DocumentProduct
{
    public function create(array $data): array;
    public function update(array $data): array;
    public function delete(): array;
    public function download(): string;
    public function validate(array $data): array;
    public function getType(): string;
}
