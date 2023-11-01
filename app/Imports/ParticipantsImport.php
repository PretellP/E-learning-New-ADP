<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class ParticipantsImport implements
    ToCollection,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    private $dnis;
    private $dnis_duplicates = [];

    public function collection(Collection $rows)
    {
        $this->dnis = $rows->pluck('dni')->all();
        $this->dnis_duplicates = array_diff_assoc($this->dnis, array_unique($this->dnis));
    }

    public function rules(): array
    {
        return [
            'dni' => ['required','exists:users,dni', 'digits_between:8,11'],
        ];
    }

    public function getDnis()
    {
        return $this->dnis;
    }

    public function getDuplicatedDnis()
    {
        return collect(array_unique($this->dnis_duplicates));
    }
}
