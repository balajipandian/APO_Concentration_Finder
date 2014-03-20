<?php
Class Link extends CI_Model
{

	/*
	"Array
(
    [0] => stdClass Object
        (
            [Health and Safety] => Array
                (
                    [0] => Immediate Crisis
                )

        )

    [1] => stdClass Object
        (
            [Residential Life] => Array
                (
                )

        )

)
1"
*/

    function returnAllLinks()
	{

		$sql = "SELECT * FROM links";			
		$query = $this->db->query($sql);

		return $query->result();
	}
	
	/*function updateLinks($filename)
	{
		// Clear table before updating table.
		$sql = "TRUNCATE TABLE links";
		$this->db->query($sql);
		
		
		
		$filepath = "upload/" . $filename;
		$sql = "LOAD DATA LOCAL INFILE '{$filepath}' INTO TABLE links FIELDS TERMINATED BY ',' ENCLOSED BY '\"'LINES TERMINATED BY '\n'";
		
		try
		{
			$this->db->query($sql);
			return 0;
		}
		catch (Exception $e)
		{
			return 1;
		}
	}*/
	
	function getAcademicDivisions()
	{
		$sql = "SELECT DISTINCT `academicDivisions` FROM links";
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	function getLearningAspirations()
	{
		$sql = "SELECT DISTINCT `learningAspirations` FROM links";
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	function getFutureAspirations()
	{
		$sql = "SELECT DISTINCT `futureAspirations` FROM links";
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	function getLinksWithCategories($categories)
	{
		
		
		$categories = json_decode($categories);
		
		$queryString = '';
		
		if (is_array($categories))
		{
			foreach ($categories as $category)
			{
				foreach ($category as $key => $value)
				{
					if ($key == "Divisions")
					{
						foreach ($category->Divisions as $division)
						{
							if ($queryString == '')
							{
								$queryString = "(academicDivisions LIKE '%$division%')";
							}
							else
							{
								$queryString = $queryString . "AND (academicDivisions LIKE '%$division%')";
							}
						}
						
					}
					elseif ($key == "Likes")
					{
						foreach ($category->Likes as $like)
						{
							if ($queryString == '')
							{
								$queryString = "(learningAspirations LIKE '%$like%')";
							}
							else
							{
								$queryString = $queryString . "AND (learningAspirations LIKE '%$like%')";
							}
						}
						
					}
					elseif ($key == "Careers")
					{
						foreach ($category->Careers as $career)
						{
							if ($queryString == '')
							{
								$queryString = "(futureAspirations LIKE '%$career%')";
							}
							else
							{
								$queryString = $queryString . "AND (futureAspirations LIKE '%$career%')";
							}
						}
					}
				}		
			}
			
		}
				
		$sql = "SELECT * FROM links WHERE " . $queryString;		
		$query = $this->db->query($sql);
		
		#return $sql;
		return $query->result();
	}
}
?>