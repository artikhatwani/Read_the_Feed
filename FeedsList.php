<!DOCTYPE html>
<?php session_start(); ?>
<html>
    <head>

        <title>Read the Feed</title>


        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="css/prettify.css">
        <link rel="stylesheet" type="text/css" href="css/metro.css">
        <link rel="stylesheet" type="text/css" href="css/mycss.css">

        <script type="text/javascript" src="lib/js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="lib/js/jquery.transit.js"></script>
        <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="lib/js/bootstrap.js"></script>
        <script type="text/javascript" src="lib/js/prettify.js"></script>
        <script type="text/javascript" src="lib/js/metro.js"></script>



        <style type="text/css">
            body {
                background-color:#FFFFFF;
            }
            td{
                vertical-align: bottom;
                text-decoration: underline;

            }
            
        </style>
    </head>
    <body>

        <?php include("header.html"); ?>


        <?php
         ini_set('max_execution_time',600);
        $htmlData = "";
        $title = array();
        $image = array();
        $description = "";
        $link = array();
        $data=array();

        if (isset($_GET['url'])) {
           
                $url = $_GET["url"];
            
             
            require_once("class.Rss.php");
            $rssObj = new Rss();
            $dir='images/thumbnails/';
           $rssObj->recursiveDelete($dir);
           
            $GLOBALS['valid'] = $rssObj->validateFeed($url);
           $return = $rssObj->validateFeed($url);
            
            $GLOBALS['valid']=$return[0];
            $url=$return[1];
            
            
            $url=trim($url);
            
            $_SESSION['valid'] = json_encode($GLOBALS['valid']);
            if ($GLOBALS['valid'] == true) {
                $whole = $rssObj->readFeed($url);
                
                $data=$rssObj->resizeImage($whole[0],$whole[1]);
                
               // $GLOBALS['htmlData'] = $whole[0];

                $GLOBALS['title'] = $whole[0];
               
                $htmlData=$data[0];
                $_SESSION['htmlData']=$htmlData;
                 $GLOBALS['image'] = $data[1];


                $GLOBALS['description'] = $whole[2];

                $GLOBALS['link'] = $whole[3];
//                $GLOBALS['ses_id']=session_id();
                $size = sizeof($GLOBALS['title']);
                for ($i = 0; $i < $size; $i++) {

                    $GLOBALS['titles'][$i] = utf8_encode($GLOBALS['title'][$i]);
                }

             //   $_SESSION['htmlData'] = $GLOBALS['htmlData'];
                $_SESSION['title'] = json_encode($GLOBALS['titles']);
                // $_SESSION['sessiontitle']=json_encode($GLOBALS['title']);
                $_SESSION['image'] = json_encode($GLOBALS['image']);
                $_SESSION['description'] = json_encode($GLOBALS['description']);
                $_SESSION['link'] = json_encode($GLOBALS['link']);
                ?>

                <!-- body of elements -->
                <div class="container-fluid">
                 <div class="row-fluid">
                  <div class="span2"></div>
                  <div class="span6">
                      <div class="wrapper" style="padding:5px;margin:5px;"><a href="generatePDF.php"><button type="button" name="fat-btn" id="fat-btn" class="btn btn-primary container span3" data-loading-text="Downloading...">Download</button></a>
          <a href="slideshow.php" style="padding:5px;margin: 5px;"><button type="button" class="btn btn-primary pull-right span3">Slide Show</button></a><br></div><br>             
 <?php
                      
                $size = sizeof($title);
              
                for ($i = 0; $i < $size; $i++) {

                   echo '<div class="media thumbnail">
              <a class="pull-left" href="Slider.php">
                <img class="media-object img-polaroid" data-src="holder.js/64x64" alt="64x64" src="'.$image[$i].'" style="width: 64px; height: 64px;">
              </a>
              <div class="media-body">
               <a href="'.$link[$i].'" target="_blank"> <h4 class="media-heading">'.$title[$i].'</h4></a>
              <p>'.$description[$i].'.....</p>         
          </div>
            </div>
                                ';
                }
                ?>
                      </div>
                  </div>
</div>

                <?php
            } else {
                ?>      
                <div class="span7">
                    <div class="metro-reply bg-color-red" style="position:absolute;right:500px;top:200px;">
                        <a class="close" data-dismiss="alert" href="#">&times;</a>

                        <div class="pull-left"><img src="images/SecurityDenied.png" style="height:100px;width:100px;" /></div>


                        <div class="text pull-right" style="font-size:20px ;margin-top:35px;">You entered an invalid URL.Please Enter a Valid URL.</div>                       


                    </div>
                </div>



                <?php
            }
        } else if (!empty($_SESSION['title']) || isset($_SESSION['title'])) {
            ?>


            <!--Sidebar content-->
<div class="container container-fluid">
    <div class="row-fluid">
        <div class="span2"></div>
            <div class="span6">
                <div class="wrapper"><a href="generatePDF.php"><button type="button" name="fat-btn" id="fat-btn" class="btn btn-primary container span3" data-loading-text="Downloading...">Download</button></a>
          <a href="Slider.php"><button type="button" class="btn btn-primary pull-right span3">Slide Show</button></a><br></div><br>               
                    <?php
            $title = json_decode($_SESSION['title']);

            $image = json_decode($_SESSION['image']);
            $htmlData = json_decode($_SESSION['htmlData']);
            $desc = json_decode($_SESSION['description']);
            $link = json_decode($_SESSION['link']);

            $size = sizeof($title);
            for ($i = 0; $i < sizeof($title); $i++) {
                $title[$i] = utf8_decode($title[$i]);
            }
            for ($i = 0; $i < $size; $i++) {
                echo '<div class="media thumbnail">
              <a class="pull-left" href="Slider.php">
                <img class="media-object img-polaroid" data-src="holder.js/64x64" alt="64x64" src="'.$image[$i].'" style="width: 64px; height: 64px;" >
              </a>
              <div class="media-body">
               <a href="'.$link[$i].'" target="_blank"> <h4 class="media-heading">'.$title[$i].'</h4></a>
              <p>'.$desc[$i].'....</p>         
          </div> </div>';
            }
            ?>
</div>
<div class="span4"></div>
    </div>
                </div>
            <!--Body content-->  
        <?php }
        ?>

        <script type="text/javascript">
            $(function(){
                window.prettyPrint && prettyPrint();
            })

            $(".metro").metro();
            $('#fat-btn').click(function () {
                var btn = $(this)
                btn.button('loading')
                setTimeout(function () {
                btn.button('reset')
            }, 9000)
   });

        </script>




    </body>
</html>