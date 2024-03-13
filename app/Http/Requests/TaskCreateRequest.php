<?php

namespace App\Http\Requests;

use App\PriorityEnum;
use App\StatusEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskCreateRequest extends FormRequest
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
            'subject' => 'required|string|max:250',
            'description' => 'string',
            'start_date' => 'required|date_format:Y-m-d|after_or_equal:' . Carbon::today()->format('Y-m-d'),
            'due_date' => 'required|date_format:Y-m-d|after:start_date',
            'status' => 'string|' . Rule::in([StatusEnum::NEW, StatusEnum::INCOMPLETE, StatusEnum::COMPLETE]),
            'priority' => 'required|string|' . Rule::in([PriorityEnum::HIGH, PriorityEnum::MEDIUM, PriorityEnum::LOW]),
            'notes.*.subject' => 'required|string|max:250',
            'notes.*.attachments.*' => 'file|max:2048',
            'notes.*.note' => 'string',
        ];
    }
}
