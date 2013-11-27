<?php 
include("simple_html_dom.php");

// Retrieve the DOM from a given URL
$html = file_get_html('http://www.kalerkantho.com/index.php');
//$c = 0;
$allLink = array();
$AllContent = array();


// Find all "A" tags and print their HREFs

// Find all SPAN tags that have a class of "myClass"
foreach($html->find(".tab_img_hl a") as $e)
{

	$pos = $e->href;

/*$FullLink= "http://kalerkantho.com/".$pos."<br>";
echo $FullLink;*/
if(strpos($pos,"online"))
{
	array_push($allLink,$pos);
	//echo $pos."<br>";
}

}
$allLink = array_unique($allLink);
$counter = 1;
//headerforeach ($allLink as $link) 
foreach ($allLink as $link) 
{
	$singlePost = file_get_html($link);
//title
	$title2 = $singlePost->find("title");
	foreach($title2 as $elemet2){
		$newsTitle2=$elemet2->plaintext;
		$newsTitle4=str_replace ( "&nbsp;" , "" , $newsTitle2);

		$newsTitle3 = strpos($newsTitle4, "|");
		$newsTitle = base64_encode(substr($newsTitle2, 0, $newsTitle3));
		
		//echo $newsTitle."<br>";
//echo $title;
	}
//Single post image
	$image = $singlePost->find('#newsImg');
	$Ztest= count($image);
	if ($Ztest>0)
	{
		foreach($image as $elemet4)
		{
			$pic=base64_encode($elemet4->src);
		}
		//echo $pic."<br>";
	}
	else
	{
		$pic=base64_encode("img/flyerBDHolder.jpg");
		//echo $pic."<br>";
	}
//the detail
	$detail = $singlePost->find("#newsDtl p");
	$txt_2="";
	foreach($detail as $elemet3)
	{
		$Dtl_beta1=$elemet3->plaintext;
		$txt_2.=$Dtl_beta1;
	}
	$txt_beta2=str_replace( "&nbsp;" , "" , $txt_2);
	$txt=base64_encode($txt_beta2);
	$temparr= array('url'=>$link, 'id' => $counter,'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
	array_push($AllContent, $temparr);
	$counter++;
}
$fp = fopen('kalerKantho.json', 'w');
fwrite($fp,json_encode($AllContent));
fclose($fp);
?>