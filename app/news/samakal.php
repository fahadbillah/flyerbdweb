	<?php 
	include("simple_html_dom.php");

	// Retrieve the DOM from a given URL
	//$c = 0;
	$allLink = array();
	$AllContent = array();
	//echo 'worksss';

	// Find all "A" tags and print their HREFs

	// Find all SPAN tags that have a class of "myClass"
	$html = file_get_html('http://www.samakal.net/lead-news/allNews/page/1');
	foreach($html->find('.allNewsSummary a')  as $e){
		
		$pos = $e->href;
		array_push($allLink, $pos);
		//echo $pos."<br>";
	}

	$html = file_get_html('http://www.samakal.net/lead-news/allNews/page/2');
	foreach($html->find('.allNewsSummary a')  as $e){
		
		$pos = $e->href;
		array_push($allLink, $pos);
		//echo $pos."<br>";
	}

	$allLink = array_unique($allLink);
	//print_r($allLink);
	$counter = 1;
	foreach ($allLink as $link) 
	{
		$singlePost = file_get_html($link);
	//the title
		$title = $singlePost->find("#hl2");
		foreach($title as $elemet2){
			$newsTitle_beta1=$elemet2->plaintext;
			$newsTitle_beta2=preg_replace("/&#?[a-z0-9]{2,8};/i","", $newsTitle_beta1);
			$newsTitle=base64_encode($newsTitle_beta2);
			
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
		$txt_beta1="";
		/*$detail1 = $singlePost->find('#newsDtl p');
		$detail2 = $singlePost->find('#newsDtl div');
		$Dtest1=count($detail1);
		$Dtest2=count($detail2);*/
		/*if ($detail2 = $singlePost->find('#newsDtl div'))
		{
			$detail=$detail2;
		}
		elseif($detail1 = $singlePost->find('#newsDtl p'))
		{
			$detail=$detail1;
		}*/
		$txt = $singlePost->getElementById('#newsDtl');
		$txt = $txt->plaintext;

		//var_dump($detail);
		//$txt_beta1.= $detail->innertext;
		//echo $detail;
		/*foreach($detail as $elemet3){
			$txt_beta1.=$elemet3->plaintext;
			
		}*/
		$txt=preg_replace("/&#?[a-z0-9]{2,8};/i","", $txt);
		$txt=base64_encode($txt);
		
		$temparr= array('id' => $counter, 'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
		array_push($AllContent, $temparr);
		$counter++;
		//echo $link.' OK<br>';
		//break;
	}
	$fp = fopen('samakal.json', 'w');
	fwrite($fp,json_encode($AllContent));
	fclose($fp);
	?>