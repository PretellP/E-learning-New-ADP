<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;


class PdfCertificationController extends Controller
{
    public function examPdf(Certification $certification)
    {
        // $certification->load('
        // ');

        $pdf = Pdf::loadView('admin.common.pdf.certification_exam', compact(
            'certification'
        ));

        return $pdf->stream('certificado-'. $certification->id .'.pdf');
    }
}
