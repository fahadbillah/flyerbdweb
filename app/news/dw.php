<?php 
include("simple_html_dom.php");

// Retrieve the DOM from a given URL
$html1 = file_get_html('http://www.dw.de/s-11973');
$html2 = file_get_html('http://www.dw.de/s-100248');
$html3 = file_get_html('http://www.dw.de/s-11976');
//$c = 0;

$allLink = array();
$AllContent = array();


// Find all "A" tags and print their HREFs

// Find all SPAN tags that have a class of "myClass"
foreach($html1->find('.minHeight a')  as $e)

{
	$pos = $e->href;

	$full_link= "http://www.dw.de/s-11973".$pos;
	array_push($allLink, $full_link);
	//echo $full_link."<br>";

}
foreach($html2->find('.minHeight a')  as $e)

{
	$pos = $e->href;

	$full_link= "http://www.dw.de/s-100248".$pos;
	array_push($allLink, $full_link);
	//echo $full_link."<br>";

}
foreach($html3->find('.minHeight a')  as $e)

{
	$pos = $e->href;

	$full_link= "http://www.dw.de/s-11976".$pos;
	array_push($allLink, $full_link);
	//echo $full_link."<br>";

}
//title
$allLink = array_unique($allLink);
$counter = 1;
foreach ($allLink as $link)
{
$singlePost = file_get_html($link);

//the title
	$title = $singlePost->find('h1');
	foreach($title as $elemet2)
	{
		$newsTitle=$elemet2->plaintext;
		$newsTitle_beta2= preg_replace("/&#?[a-z0-9]{2,8};/i","", $newsTitle);
		$newsTitle=base64_encode($newsTitle_beta2);
	//echo $newsTitle."<br>";
	}
//image
	$image = $singlePost->find('.picBox img');
	$Ztest=count($image);
	if ($Ztest>0)
	{
		foreach($image as $elemet4)
		{
			$pic=$elemet4->src;
			$pic=base64_encode("http://www.dw.de/".$pic);
			//$pic=$elemet4->src;
//break;
//echo $pic."<br>";
		}
	}
	else
	{
		$pic=base64_encode("img/flyerBDHolder.jpg");

	}
	//detail news

	$detail = $singlePost->find('.longText');
	$txt_beta1="";	
	foreach($detail as $elemet3)
	{
		$dtl=$elemet3->plaintext;
		$txt_beta1.=$dtl;
	}
	$pos = strrpos($txt_beta1, "ই-মেল");
	$rest = substr($txt_beta1, 0, $pos);
	$txt_beta2=preg_replace("/&#?[a-z0-9]{2,8};/i","", $rest);
	$txt=base64_encode($txt_beta2);
	$temparr= array('id' => $counter,'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
	array_push($AllContent, $temparr);
	$counter++;
	//echo $txt;
}
$fp = fopen('dw.json', 'w');
fwrite($fp,json_encode($AllContent));
fclose($fp);

?>