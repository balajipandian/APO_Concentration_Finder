<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Update extends CI_Controller {
      
    function __construct()
    {
        parent::__construct();
		$this->load->helper(array('form', 'url', 'download'));
		$this->load->model('link', '', TRUE);
    }

    public function index()
    {
		$this->load->view('update_form', array('error' => ' ' ));
    }

	public function downloadLinks()
	{
		$links = $this->link->returnAllLinks();
		
		$output = "";
		
		$rows_total = count($links);
		$columns_total = count((array)$links[0]);

		// Get Records from the table
		foreach ($links as &$link) {
			$linkArray = array_values((array)$link);
			for ($i = 0; $i<$columns_total; $i++)
			{
				if ($i != $columns_total) {
					//$output.= "\"" . $linkArray[$i]. "\"";
					$output.= $linkArray[$i];
					$output.="\t";
				}
				else {
					//$output.="\"\"";
				}
			}
			$output.="\n";
		}
		

		// Download the file
		$name = 'links.tsv';

		force_download($name, $output);

	}

}
?>