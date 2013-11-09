<?php 
include("simple_html_dom.php");
$allLink = array();
$AllContent = array();
// Retrieve the DOM from a given URL

$html = file_get_html('http://www.aljazeera.com/category/country/bangladesh');

foreach($html->find('.stories-container table a') as $e)
{
	$pos = $e->href;
	if (strpos($pos, "/20"))
	{
		$full_link= "http://www.aljazeera.com".$pos;
		array_push($allLink, $full_link);

	}
} 
$allLink = array_unique($allLink);

$counter = 1;
foreach ($allLink as $link) 
{
	$singlePost = file_get_html($link);

//title

	$title = $singlePost->find('h1');
	foreach($title as $elemet2)
	{
		$titleBeta=$elemet2->plaintext;
		$titleBeta2=str_replace ( "&nbsp;" , "" , $titleBeta);
		$newsTitle=base64_encode($titleBeta2); ########## checkpoint #########
	}

//timestamp

$subTitle = $singlePost->find('#dvArticleDate');

foreach($subTitle as $element)
{
	$timeStamp=base64_encode($element->plaintext); ########## checkpoint #########
}

//picture

$image = $singlePost->find('#mediaContainer img');
$zTest=count($image);
if ($zTest>0)
{
	foreach($image as $elemet4)
	{
		$pic_beta = $elemet4->src;

		if (strpos($pic_beta, ".jpg"))
		{
			$pic=base64_encode('http://www.aljazeera.com/'.$pic_beta); ########## checkpoint #########
		}

	}
}

else
{
// import checkpoint

	$pic = base64_encode("img/flyerBDHolder.jpg"); ########## checkpoint #########

}

//detail

$detail = $singlePost->find(".DetailedSummary p");
$txt_beta="";
foreach($detail as $elemet3){
	$Dtl=$elemet3->plaintext;
	$txt_beta.=$Dtl;
}
$pos2 = strrpos($txt_beta, ".")+1;
$filtDetail = substr($txt_beta, 0, $pos2);
$filtDetail2=str_replace ( "&nbsp;" , "" , $filtDetail);
$txt=base64_encode($filtDetail2); ########## checkpoint #########

$temparr= array('id'=>$counter,'title' => $newsTitle,'pubDate'=>$timeStamp, 'newsImage'=>$pic, 'detail'=>$txt);
$counter++;
array_push($AllContent, $temparr);
}
$fp = fopen('alJazeera.json', 'w');
fwrite($fp,json_encode($AllContent));
fclose($fp);
?>
