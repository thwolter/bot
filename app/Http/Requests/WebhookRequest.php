<?php

namespace App\Http\Requests;

use App\Rules\isWebhookJob;
use Illuminate\Foundation\Http\FormRequest;

class WebhookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'job' => ['required', 'string', new isWebhookJob()],
        ];
    }
}
