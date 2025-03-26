<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'company_name' => ['required', 'string', 'max:150'],
            'min_salary' => ['required', 'numeric', 'min:0'],
            'max_salary' => ['required', 'numeric', 'min:0', 'gte:min_salary'],
            'is_remote' => ['boolean'],
            'job_type' => ['required', 'in:full-time,part-time,contract,freelance'],
            'status' => ['required', 'in:draft,published,archived'],
            'published_at' => ['nullable', 'date'],
            'location_ids' => ['required', 'array'],
            'location_ids.*' => ['exists:locations,id'],
            'language_ids' => ['required', 'array'],
            'language_ids.*' => ['exists:languages,id'],
            'category_id' => ['required', 'exists:categories,id'],

            // Validate attributes
            'attributes' => ['nullable', 'array'],
            'attributes.*.id' => ['required', 'exists:attributes,id'],
            'attributes.*.value' => ['required'],
        ];
    }
}
