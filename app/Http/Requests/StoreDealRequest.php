<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreDealRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'expected_close_date' => 'nullable|date|after_or_equal:today',
            'status' => 'nullable|in:active,won,lost',
            'pipeline_stage_id' => 'nullable|exists:pipeline_stages,id',
        ];
    }
}
