<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserImportTemplate implements FromView, ShouldAutoSize
{
    use Exportable;

    public function view(): View
    {
        return view('admin.users.exports._import_template');
    }
}
