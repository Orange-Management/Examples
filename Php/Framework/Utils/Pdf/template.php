<?php
require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

/**
 * {@inheritdoc}
 */
class DefaultPdfTemplate extends \phpOMS\Utils\Pdf\Pdf
{
    /**
     * {@inheritdoc}
     */
    public function Header()
    {
        $headerdata = $this->getHeaderData();
        $headerfont = $this->getHeaderFont();

        $this->y = 5;
        $this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
        $this->SetX($this->original_lMargin);
        $this->Cell(0, 0, $headerdata['title'], 0, 1, '', 0, '', 0);
        $this->SetFont('helvetica', '', 8);
        $this->Cell(0, 0, $headerdata['string'], 0, 1, '', 0, '', 0);
        $this->Image($headerdata['logo'], 0, 5, 30, '', 'PNG', false, 'T', false, 300, 'R');
        $this->y = 15;
        $this->Line($this->lMargin, $this->y, $this->w - $this->rMargin, $this->y);
    }

    /**
     * {@inheritdoc}
     */
    public function Footer()
    {
        $cur_y = $this->y;
        $this->SetTextColorArray($this->footer_text_color);
        //set style for cell border
        $line_width = (0.85 / $this->k);
        $this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0,
                                  'color' => $this->footer_line_color));

        $w_page = isset($this->l['w_page']) ? $this->l['w_page'] . ' ' : '';
        if(empty($this->pagegroups)) {
            $pagenumtxt = $w_page . $this->getAliasNumPage() . ' / ' . $this->getAliasNbPages();
        } else {
            $pagenumtxt = $w_page . $this->getPageNumGroupAlias() . ' / ' . $this->getPageGroupAlias();
        }
        $this->SetY($cur_y);
        //Print page number
        if($this->getRTL()) {
            $this->SetX($this->original_rMargin);
            $this->Cell(0, 0, $pagenumtxt, 'T', 0, 'L');
        } else {
            $this->SetX($this->original_lMargin);
            $this->Cell(0, 0, $this->getAliasRightShift() . $pagenumtxt, 'T', 0, 'R');
            $this->SetY($cur_y);
            $this->SetX($this->original_lMargin);
            $this->Cell(0, 0, (new \DateTime())->format('Y-m-d'), 'T', 0, 'L');
        }
    }
}

$pdf = new DefaultPdfTemplate('P', 'mm', 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator('OMS');
$pdf->SetAuthor('Dennis Eichhorn');
$pdf->SetTitle('AreaManager Report');
$pdf->SetSubject('Area: ');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(__DIR__ . '/logo_sd.png', 0, 'Area Manager Report ', 'by Schütz Dental GmbH');

// set header and footer fonts
$pdf->setHeaderFont(['helvetica', '', 10]);
$pdf->setFooterFont(['helvetica', '', 8]);

// set default monospaced font
$pdf->SetDefaultMonospacedFont('courier');

// set margins
$pdf->SetMargins(15, 10, 15);
$pdf->SetHeaderMargin(20);
$pdf->SetFooterMargin(10);

// set auto page breaks
$pdf->SetAutoPageBreak(true, 25);

// set image scale factor
$pdf->setImageScale(1.0);

// ---------------------------------------------------------

// add a page
$pdf->AddPage();
$pdf->setY(20);

// -----------------------------------------------------------------------------

$pdf->SetFont('helvetica', '', 8);

$pdf->writeHTML($html, true, false, false, false, '');

echo $pdf->Output('AreaManagerReport.pdf', 'I');
