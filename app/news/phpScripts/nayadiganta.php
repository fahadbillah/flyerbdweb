<?php 
include("simple_html_dom.php");

// Retrieve the DOM from a given URL
$html = file_get_html('http://www.dailynayadiganta.com/');
//$c = 0;
$allLink = array();
$AllContent = array();
// Find all SPAN tags that have a class of "myClass"



foreach($html->find('#tab1 ul li a')  as $e){

	$pos = $e->href;
	array_push($allLink, $pos);

}

$counter = 1;
$allLink = array_unique($allLink);
foreach ($allLink as $link2)
{
	//title
	$link="".$link2;
	$singlePost = str_get_html(file_get_contents($link));

	//the title
	$title = $singlePost->find('h3');
	foreach($title as $elemet2)
	{
		$newsTitle=$elemet2->plaintext;
		$newsTitle_beta2= preg_replace("/&#?[a-z0-9]{2,8};/i","", $newsTitle);
		$newsTitle=base64_encode($newsTitle_beta2);
	}
	//Single post image
	$image = $singlePost->find("div.span5 img");
	$Ztest=count($image);
	if ($Ztest>0)
	{
		foreach($image as $elemet4)
		{
			$pic=base64_encode($elemet4->src);
			//echo $pic."<br>";
		}
	}
	else
	{
		$pic=base64_encode("img/flyerBDHolder.jpg");
		//echo $pic."<br>";
	}
	
	//detail news
	$detail = $singlePost->find("div.content");
	$txt_beta1="";	
	foreach($detail as $elemet3)
	{
		$dtl=$elemet3->plaintext;
		$txt_beta1.=$dtl;
	}

	$txt=preg_replace("/&#?[a-z0-9]{2,8};/i","",$txt_beta1);
	$txt=base64_encode($txt);
	$temparr= array('url'=>$link, 'id' => $counter,'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
	array_push($AllContent, $temparr);
	$counter++;
}
$fp = fopen('nayadiganta.json', 'w');
fwrite($fp,json_encode($AllContent));
fclose($fp);
	

	
?>