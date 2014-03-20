<!DOCTYPE html>

<html>

<head>
	<title>APO Concentration Search (alpha)</title>
	<link href='http://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url() . 'css/style.css';?>">
	<!-- jQuery CDN  -->
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	
	<!-- BootStrap CDN -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
	
</head>

<body>
	<div id='container'>
    	<div class="header">
        	<img src = "<?php echo asset_url() . 'img/my_harvard_pic.png';?>" alt="" />
        </div>

	    <div class="main">
			<div id='checkboxes'>
				<div id="cat1Divisions" class='cat1'>
	      			<h3>Academic Divisions</h3>
	      			<div id="cat2Divisions" style="padding:0px;">
		        		<?php foreach ($academicDivisions as $item): ?>
						<p style="font-size:12px;"><input type="checkbox" class='cat2' name="<?=$item?>" value="<?=$item?>"><?=$item?></p>
						<?php endforeach; ?>
	      			</div>
				</div>
				<div id="cat1Likes" class='cat1'>
	        		<h3>I Am Interested In...</h3>
	        		<div id="cat2Likes" style="padding:0px;">
			        	<?php foreach ($learningAspirations as $item): ?>
		        		<p style="font-size:12px;"><input type="checkbox" class='cat2' name="<?=$item?>" value="<?=$item?>"><?=$item?></p>
		        		<?php endforeach; ?>
	        		</div>
				</div>
				<div id="cat1Careers" class='cat1'>
	        		<h3>Future Aspirations</h3>
	        		<div id="cat2Careers" style="padding:0px;">
			        	<?php foreach ($futureAspirations as $item): ?>
		        		<p style="font-size:12px;"><input type="checkbox" class='cat2' name="<?=$item?>" value="<?=$item?>"><?=$item?></p>
		        		<?php endforeach; ?>
	        		</div>
				</div>
	        </div>
		    <div id='resultsWrapper'>
		    	<div id='text_search'>
			    	 <p style="margin-top:10px;">&nbsp;&nbsp;<b>Your Results Sorted Below:</b> &nbsp;</p>
			    </div>
		        <div id='results'>
		            <table id='resultsTable'>
						<tbody id ='startResults'>
						</tbody>
		            </table>
				</div>
		    </div>
	    </div>
    </div>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49201724-1', 'balajipandian.com');
  ga('send', 'pageview');

  </script>
    <script>
    
    var jsonLinkData = [];
        
    $(document).ready(function(){
        // Hide everything
    	$("#startResults").html("");
    	$("#textBox").val("");
    	$("#text_search").hide();
    	$("#results").height(600);
    	
    	
		$('#cat1Divisions').accordion({
			collapsible: true,
			active: false
		});
		$('#cat1Likes').accordion({
			collapsible: true,
			active: false
		});
		$('#cat1Careers').accordion({
			collapsible: true,
			active: false
		});

		$('#cat2Divisions').css("height", "100%");
		$('#cat2Likes').css("height", "100%");
		$('#cat2Careers').css("height", "100%");

    	
    	$("#cat1Divisions").bind('click', function(){
    		if (!($("#cat1Divisions h3").hasClass("ui-state-active"))) {
	    		$("#cat2Divisions input").each(function () {
		    		$(this).attr("checked",false);
	    		});
	    		search();
    		}
        });
        
        $("#cat1Likes").bind('click', function(){
    		if (!($("#cat1Likes h3").hasClass("ui-state-active"))) {
	    		$("#cat2Likes input").each(function () {
		    		$(this).attr("checked",false);
	    		});
	    		search();
    		}
        });
        
        $("#cat1Careers").bind('click', function(){
    		if (!($("#cat1Careers h3").hasClass("ui-state-active"))) {
	    		$("#cat2Careers input").each(function () {
		    		$(this).attr("checked",false);
	    		});
	    		search();
    		}
        });
        
        $("#checkboxes input").bind('change', function() {
	    	search(); 
        });
        
    });

	function search()
	{
		$("#startResults").html("");
		$("#textBox").val("");
		
		categories = [];
		
		tempArray = [];
		if ($("#cat1Divisions h3").hasClass("ui-state-active"))
		{	
			var cat2Checked = 0;
			$("#cat2Divisions input").each(function() {
				if ($(this).is(":checked"))
				{
					cat2Checked++;
					tempArray.push(this.name);
				}
			});
			
			if (cat2Checked !=0)
			{
				object = {'Divisions': tempArray};
				categories.push(object);
			}
		}

		
		tempArray = [];
		if ($("#cat1Likes h3").hasClass("ui-state-active"))
		{	
			var cat2Checked = 0;
			$("#cat2Likes input").each(function() {
				if ($(this).is(":checked"))
				{
					cat2Checked++;
					tempArray.push(this.name);
				}

			});
			
			if (cat2Checked != 0)
			{
				object = {'Likes': tempArray};
				categories.push(object);
			}
		}
		
		tempArray = [];
		if ($("#cat1Careers h3").hasClass("ui-state-active"))
		{	
			var cat2Checked = 0;
			$("#cat2Careers input").each(function() {
				if ($(this).is(":checked"))
				{
					cat2Checked++;
					tempArray.push(this.name);
				}

			});
			
			if (cat2Checked != 0)
			{
				object = {'Careers': tempArray};
				categories.push(object);
			}
		}

		//console.log(categories);

		$.ajax({
			type: "POST",
	        url: '<?php echo site_url('home/search'); ?>',
	        data: {
	        		categories:JSON.stringify(categories)
	        	  },
	        complete: function (xhr, status) {
	        	console.log(xhr);
		    	if (status === 'error' || xhr.statusText != "OK") {
		    		console.log(xhr);
			        alert("Could not complete search.");
			    }
			    else {
			        // Success
			        if (xhr.responseText == "")
			        {
			        	$("#textBox").val("");
			        	$("#text_search").hide();
			        	$("#results").height(600);
			        	return;
			        }
			        $("#text_search").show();
			        $("#results").height(560);
			        
			        jsonLinkData = JSON.parse(xhr.responseText);
			        
			        linkDict = [];
			        
			        for (var i=0; i < jsonLinkData.length; i++)
			        {
				        var link = jsonLinkData[i];
				        if (link['title'] in linkDict)
				        {
					        linkDict[link['title']].push(link);
				        }
				        else
				        {
					        linkDict[link['title']] = [link];
				        }
				        
			        }
			        
			        for (var title in linkDict)
			        {
			        	string = "";
			        	string = string + '<tr><td>' + title;
			        	
				        for (link in linkDict[title])
				        {
				        	if ((linkDict[title][link]['type']) == 'c')
				        		string = string + '<a class="concentrationResult" href="' + linkDict[title][link]['url'] +'" target="_blank"><b>Concentration</b></a>';
				        	else if ((linkDict[title][link]['type']) == 's')
				        		string = string + '<a class="secondaryResult" href="' + linkDict[title][link]['url'] +'" target="_blank"><b>Secondary</b></a>';
				        	else
				        		string = string + '<a class="trackResult" href="' + linkDict[title][link]['url'] +'" target="_blank"><b>Track</b></a>';
				        }
				        
				        string = string + '</td></tr>';
				        

				        $("#startResults").append(string);
			        }
			        
					//for (var i=0; i < jsonLinkData.length; i++) {
					    //var link = jsonLinkData[i];
					    //console.log(link);
					    /*$("#startResults").append('<li><p><b>' + link['title'] + '</b></p><p> <a href="' + link['url'] +'">' + link['url'] + '</a> score: '+ link['score'] +' ' + link['cat1'] + ' '+ link['cat2'] + ' ' + link['debug'] + '</p></li>');*/
					    /*$("#startResults").append('<li><p> <a href="' + link['url'] +'"><b>' + link['title'] + '</b></a></p></li>');*/
					    //$("#startesults").append('<tr><td><a href="' + link['url'] +'" target="_blank"><b>' + link['title'] + '</b></a></td></tr>');
					    //$("#startResults").append('<tr><td>' + link['title'] + '</td></tr>');
					//}
			    }
			}
		});
		
	}
	</script>

</body>
</html>
