	<?php 
	include("simple_html_dom.php");

	// Retrieve the DOM from a given URL
	$html = file_get_html('http://www.samakal.net/lead-news');
	//$c = 0;
	$allLink = array();
	$AllContent = array();
	//echo 'worksss';

	// Find all "A" tags and print their HREFs

	// Find all SPAN tags that have a class of "myClass"
	foreach($html->find('#most_view_content li a')  as $e){
		
		$pos = $e->href;
		array_push($allLink, $pos);
		//echo $pos."<br>";
	}
	//print_r($allLink);
	$allLink = array_unique($allLink);
	$counter = 1;
	foreach ($allLink as $link) 
	{
		$singlePost = file_get_html($link);
	//the title
		$title = $singlePost->find("#hl2");
		foreach($title as $elemet2){
			$newsTitle=base64_encode($elemet2->plaintext);
			//echo $newsTitle."<br>";
			//break;
		}


	//Single post image
		$image = $singlePost->find('.dtlImgGallery img');
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
			$pic=base64_encode("img/flyerBDHolder.jpg");
			//echo $pic."<br>";
		}

	//the detail
		$detail1 = $singlePost->find('#newsDtl p');
		$detail2 = $singlePost->find('#newsDtl div');
		$Dtest1=count($detail1);

		if ($Dtest1==0)
		{
			$detail=$detail2;
		}
		else
		{
			$detail=$detail1;
		}
		foreach($detail as $elemet3){
			$txt=base64_encode($elemet3->plaintext);
			//echo $txt;
		}
		$temparr= array('id' => $counter, 'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
		array_push($AllContent, $temparr);
		$counter++;
	}
	$fp = fopen('samakal.json', 'w');
	fwrite($fp,json_encode($AllContent));
	fclose($fp);
	?>