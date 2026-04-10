<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'deal_id' => 'nullable|exists:deals,id',
            'type' => 'required|in:call,email,meeting,note',
            'description' => 'required|string',
            'scheduled_at' => 'nullable|date',
            'user_id' => 'nullable|exists:users,id',
        ];
    }
}
