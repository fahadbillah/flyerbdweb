<?php 
include("simple_html_dom.php");

// Retrieve the DOM from a given URL
$html = file_get_html('http://www.thedailystar.net/beta2/');
//$c = 0;
$allLink = array();
$AllContent = array();


// Find all "A" tags and print their HREFs

// Find all SPAN tags that have a class of "myClass"
	foreach($html->find('.most_viewed li a')  as $e)
	{
		$pos = $e->href;
		array_push($allLink, $pos);
	//echo $pos."<br>";
	}
	$allLink = array_unique($allLink);
//header
	$counter = 1;
	foreach ($allLink as $link)
	{
		$singlePost = file_get_html($link);;

//the title
		$title = $singlePost->find('.headline6 bold mb5 mb10,h1');
		foreach($title as $elemet2){
			//$newsTitle=base64_encode($elemet2->plaintext);
			$titleBeta=$elemet2->plaintext;
			$titleBeta2=preg_replace("/&#?[a-z0-9]{2,8};/i","", $titleBeta);
			$newsTitle=base64_encode($titleBeta2); ########## checkpoint #########
//echo $newsTitle."<br>";
		}
//Single post image
	$image = $singlePost->find('img');
	foreach($image as $elemet4)
	{
		$pic_beta=$elemet4->src;

		if (strpos($pic_beta, ".jpg"))
		{

			$pic=base64_encode($pic_beta);

			break;
		}
		

	}


//the detail
	$detail = $singlePost->find('.post-entry mb10,p');
	$txt_beta1="";
	foreach($detail as $elemet3){
		$dtl=$elemet3->plaintext;
		$txt_beta1.=$dtl;
	}
	$txt_beta2=preg_replace("/&#?[a-z0-9]{2,8};/i","", $txt_beta1);
	$txt=base64_encode($txt_beta2);
	$temparr= array('id'=>$counter, 'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
//echo "<br>".$txt;
	$counter++;
	array_push($AllContent, $temparr);
}

$fp = fopen('dailyStar.json', 'w');
fwrite($fp,json_encode($AllContent));
fclose($fp);
?>