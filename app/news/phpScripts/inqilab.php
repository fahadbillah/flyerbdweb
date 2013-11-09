<?php 
include("simple_html_dom.php");
date_default_timezone_set('Asia/Dhaka'); // CDT

$info = getdate();
$date = str_pad($info['mday'], 2, "0", STR_PAD_LEFT);
$date .= "/";
$month = $info['mon']."/";
$year = $info['year']."/";

$DynamicLink="http://dailyinqilab.com/".$year.$month.$date;

$homeLink=$DynamicLink."index.php";
// Retrieve the DOM from a given URL
$html = file_get_html($homeLink);
//$c = 0;
$allLink = array();
$AllContent = array();


// Find all "A" tags and print their HREFs

// Find all SPAN tags that have a class of "myClass"
foreach($html->find('.feature-home a')  as $e)
{

	$pos = $e->href;
	$FullLink= $DynamicLink.$pos;
//echo $FullLink."<br>";

	array_push($allLink, $FullLink);
}
$allLink = array_unique($allLink);			
$counter = 1;
foreach ($allLink as $link) {

	$singlePost = file_get_html($link);
//the title
	$title = $singlePost->find(".DetailsHeading");
	foreach($title as $elemet2){
		//$newsTitle=base64_encode($elemet2->plaintext);
		$titleBeta1=$elemet2->plaintext;
		$titleBeta2=str_replace ( "&nbsp;" , "" , $titleBeta1);
		$newsTitle=base64_encode($titleBeta2); ########## checkpoint #########
	}

//Single post image
	$image = $singlePost->find("#f img");
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

//the detail
	$detail = $singlePost->find('#f');

	foreach($detail as $elemet3){
		$txt_beta1=$elemet3->plaintext;
		$txt_beta2=str_replace( "&nbsp;" , "" , $titleBeta1);
		$txt=base64_encode($txt_beta2);
	}
	$temparr= array('id' => $counter, 'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
	array_push($AllContent, $temparr);
	$counter++;
}
$fp = fopen('inqilab.json', 'w');
fwrite($fp,json_encode($AllContent));
fclose($fp);

?>