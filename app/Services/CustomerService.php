<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class CustomerService
{
    public function __construct(
        private readonly CustomerRepositoryInterface $repository,
    ) {}

    public function list(Request $request): Collection
    {
        return $this->repository->all([
            'search' => $request->input('search'),
        ]);
    }

    public function store(array $data): Customer
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): Customer
    {
        return $this->repository->update($id, $data);
    }

    public function destroy(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
