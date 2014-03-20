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

	function downloadLinks()
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
				if ($i != $columns_total - 1) {
					$output.= "\"" . $linkArray[$i]. "\"";
					$output.=",";
				}
				else {
					$output.="\"\"";
				}
			}
			$output.="\n";
		}
		

		// Download the file
		$name = 'links.csv';

		force_download($name, $output);

	}

    function do_upload()
    {

        $config['upload_path'] = 'upload';
        $config['allowed_types'] = '*';
       	$config['max_size']	= '1024';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);


        if ( ! $this->upload->do_upload())
		{
	  		$error = array('error' => $this->upload->display_errors());
 	  		$this->load->view('update_form', $error);
        }
		else
		{
			/* Upload successful! Now try updating database */
	    	$data = array('upload_data' => $this->upload->data());
	    	
	    	// First back up data in the case that the user submits a bad file.
	    	
	    	$links = $this->link->returnAllLinks();
			$output = "";
			$columns_total = count((array)$links[0]);

				// Get Records from the table
			foreach ($links as &$link) {
				$linkArray = array_values((array)$link);
				for ($i = 0; $i<$columns_total; $i++)
				{
					if ($i != $columns_total - 1) {
						$output.= "\"" . $linkArray[$i]. "\"";
						$output.=",";
					}
					else {
						$output.="\"\"";
					}
				}
				$output.="\n";
			}
			
			file_put_contents("upload/backupCSV.csv", $output);
			
			$uploadedData = $this->upload->data();
			//$uploadedData['file_name']
			if ($this->link->updateLinks($uploadedData['file_name']) == 0)
			{
				$data['upload_data'] = "SUCCESS";
			}
			else {
				$data['upload_data'] = "FAILURE: no changes made";
				$this->link->updateLinks("backupCSV.csv");
				unlink("upload/backupCSV.csv");
			}
				
	    	
            $this->load->view('update_success', $data);
		}
    }
}
?>