	<?php 
	include("simple_html_dom.php");

	// Retrieve the DOM from a given URL
	$html = file_get_html('http://dailynayadiganta.com');
	//$c = 0;
	$allLink = array();
	$AllContent = array();


	// Find all "A" tags and print their HREFs

	// Find all SPAN tags that have a class of "myClass"
	foreach($html->find(".tab-pane li a")  as $e){
		
		$pos = $e->href;
		array_push($allLink, $pos);
	
		//echo $pos."<br>";
		
	}
	//print_r($allLink);

	//header
	foreach ($allLink as $link) {
		$singlePost = file_get_html($link);

	//the title
		$title = $singlePost->find(".newscontent h3");
		foreach($title as $elemet2){
			$newsTitle=base64_encode($elemet2->plaintext);
			//echo $newsTitle."<br>";
			//break;
		}
	
	//Single post image
		$image = $singlePost->find(".span5 img");
		$Ztest=count($image);
		if ($Ztest>0)
		{
			foreach($image as $elemet4)
			{
				$pic=base64_encode($elemet4->src);
			//echo $pic."<br>";
			break;
			}
		}
		else
		{
			$pic=base64_encode("http://images1.wikia.nocookie.net/__cb20100722190004/logopedia/images/thumb/b/b6/SNCB_B_logo.svg/120px-SNCB_B_logo.svg.png");
			//echo $pic."<br>";
		}

	//the detail
		$detail = $singlePost->find('.content');

		foreach($detail as $elemet3){
			$txt=base64_encode($elemet3->plaintext);
		//echo $txt;
		}
		$temparr= array('title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
		array_push($AllContent, $temparr);
		//break;
	}
	$fp = fopen('noyaDigonto.json', 'w');
	fwrite($fp,json_encode($AllContent));
	fclose($fp);



	?>