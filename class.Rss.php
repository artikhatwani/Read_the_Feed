<?php

class Rss {
    /*     * *************Declaring Variables*************** */

    public $title = array();
    public $image = array();
    
    public $whole = '<html><body>';
    public $description="";
	public $sub=array();
	public $link="";
        public $url="";

    /*     * ********************************************** */

    public function validateFeed($sFeedURL) {
      
        $sValidator = 'http://feedvalidator.org/check.cgi?url=';

        if ($sValidationResponse = @file_get_contents($sValidator . urlencode($sFeedURL))) {
            if (stristr($sValidationResponse, 'This is a valid RSS feed') !== false) {
                
           $matches=array();
           $myURL = $sValidator.$sFeedURL;
if (preg_match(
        '/<title>(.+)<\/title>/',
        file_get_contents($myURL),$matches) 
    && isset($matches[1] ))
   $title=$matches[1];
else
   $title = "Not Found";
   
  
   $url=substr($title,23);
   
                 return array(true,$url);
              
            } else {
                return array(false,"");
            }
        } else {
            return false;
        }
    }

    public function readFeed($url) {
       // $xml = simplexml_load_file($url);
        //$xmlString = file_get_contents($url);
        $xml = new SimpleXMLElement($url,null,true);
        $doc = new DOMDocument();
        //Read XML feed
        for ($i = 0; $i < 10; $i++) {
            if (empty($xml->channel->item[$i]->title)) {
                break;
            }
            $title[$i] = $xml->channel->item[$i]->title;
           
            $title[$i] = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $title[$i]);
          

            $title[$i] = htmlspecialchars($title[$i], ENT_QUOTES);
            $content = $xml->channel->item[$i]->children("content", true);
            $description=$xml->channel->item[$i]->description;
                
// $description[$i] = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $description[$i]);
           //$description[$i] = htmlspecialchars($description[$i], ENT_QUOTES);
			$sub[$i]=substr($description,0,340);
			$link[$i]=$xml->channel->item[$i]->link;
                         $link[$i] = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $link[$i]);
                         $link[$i] = htmlspecialchars($link[$i], ENT_QUOTES);
           
                         @$doc->loadHTML($content);
            $tags = $doc->documentElement->getElementsByTagName('img');

            if ($tags->length == 0) { //If no image is found


                $image[$i] = "images/noimage.png";
            }

            foreach ($tags as $tag) {
                $image[$i] = $tag->getAttribute('src');

                break;
            }
        }

          

        return array($title,$image,$sub,$link);
    }
public function resizeImage($title,$image)
{
    ini_set('max_execution_time', 400);
    foreach(glob('Image_*') as $file)
    {  if(is_file($file))
     unlink($file);
    }
    
    $size=sizeof($title);
    for($i=0;$i<$size;$i++)
    {
    $image[$i]=str_replace("https", "http", $image[$i]);
   // echo $image[$i];
    $imagesize=getimagesize($image[$i]);
    $type=$imagesize['mime'];
    $image_width=$imagesize[0];
    $image_height=$imagesize[1];
    $new_width=150;
    $new_height=150;
    $new_image = imagecreatetruecolor($new_width, $new_height);
    
     if($type == "image/jpeg") {
		
		$old_image=imagecreatefromjpeg($image[$i]);
	
	} elseif($type == "image/png") {
		
		$old_image = imagecreatefrompng($image[$i]);
	} elseif($type == "image/gif"){
	
		$old_image = imagecreatefromgif($image[$i]);
	}
  imagecopyresized($new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
if($type == "image/jpeg") {
		imagejpeg($new_image,'Image_'.$i.'.jpeg');
                $image[$i]='Image_'.$i.'.jpeg';
	} else if($type == "image/png"){
		imagepng($new_image,'Image_'.$i.'.png');
               $image[$i]='Image_'.$i.'.png';
	}
	else
	{
	imagegif($new_image,'Image_'.$i.'.gif');
         $image[$i]='Image_'.$i.'.gif';
	}
  
  
}

 $whole = '<html><body>';
        for ($i = 0; $i < $size; $i++) {
            $whole = $whole . '<table style="page-break-after: always;"><tr><td><h2>' . $title[$i] . '</h2></td></tr><tr><td><img src="' . $image[$i] . '" /></td></tr></table>';
        }
        $whole.="</body></html>";
        
        return array($whole,$image);
}
}
?>