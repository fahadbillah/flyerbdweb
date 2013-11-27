<?php 
include("simple_html_dom.php");

// Retrieve the DOM from a given URL
$html = file_get_html('http://www.banglanews24.com/index.php');
//$c = 0;
$allLink = array();
$AllContent = array();


// Find all "A" tags and print their HREFs

// Find all SPAN tags that have a class of "myClass"
foreach($html->find(".DSpecialTop a") as $e){

	$pos1 = $e->href;
	$FullLink1= "http://www.banglanews24.com/".$pos1;
	array_push($allLink, $FullLink1);
//echo $pos;

}

foreach($html->find(".DSpecialTopR a") as $e){

	$pos2 = $e->href;
	$FullLink2= "http://www.banglanews24.com/".$pos2;
	array_push($allLink, $FullLink2);
//echo $pos;

}
foreach($html->find(".liHeadList a") as $e)
{

	$pos3 = $e->href;
	$FullLink3= "http://www.banglanews24.com/".$pos3;
	array_push($allLink, $FullLink3);
//echo $pos;

}
$allLink = array_unique($allLink);
//print_r($allLink);
/*foreach($allLink as $i)
{ 
echo "http://www.banglanews24.com/".$i."<br>";
}
*/
$counter = 1;
foreach ($allLink as $link)
{
	$singlePost = file_get_html($link);

//the title
	$title = $singlePost->find('.DContent h1');
	foreach($title as $elemet2)
	{
		$newsTitle=$elemet2->plaintext;
		$newsTitle_beta2= preg_replace("/&#?[a-z0-9]{2,8};/i","", $newsTitle);
		//echo $newsTitle."<br>";
//echo $title;
		$newsTitle=base64_encode($newsTitle_beta2);
	}

/*$title = $singlePost->find('.DContent h1');
$newsTitle=$elemet2->plaintext;*/
//$titleBeta=$title[0]->plaintext;
/*$titleBeta2=preg_replace("/&#?[a-z0-9]{2,8};/i","", $titleBeta);
$newsTitle=$titleBeta2;*/
//echo $newstitle."<br>";
//$newsTitle=base64_encode($titleBeta2); ########## checkpoint #########
//echo $newsTitle."<br>";

//Single post image
	$image = $singlePost->find('.DContent img[title]');
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
	$detail = $singlePost->find('.DContent p');
	$txt_beta1="";
	foreach($detail as $elemet3)
	{
		$dtl=$elemet3->plaintext;
		$txt_beta1.=$dtl;
	}
	$pos = strrpos($txt_beta1, "বাংলাদেশ");
	$rest = substr($txt_beta1, 0, $pos);
	$txt_beta2=preg_replace("/&#?[a-z0-9]{2,8};/i","", $rest);
	//$txt_beta2=str_replace("&nbsp;" , "" , $txt_beta1);
	//echo $rest;
	//break;
	$txt=base64_encode($txt_beta2);
	$temparr= array('url'=>$link, 'id'=>$counter, 'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
	array_push($AllContent, $temparr);
	$counter++;
		//echo $link.' OK<br>';
		//break;
}
$fp = fopen('banglaNews24.json', 'w');
fwrite($fp,json_encode($AllContent));
fclose($fp);

?>

