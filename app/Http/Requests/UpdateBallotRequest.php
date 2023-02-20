<?php

namespace App\Http\Requests;

use App\Models\Candidate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBallotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->ballot);
    }

    protected function prepareForValidation(): UpdateBallotRequest
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
    public function rules(): array
    {
        return [
            'elected' => ['required', 'array'],
            'elected.*' => ['nullable', Rule::exists(Candidate::class, 'id')],
            // 'chosen' => ['required'],
            'candidates' => ['required'],
            'candidates.*.position_id' => ['required', 'distinct'],
        ];
    }
}
