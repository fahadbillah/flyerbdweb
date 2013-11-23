<?php 
include("simple_html_dom.php");

// Retrieve the DOM from a given URL
$html = file_get_html('http://newagebd.com/section.php?date=2013-11-10&cid=1');
//$c = 0;
$allLink = array();
$AllContent = array();


// Find all "A" tags and print their HREFs

// Find all SPAN tags that have a class of "myClass"
foreach($html->find('.heading2 a')  as $e)

{
	$pos = $e->href;

	$full_link= "http://newagebd.com/".$pos;
	array_push($allLink, $full_link);
//echo $full_link."<br>";

}
$allLink = array_unique($allLink);
$counter = 1;
foreach ($allLink as $link)
{
//header
	$singlePost = file_get_html($link);

//the title
	$title = $singlePost->find("h2");
	foreach($title as $elemet2)
	{
		$newsTitle=base64_encode($elemet2->plaintext);
		//echo $newsTitle."<br>";
		break;
	}
//Single post image
	$image = $singlePost->find(".clearfix a img"); 
	$Ztest=count($image);
	if ($Ztest>0)
	{
		foreach($image as $elemet4)
		{
			$pic=$elemet4->src;

			

//break;
		}
		$full_pic=base64_encode("http://newagebd.com/".$pic);
	}
	else
	{
		$pic = base64_encode("img/flyerBDHolder.jpg");

	
	}
//the detail
	$detail = $singlePost->find('div p');

	foreach($detail as $elemet3){
		$txt=base64_encode($elemet3->plaintext);
		//echo $txt;
	}
	
	$temparr= array('id'=>$counter, 'title' => $newsTitle, 'newsImage'=>$full_pic, 'detail'=>$txt);
//echo "<br>".$txt;
	$counter++;
	array_push($AllContent, $temparr);
}
$fp = fopen('newAge.json', 'w');
fwrite($fp,json_encode($AllContent));
fclose($fp);
?>