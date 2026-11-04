<?php

namespace App\Http\Requests;

use App\Data\Link\ClickLinkDto;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Jenssegers\Agent\Agent;

class ClickLinkFormRequest extends FormRequest
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
            //
        ];
    }

    public function toDto(): ClickLinkDto
    {
        $agent = new Agent();
        $agent->setUserAgent($this->userAgent());
        
        return ClickLinkDto::from([
            'clickedAt' => Carbon::now(),
            'referrer' => $this->headers->get('referer'),
            'userAgent' => $agent->getUserAgent(),
            'ip' => $this->ip(),
            'country' => null,
            'deviceType' => $agent->deviceType()
        ]);
    }
}
