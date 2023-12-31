<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Html3pdf {

    var $html;
    var $path;
    var $filename;
    var $paper_size;
    var $orientation;
    
    /**
     * Constructor
     *
     * @access	public
     * @param	array	initialization parameters
     */	
    function Html3pdf($params = array())
    {
        $this->CI =& get_instance();
        
        if (count($params) > 0)
        {
            $this->initialize($params);
        }
    	
        log_message('debug', 'PDF Class Initialized');
    
    }

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */	
    function initialize($params)
	{
        $this->clear();
		if (count($params) > 0)
        {
            foreach ($params as $key => $value)
            {
                if (isset($this->$key))
                {
                    $this->$key = $value;
                }
            }
        }
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set html
	 *
	 * @access	public
	 * @return	void
	 */	
	function html($html = NULL)
	{
        $this->html = $html;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set path
	 *
	 * @access	public
	 * @return	void
	 */	
	function folder($path)
	{
        $this->path = $path;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set path
	 *
	 * @access	public
	 * @return	void
	 */	
	function filename($filename)
	{
        $this->filename = $filename;
	}
	
	// --------------------------------------------------------------------


	/**
	 * Set paper
	 *
	 * @access	public
	 * @return	void
	 */	
	function paper($paper_size = NULL, $orientation = NULL)
	{
        $this->paper_size = $paper_size;
        $this->orientation = $orientation;
	}
	
	// --------------------------------------------------------------------


	/**
	 * Create PDF
	 *
	 * @access	public
	 * @return	void
	 */	
	function create($mode = 'download') 
	{
	    
   		if (is_null($this->html)) {
			show_error("HTML is not set");
		}
	    
   		if (is_null($this->path)) {
			show_error("Path is not set");
		}
	    
   		if (is_null($this->paper_size)) {
			show_error("Paper size not set");
		}
		
		if (is_null($this->orientation)) {
			show_error("Orientation not set");
		}
	    
	    //Load the DOMPDF libary
	 //    require_once("dompdf/dompdf_config.inc.php");
	    
	 //    $dompdf = new DOMPDF();
	 //    $dompdf->load_html($this->html);
	 //    $dompdf->set_paper($this->paper_size, $this->orientation);
	 //    $dompdf->render();
	    
	 //    if($mode == 'save') {
  //   	    $this->CI->load->helper('file');
		//     if(write_file($this->path.$this->filename, $dompdf->output())) {
		//     	return $this->path.$this->filename;
		//     } else {
		// 		show_error("PDF could not be written to the path");
		//     }
		// } else {
			
		// 	if($dompdf->stream($this->filename)) {
		// 		return TRUE;
		// 	} else {
		// 		show_error("PDF could not be streamed");
		// 	}
	 //    }
		ob_start();
		 include_once('tcpdf/tcpdf.php');
		// create new PDF document
		$pdf = new TCPDF('PDF_PAGE_ORIENTATION', PDF_UNIT, 'A4 PORTRAIT', true, 'UTF-8', false);
		//$pdf->SetCreator('TechResources');
		//$pdf->SetAuthor('Departamento de Tecnologia');
		//$pdf->SetTitle('Reporte de garantia');
		//$pdf->setHeaderData(PDF_HEADER_LOGO, 10, "TechResources", "Mayorista en Seguridad Electroníca", array(0, 6, 255), array(0, 64, 128));
		$pdf->setFooterData(array(0,64,0), array(0,64,128));
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(10, 20, 10);
		//$pdf->SetHeaderMargin(10);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// ---------------------------------------------------------
		// set default font subsetting mode
		$pdf->setFont('helvetica', '', 14, '', true);
		$pdf->AddPage();
		$pdf->writeHTML($this->html);
		ob_get_clean();
		$pdf->Output($this->path.$this->filename, 'F');

	}
	
	function output($option) 
	{
	    
   		if (is_null($this->html)) {
			show_error("HTML is not set");
		}
	    
   		
   		if (is_null($this->paper_size)) {
			show_error("Paper size not set");
		}
		
		if (is_null($this->orientation)) {
			show_error("Orientation not set");
		}
	    ob_start();
		include_once('tcpdf/tcpdf.php');
		// create new PDF document
		$pdf = new TCPDF('PDF_PAGE_ORIENTATION', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->setFooterData(array(0,64,0), array(0,64,128));
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(10, 20, 10);
		//$pdf->SetHeaderMargin(10);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// ---------------------------------------------------------
		// set default font subsetting mode
		$pdf->setFont('helvetica', '', 14, '', true);
		$pdf->AddPage();
		$pdf->writeHTML($this->html);
		///var_dump($this->html);
		ob_get_clean();
		$pdf->Output($this->path.$this->filename, 'I');
	    
	}
	
}

/* End of file Html2pdf.php */