<?php

namespace App\Imports;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements 
    ToModel,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    private $dnis = [];
    private $duplicated_dnis = [];

    public function model(array $row)
    {
        try {
            if (in_array($row['dni'], $this->duplicated_dnis)) {
                return null;
            }

            $data = collect([
                'dni' => $row['dni'],
                'password' => Hash::make($row['dni']),
                'name' => $row['nombre'],
                'paternal' => $row['paterno'],
                'maternal' => $row['materno'],
                'company_id' => $row['cod_empresa'],
                'position' => $row['cargo'],
                'email' => $row['email'],
                'telephone' => $row['telefono'],
                'role' => 'participants'
            ]);

            $user = User::where('dni', $data['dni'])->first();

            if ($user) {
                $user->update($data->except('dni')->all());
            } else {
                $user = User::create($data->all());
            }

            // $user->miningUnits()->sync($row['unidad_minera']);

            return $user;

        } catch (Exception $e) {
            $this->onError($e);
        }

        return null;
    }

    public function rules(): array
    {
        return [
            '*.dni'             => ['required', 'digits_between:8,11', 'distinct'],
            '*.nombre'          => ['required', 'max:255'],
            '*.paterno'         => ['required', 'max:255'],
            '*.materno'         => ['required', 'max:255'],
            '*.email'           => ['required', 'email', 'max:255'],
            '*.telefono'        => ['nullable', 'max:20'],
            '*.cod_empresa'     => ['nullable', 'exists:App\Models\Company,id'],
            '*.cargo'           => ['nullable', 'max:255'],
            // '*.unidad_minera'   => ['filled', 'array'],
            // '*.unidad_minera.*' => ['exists:App\Models\MiningUnit,id'],
        ];
    }

    public function customValidationAttributes()
    {
        return [
            'cod_empresa' => 'cod empresa',
            // 'unidad_minera.*' => 'unidad minera',
        ];
    }

    public function prepareForValidation($row)
    {
        $this->validateDuplicatedDnis($row['dni']);

        // $miningUnits = Str::of($row['unidad_minera'])->explode(',')->all();
        // $row['unidad_minera'] = $miningUnits ?? $row['unidad_minera'];

        return $row;
    }

    public function validateDuplicatedDnis($dni)
    {
        if (in_array($dni, $this->dnis)) {
            $this->duplicated_dnis[] = $dni;
        }

        $this->dnis[] = $dni;
    }

    public function getDuplicatedDnis()
    {
        return collect(array_unique($this->duplicated_dnis));
    }
}
