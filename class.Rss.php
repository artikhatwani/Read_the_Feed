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
      
    //public $ses_id=session_id();
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
			$sub[$i]=substr($description,0,150);
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
    
    $unique=  uniqid();
   $folder_path='images/thumbnails/'.$unique.'/';
  
    $dir=mkdir('images/thumbnails/'.$unique.'/',0777);
  
    $finalimage=array();
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
	       }
               elseif($type == "image/png") {
		
		$old_image = imagecreatefrompng($image[$i]);
        	} elseif($type == "image/gif"){
	
		$old_image = imagecreatefromgif($image[$i]);
	        }
                imagecopyresampled($new_image,$old_image, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
        
         if($type == "image/jpeg") {
               if($dir==true)
               {
                 imagejpeg($new_image,$folder_path.$i.'.jpeg',100);  
                 $finalimage[$i]=$folder_path.$i.'.jpeg';
               }
               else{
		   imagejpeg($new_image,$unique.'_'.$i.'.jpeg',100);
               }
              
	} else if($type == "image/png"){
		
		      
              if($dir==true)
               {
                 imagepng($new_image,$folder_path.$i.'.png',9);  
                 $finalimage[$i]=$folder_path.$i.'.png';
               }
               else{
		   imagejpeg($new_image,$unique.'_'.$i.'.png',9);
               }
	}
	else
	{
                  
		  
                  if($dir==true)
               {
                 imagegif($new_image,$folder_path.$i.'.gif'); 
                 $finalimage[$i]=$folder_path.$i.'.gif';
               }
               else{
		    imagegif($new_image,$unique.'_'.$i.'.gif');
               }
       
	}
  
  
}

 $whole = '<html><body>';
        for ($i = 0; $i < $size; $i++) {
            //combinig data for pdf
            $whole = $whole . '<table style="page-break-after: always;"><tr><td><h2>' . $title[$i] . '</h2></td></tr><tr><td><img src="'.$finalimage[$i].'" /></td></tr></table>';
      
            //saving images in a file
            
 
            }
        $whole.="</body></html>";
        
        
    return array($whole,$finalimage);
}
function rrmdir($dir) { 
  foreach(glob($dir . '/*') as $file) { 
    if(is_dir($file)) rrmdir($file); else unlink($file); 
  } rmdir($dir); 
}
}
?>