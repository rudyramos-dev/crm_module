<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateDealRequest extends FormRequest
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
            'title' => 'nullable|string|max:255',
            'value' => 'nullable|numeric|min:0',
            'expected_close_date' => 'nullable|date|after_or_equal:today',
            'status' => 'nullable|in:active,won,lost',
            'pipeline_stage_id' => 'nullable|exists:pipeline_stages,id',
        ];
    }
}
