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
	print_r($allLink);
	$allLink = array_unique($allLink);
$counter = 1;
	//header
	foreach ($allLink as $link) {
		$singlePost = file_get_html($link);

	//the title
		$title = $singlePost->find(".newscontent h3");
		foreach($title as $elemet2){
			//$newsTitle=base64_encode($elemet2->plaintext);
			$titleBeta=$elemet2->plaintext;
			$titleBeta2=str_replace ( "&nbsp;" , "" , $titleBeta);
			$newsTitle=base64_encode($titleBeta2); ########## checkpoint #########
			
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
			$pic=base64_encode("img/flyerBDHolder.jpg");
			//echo $pic."<br>";
		}

	//the detail
		$detail = $singlePost->find('.content');

		foreach($detail as $elemet3){
			//$txt=base64_encode($elemet3->plaintext);

			$txt_beta1=$elemet3->plaintext;
			$txt_beta2=str_replace( "&nbsp;" , "" , $titleBeta1);
			$txt=base64_encode($txt_beta2);
		}
		$temparr= array('id' => $counter, 'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
		array_push($AllContent, $temparr);
		$counter++;
		//break;//
	}
	$fp = fopen('noyaDigonto.json', 'w');
	fwrite($fp,json_encode($AllContent));
	fclose($fp);
?>