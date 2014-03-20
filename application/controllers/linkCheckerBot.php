<?php
class Linkbot extends CI_Controller{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		print "FDSSA";
	}
}

?>

class Linkbot extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('link','',TRUE);
	}

	function index()
	{
		echo "ASDF";
		# get Links
		$linksArray = $this->link->returnAllLinks();
		foreach ($linksArray as $link)
		{
			echo $link;
			return;
			
			$url = 'http://www.example.com';
			
			$headers = get_headers($url, 1);
			if ($headers[0] == 'HTTP/1.1 200 OK') {
			//valid 
			}

			if ($headers[0] == 'HTTP/1.1 301 Moved Permanently') {
			//moved or redirect page
			}


			curl_close($handle);
		}

	}
}