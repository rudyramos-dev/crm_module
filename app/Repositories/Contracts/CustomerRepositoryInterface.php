<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Customer;
use Illuminate\Support\Collection;

interface CustomerRepositoryInterface
{
    public function all(array $filters = []): Collection;

    public function find(int $id): Customer;

    public function create(array $data): Customer;

    public function update(int $id, array $data): Customer;

    public function delete(int $id): bool;

    public function getWithDealsCount(): Collection;
}
