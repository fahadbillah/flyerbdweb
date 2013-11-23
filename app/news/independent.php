<?php 
include("simple_html_dom.php");

// Retrieve the DOM from a given URL
$html = file_get_html('http://www.theindependentbd.com');
$html2 = file_get_html('http://www.theindependentbd.com/index.php?option=com_content&view=category&layout=blog&id=95&Itemid=141');

$allLink = array();
$AllContent = array();

// for new links
foreach($html->find('.latestnews_tab li a')  as $e)
{
	$pos = "http://www.theindependentbd.com".$e->href;
	array_push($allLink, $pos);
}


foreach($html->find('.gk_news_intro_title a')  as $e)
{
	$pos = "http://www.theindependentbd.com".$e->href;
	array_push($allLink, $pos);
}


foreach($html2->find('.title a')  as $e)
{
	$pos = "http://www.theindependentbd.com".$e->href;
	array_push($allLink, $pos);
}


foreach($html2->find('.morearticles li a')  as $e)
{
	$pos = "http://www.theindependentbd.com".$e->href;
	array_push($allLink, $pos);
}
$allLink=array_unique($allLink);
$counter = 1;
foreach ($allLink as $link)
{
	$singlePost = file_get_html($link);

	//the title
	$title = $singlePost->find('.title');
	foreach($title as $e)
	{
		$newsTitle=$e->plaintext;
		$newsTitle_beta2= preg_replace("/&#?[a-z0-9]{2,8};/i","", $newsTitle);
		$newsTitle=base64_encode($newsTitle_beta2);
	}

	//news image
	$image = $singlePost->find('.article img');
	$Ztest="";
	/*if ($Ztest>0)
		{*/
			foreach($image as $elemet4)
			{
				$pic2=$elemet4->src;
				if (strpos($pic2, "/stories"))
				{
					if (strpos($pic2, "www"))
					{
						$Ztest.=$pic2;
						break;
					}
					else
					{
						$pic2= "http://www.theindependentbd.com".$pic2;
						$Ztest.=$pic2;
						break;
									}
					//$pic=base64_encode($pic);
				}

			}
	
	if (strlen($Ztest)>2)
	{
		$pic=base64_encode($Ztest);
	}

	else
	{
		$pic=base64_encode("img/flyerBDHolder.jpg");
	}

	//news detail
	$detail = $singlePost->find('.article p[style="text-align: justify;"], :not(".author")');
	$detail2 = $singlePost->find('.article p, :not(".author")');
	$txt="";
	if($detail==0)
		{
			
			foreach($detail as $elemet3)
			{
				$dtl=$elemet3->plaintext;
				$txt.=$dtl;
			}
		}

	else
		{

			foreach($detail2 as $elemet3)
			{
				$dtl=$elemet3->plaintext;
				$txt.=$dtl;
			}
		}
	/*$txt=preg_replace("/&#?[a-z0-9]{2,8};/i","", $txt);
	$txt=base64_encode($txt);*/
	$cut=strpos($txt, ":");
	$cut2=substr($txt, 0,$cut+1);
	$txt=str_replace($cut2,"",$txt);
	$txt=preg_replace("/&#?[a-z0-9]{2,8};/i","", $txt);
	$txt=base64_encode($txt);

	/*$cut=strpos($txt, "PoorBest");
	$cut2=substr($txt, 0,$cut+strlen("PoorBest"));
	str_replace($cut2, "", $txt);
	echo $txt;
	$txt=str_replace($cut2,"",$txt);
	$txt=preg_replace("/&#?[a-z0-9]{2,8};/i","", $txt);
	$myBreak=strpos($txt, "Author");
	$txt = substr($txt, 0, $myBreak)."\r\n".substr($txt, $myBreak);
	$txt=nl2br($txt);*/
	
	
	//array for json
	$temparr= array('id'=>$counter, 'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
	array_push($AllContent, $temparr);
	$counter++;
		
}
// ultimate json writing
$fp = fopen('independent.json', 'w');
fwrite($fp,json_encode($AllContent));
fclose($fp);
?>	
