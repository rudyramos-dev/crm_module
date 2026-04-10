<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\OrderedScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy([OrderedScope::class])]
final class PipelineStage extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'color',
        'order',
        'is_default',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }
}
