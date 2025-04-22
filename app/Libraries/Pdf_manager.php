<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// La ruta debe apuntar a la carpeta src dentro de la carpeta FPDI
require_once APPPATH . 'ThirdParty/FPDI/autoload.php';

use setasign\Fpdi\Tcpdf\Fpdi;

class Pdf_manager {
    protected $pdf;

    public function __construct() {
        $this->pdf = new Fpdi();
    }
    
    public function useTemplate($filePath, $pageNumber = 1)
    {
       $pageCount = $this->pdf->setSourceFile($filePath);
       if ($pageNumber > $pageCount || $pageNumber < 1)
        {
            $pageNumber = 1;
        }

        $tplIdx = $this->pdf->importPage($pageNumber);
        $s = $this->pdf->getUseImportedPage($tplIdx);
        $this->pdf->useImportedPage($tplIdx, 0, 0, $s['width'], $s['height']);
        return $this->pdf;
    }
    
    public function getPdf() {
       return $this->pdf;
    }

    public function output($name = 'output.pdf', $dest = 'I') {
        $this->pdf->Output($name, $dest);
    }
}