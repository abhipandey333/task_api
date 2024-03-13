<?php

namespace App\Http\Requests;

use App\PriorityEnum;
use App\StatusEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskGetRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'string|' . Rule::in([StatusEnum::NEW, StatusEnum::INCOMPLETE, StatusEnum::COMPLETE]),
            'due_date' => 'date_format:Y-m-d',
            'priority' => 'string|' . Rule::in([PriorityEnum::HIGH, PriorityEnum::MEDIUM, PriorityEnum::LOW]),
            'note' => 'string'
        ];
    }
}
