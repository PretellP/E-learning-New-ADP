<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{
    Importable,
    SkipsErrors,
    SkipsFailures,
    SkipsOnError,
    SkipsOnFailure,
    ToCollection,
    WithHeadingRow,
    WithValidation
};

class ParticipantsAreaImport implements
ToCollection,
WithHeadingRow,
SkipsOnError,
WithValidation,
SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    private $dnis;
    private $duplicated_dnis = [];

    public function collection(Collection $rows)
    {
        $this->dnis = $rows->collect()->all();
    }

    public function rules(): array
    {
        return [
            '*.dni' => ['required','exists:users,dni', 'digits_between:8,11'],
            '*.area' => ['required'],
            '*.observacion' => ['required']
        ];
    }

    public function getDnis()
    {
        return $this->dnis;
    }

    public function getDuplicatedDnis()
    {
        return collect(array_unique($this->duplicated_dnis));
    }
}
