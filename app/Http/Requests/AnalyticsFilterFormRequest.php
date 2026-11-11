<?php

namespace App\Http\Requests;

use App\Data\Analytics\AnalyticsFilterDto;
use App\Enums\AnalyticMetricEnum;
use App\Enums\GranularityEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnalyticsFilterFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'from'        => ['nullable', 'date'],
            'to'          => ['nullable', 'date', 'after:from'],
            'granularity' => ['nullable', Rule::enum(GranularityEnum::class)],
            'timezone'    => ['nullable', 'timezone'],
            'include'     => ['nullable', 'array'],
            'include.*'   => [Rule::enum(AnalyticMetricEnum::class)],
        ];
    }

    public function toDto(): AnalyticsFilterDto
    {
        $validated = array_filter($this->validated(), fn ($value) => $value !== null);

        return AnalyticsFilterDto::from([
            'from' => now()->subDays(30)->startOfDay()->toDateTimeString(),
            'to' => now()->endOfDay()->toDateTimeString(),
            'include' => array_map(fn (AnalyticMetricEnum $enum) => $enum->value, AnalyticMetricEnum::defaults()),
            ...$validated,
        ]);
    }
}
