<?php 
include("simple_html_dom.php");

// Retrieve the DOM from a given URL
$html = file_get_html('http://www.newstoday.com.bd');
//$c = 0;
$allLink = array();
$AllContent = array();


// Find all "A" tags and print their HREFs

// Find all SPAN tags that have a class of "myClass"
foreach($html->find('.hit_list li a')  as $e)

{
	$pos = $e->href;

	$full_link= "http://www.newstoday.com.bd/".$pos;
	array_push($allLink, $full_link);
//echo $full_link."<br>";
	$allLink = array_unique($allLink);
	$counter = 1;

}
foreach ($allLink as $link) 
{
//header
	$singlePost = file_get_html($link);

//the title
	$title = $singlePost->find('h1');
	foreach($title as $elemet2)
	{
		$newsTitle=base64_encode($elemet2->plaintext);
//echo $newsTitle."<br>";

	}
//image
	$image = $singlePost->find(".rimg");
//foreach($image as $elemet4)
	$Ztest=count($image);
	if ($Ztest>0)
	{
		foreach($image as $elemet4)
		{
			$pic=$elemet4->src;
			$full_pic=base64_encode("http://www.newstoday.com.bd/".$pic);
//echo $pic."<br>";
			break;
		}
	}
	else
	{
		$full_pic = base64_encode("img/flyerBDHolder.jpg");

//echo $pic."<br>";
	}


//the detail
	$detail = $singlePost->find('h2');

	foreach($detail as $elemet3)
	{
		$txt=base64_encode($elemet3->plaintext);
}	//echo $txt."<br>";
$temparr= array('url'=>$link, 'id' => $counter,'title' => $newsTitle, 'newsImage'=>$full_pic, 'detail'=>$txt);
array_push($AllContent, $temparr);
$counter++;
//break;
}
$fp = fopen('newsToday.json', 'w');
fwrite($fp,json_encode($AllContent));
fclose($fp);



?>