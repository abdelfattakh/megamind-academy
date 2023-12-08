<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UniqueInternationalPhone implements Rule, DataAwareRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    protected string $table;
    protected int|null $ignore;

    protected string $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $table, int|null $recordIdToIgnore = null)
    {
        $this->table = $table;
        $this->ignore = $recordIdToIgnore;
    }

    /**
     * Set the data under validation.
     *
     * @param array<string, mixed> $data
     * @return UniqueInternationalPhone
     */
    public function setData($data): static
    {
        $this->data = Arr::dot($data);

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!filled($this->data[$attribute . '_country'] ?? '')) {
            return false;
        }
        try {
            $phone = phone($value, $this->data[$attribute . '_country'])->formatE164();
        } catch (\Exception) {
            $this->message = 'Phone Number is Wrong';
            return false;
        }

        $attrName = Arr::last(explode('.', $attribute));
        $this->message = 'Phone Number Exists';
        return DB::table($this->table)
            ->where($attrName . '_e164', $phone)
            ->when(filled($this->ignore), fn ($q) => $q->where('id', '!=', $this->ignore))
            ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message ?? 'Number already exists in our Database';
    }
}
