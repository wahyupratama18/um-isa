<?php

namespace App\Http\Requests;

use App\Models\Ballot;
use App\Models\Candidate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBallotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Ballot::class);
    }

    protected function prepareForValidation(): StoreBallotRequest
    {
        $candidates = Candidate::query()->find($this->elected);

        return $this->merge([
            'chosen' => $candidates,
            'candidates' => $candidates->toArray(),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'elected' => ['nullable', 'array'],
            'elected.*' => ['nullable', Rule::exists(Candidate::class, 'id')],
            // 'chosen' => ['required'],
            'candidates' => ['nullable'],
            'candidates.*.position_id' => ['required', 'distinct'],
        ];
    }
}
