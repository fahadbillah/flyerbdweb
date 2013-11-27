<?php 
include("simple_html_dom.php");

// Retrieve the DOM from a given URL
$html = file_get_html('http://bangla.bdnews24.com/');
//$c = 0;
$allLink = array();
$AllContent = array();


// Find all "A" tags and print their HREFs

// Find all SPAN tags that have a class of "myClass"
foreach($html->find('.list li a')  as $e){
	$pos = $e->href;
    	//$rest = substr($e->href, 0, $pos);
	//echo $rest."<br>";
	array_push($allLink, $pos);
    	//echo $pos;
    	//echo "<br>";
}
$allLink = array_unique($allLink);
$counter = 1;
foreach ($allLink as $links)
{	

	$singlePost = file_get_html($links);
	$newsTitle_beta1 = $singlePost->find('.print-only');
	$newsTitle_beta2 =$newsTitle_beta1[0]->plaintext; // important checkpoint
	$newsTitle_beta3=preg_replace("/&#?[a-z0-9]{2,8};/i","", $newsTitle_beta2);
	$newsTitle=base64_encode($newsTitle_beta3);
	//echo "<br>";
	//echo $newTitle;

//image
	$image1 = $singlePost->find('.inline-image img');
	$image2 = $singlePost->find('.gallery-image-box img');
	$Ztest_img1= count($image1);
	$Ztest_img2= count($image2);
	if ($Ztest_img1>0)
		{   foreach($image1 as $element1)
			{

				$pic = base64_encode($element1->src); // important checkpoint
               //global $pic;
               //var_dump($pic);
               //echo "<br> ";
				break;
			}
		}

		elseif ($Ztest_img2>0) {
		# code...
			foreach($image2 as $element2)
			{

				$pic = base64_encode($element2->src); // important checkpoint
               //global $pic;
               //var_dump($pic);
				//echo "<br>";
				//echo $pic;
				break;
			}
		}



		else
		{
			// import checkpoint
			$pic = base64_encode("img/flyerBDHolder.jpg");

		}
//detail

		$detail1 = $singlePost->find('h5');
		$finalText="";
		$txt1= $detail1[0]->plaintext;
		$finalText.=$txt1;
		$detail2 = $singlePost->find('.wrappingContent p');
		foreach($detail2 as $i){
			$txt2= $i->plaintext;
			$finalText.=$txt2;
		}
		$txt_beta=preg_replace("/&#?[a-z0-9]{2,8};/i","", $finalText);
		$txt=base64_encode($txt_beta); // important checkpoint
		$temparr= array('url'=>$link, 'id' => $counter, 'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
		//echo $newsTitle."<br>";
		//echo $pic."<br>";
		//echo $txt."<br>";
		//break;
		array_push($AllContent, $temparr);
		$counter++;
	}

	$fp = fopen('BDNews24.json', 'w');
	fwrite($fp,json_encode($AllContent));
	fclose($fp);
	?>