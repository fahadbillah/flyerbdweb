<?php 
include("simple_html_dom.php");

$allLink = array();
$AllContent = array();
// Retrieve the DOM from a given URL
$html = file_get_html('http://www.bbc.co.uk/bengali');

foreach($html->find('.list li-plain,a')  as $e)
{

	$pos = $e->href;
	if (strpos($pos, "/news/20"))
	{
		$full_link= "http://www.bbc.co.uk".$pos;
		array_push($allLink, $full_link);
	}

}
$allLink = array_unique($allLink);
$counter = 1;
foreach ($allLink as $link) 
{
	$singlePost =file_get_html($link);
	//the title
	$title = $singlePost->find("h1");
	foreach($title as $elemet2)
	{
		$newsTitle=base64_encode($elemet2->plaintext); ########### checkpoint ###########
		break;
	}

	//image
	$image = $singlePost->find('.image img');
	$Ztest_img= count($image);
	if ($Ztest_img>0)
	{
		foreach($image as $elemet4)
		{
		$pic=base64_encode($elemet4->src); ########### checkpoint ###########
		break;

		}
	}


	else
	{
		// import checkpoint
		$pic = base64_encode("img/flyerBDHolder.jpg");

	}

	//the detail
	$detail = $singlePost->find('.bodytext p');
	$txt_beta="";
	foreach($detail as $elemet3)
	{
		$newsDetail=$elemet3->plaintext;
		$txt_beta.=$newsDetail; ########### checkpoint ###########
	}
	$txt=base64_encode($txt_beta);
	$temparr= array('id' => $counter, 'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);

	array_push($AllContent, $temparr);
	$counter++;
}

$fp = fopen('BBC.json', 'w');
fwrite($fp,json_encode($AllContent));
fclose($fp);
?>