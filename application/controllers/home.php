<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('link','',TRUE);
	}
	
	function search()
	{

		# Get Links
		$categoriesPOST = $this->input->post('categories');

		if ($categoriesPOST == '[]')
		{
			echo "";
			return;
		}
		
		$linksArray = $this->link->getLinksWithCategories($categoriesPOST);
		
		
		# Score Links
		$categories = json_decode($categoriesPOST);
		
		
		if (is_array($categories))
		{
			foreach($linksArray as $link)
			{
				$link->score = 0;
				foreach ($categories as $category)
				{
					foreach ($category as $key => $value)
					{
						if ($key == "Divisions")
						{
							foreach ($category->Divisions as $like)
							{
								if (!(strpos($link->academicDivisions,"\"" . $like . "\"")==FALSE))
									$link->score = $link->score + 1;
									
							}
							
						}
						elseif ($key == "Likes")
						{
							foreach ($category->Likes as $like)
							{
								if (!(strpos($link->learningAspirations,"\"" . $like . "\"")==FALSE))
									$link->score = $link->score + 1;
							}
							
						}
						elseif ($key == "Careers")
						{
							foreach ($category->Careers as $like)
							{
								if (!(strpos($link->futureAspirations,"\"" . $like . "\"")==FALSE))
									$link->score = $link->score + 1;
							}
						}
	
					}
				}
			}
		}
		
		# Sort Links
		$score = array();
		foreach ($linksArray as $link)
		{
			$score[$link->id] = $link->score;
		}
		array_multisort($score, SORT_DESC, $linksArray);
		
		# Return Links
		echo json_encode($linksArray);
	}	

	function getAcademicDivisionsUniqueList()
	{	
		$responseList = $this->link->getAcademicDivisions();
		
		$categoryArray = array();
		
		if (empty($responseList))
			$categoryArray;
			
		foreach ($responseList as $response)
		{
			$responseElementArray = json_decode($response->academicDivisions);
			
			if (empty($responseElementArray))
				continue;


			foreach ($responseElementArray as $element)
				array_push($categoryArray, $element);
		}
		
		
		return array_unique($categoryArray);
	}
	
	function getLearningAspirationUniqueList()
	{
		$responseList = $this->link->getLearningAspirations();
		
		$categoryArray = array();
		
		if (empty($responseList))
			$categoryArray;
			
		foreach ($responseList as $response)
		{
			$responseElementArray = json_decode($response->learningAspirations);
			
			if (empty($responseElementArray))
				continue;
				
			foreach ($responseElementArray as $element)
				array_push($categoryArray, $element);
		}
		
		
		return array_unique($categoryArray);
	}
	
	function getFutureAspirationsUniqueList()
	{
		$responseList = $this->link->getFutureAspirations();
		
		$categoryArray = array();
		
		if (empty($responseList))
			$categoryArray;


		foreach ($responseList as $response)
		{
			$responseElementArray = json_decode($response->futureAspirations);
			
			if (empty($responseElementArray))
				continue;

			foreach ($responseElementArray as $element)
				array_push($categoryArray, $element);
		}
		
		
		return array_unique($categoryArray);
	}
	
	function index()
	{
		$data['academicDivisions'] = $this->getAcademicDivisionsUniqueList();
		$data['learningAspirations'] = $this->getLearningAspirationUniqueList();
		$data['futureAspirations'] = $this->getFutureAspirationsUniqueList();
		
		
		$this->load->view('home_view', $data);
	}
}
?>