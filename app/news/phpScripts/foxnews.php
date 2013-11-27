<?php 
include("simple_html_dom.php");

// Retrieve the DOM from a given URL
$html = file_get_html('http://www.foxnews.com/topics/bangladesh.htm');
//$c = 0;
$allLink = array();
$AllContent = array();
$allLink_latino=array();

// Find all "A" tags and print their HREFs

// Find all SPAN tags that have a class of "myClass"
foreach($html->find(".ez-title") as $e)
{

	$pos1 = $e->href;

	$pos = strrpos($pos1, "/latino");
	if($pos)
	{
		array_push($allLink_latino, $pos1);
	}
	else
	{
		array_push($allLink, $pos1);
	}

}


$allLink = array_unique($allLink);
$counter = 1;
foreach ($allLink as $link)
{

	if ($link=="")
	{
		continue;
	}

	else
	
	{
		$singlePost = str_get_html(file_get_contents($link));
	
	//the title
		$title = $singlePost->find("#article-title");
		foreach($title as $elemet2){
			$newsTitle=$elemet2->plaintext;
	
			$newsTitle_beta2= preg_replace("/&#?[a-z0-9]{2,8};/i","", $newsTitle);
	
			$newsTitle=base64_encode($newsTitle_beta2);
			//echo $newsTitle."<br>";
	//echo $title;
	//break;
		}
	//image
		$image = $singlePost->find('.m img');
		$Ztest=count($image);
		if ($Ztest>0)
		{
			foreach($image as $elemet4)
			{
				$pic=$elemet4->src;
	
				$pic=base64_encode($elemet4->src);
	//break;
	//echo $pic."<br>";
			}
		}
		else
		{
			$pic=base64_encode("img/flyerBDHolder.jpg");
	
		}
	//detail news
	
		$detail = $singlePost->find('.article-text');
		$txt_2="";
		foreach($detail as $elemet3)
		{
			$Dtl_beta1=$elemet3->plaintext;
			$txt_2.=$Dtl_beta1;
		}
		$txt_beta2=preg_replace("/&#?[a-z0-9]{2,8};/i","", $txt_2);
		$txt=base64_encode($txt_beta2);
		$temparr= array('url'=>$link, 'id' => $counter,'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
		array_push($AllContent, $temparr);
		$counter++;
		
	}

}
$fp = fopen('foxNews.json', 'w');
fwrite($fp,json_encode($AllContent));
fclose($fp);
?>