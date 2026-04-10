<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class CustomerRepository implements CustomerRepositoryInterface
{
    public function all(array $filters = []): Collection
    {
        $query = Customer::query();

        if (isset($filters['search']) && is_string($filters['search']) && $filters['search'] !== '') {
            $search = $filters['search'];

            $query->where(static function (Builder $builder) use ($search): void {
                $builder
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%");
            });
        }

        return $query->get();
    }

    public function find(int $id): Customer
    {
        return Customer::query()->findOrFail($id);
    }

    public function create(array $data): Customer
    {
        return Customer::query()->create($data);
    }

    public function update(int $id, array $data): Customer
    {
        $customer = $this->find($id);
        $customer->update($data);

        return $customer->refresh();
    }

    public function delete(int $id): bool
    {
        $customer = $this->find($id);

        return (bool) $customer->delete();
    }

    public function getWithDealsCount(): Collection
    {
        return Customer::query()
            ->withCount('deals')
            ->orderByDesc('deals_count')
            ->get();
    }
}
