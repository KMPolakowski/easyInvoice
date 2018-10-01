<?php

// Include the main TCPDF library (search for installation path).
include('tcpdf/tcpdf.php');


    function generateInvoicePdf($invoice)
    {
        $receiver = $invoice["receiver"];

        $details = $invoice["details"];

        $items = $invoice["items"];

        $info = $invoice["info"];

        $payment = $invoice["payment"];

        $bank = $invoice["bank"];

        $contact = $invoice["contact"];
    
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Janbau');
        $pdf->SetTitle('TCPDF Example 001');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    
        // set default header data
        $pdf->SetHeaderData(
        'https://www.janbau.at/img/FirmenlogoJanbau.jpg',
        60,
        "Janbau e. U.",
    "Jan Polakowski\nThürnlhofstrasse 5/8/827\n1110 Wien\n                                    
	UIDNr.: 21564561321561\n",
        array(0,64,255),
        array(255, 255, 255)
    );
    
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
    
        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
        // set auto page breaks
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
    
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
    
        // ---------------------------------------------------------
    
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);
    
        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);
    
        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();
    
        // set text shadow effect
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
    
        // Set some content to print
        ob_start();
        include(__DIR__.'\invoice.php');
        $html = ob_get_contents();
        ob_end_clean();
    
        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    
        // ---------------------------------------------------------
    
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.

        $pdf->Output('example_001.pdf', 'I');
    
        //============================================================
    // END OF FILE
    //============================================================
    }
