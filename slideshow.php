<!DOCTYPE html>
<html> 
    <script type='text/javascript' src='js/jquery.js'></script>
    <?php
    session_start();

    $title = json_decode($_SESSION['title']);
    
    for ($i = 0; $i < sizeof($title); $i++) 
    {
        $title[$i] = utf8_decode($title[$i]);
    }

    $image = json_decode($_SESSION['image']);
    $htmlData = $_SESSION['htmlData'];
   
    ?>


    <head> 
        <!-- for metro ui-->
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="css/prettify.css">
        <link rel="stylesheet" type="text/css" href="css/metro.css">
        <link rel="stylesheet" type="text/css" href="css/site.css">

        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.transit.js"></script>
        <script type="text/javascript" src="js/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="js/jquery.scrollTo.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/prettify.js"></script>
        <script type="text/javascript" src="js/metro.js"></script>
        <script type="text/javascript" src="js/site.js"></script>
        <script type="text/javascript" src="js/google-analytics.js"></script>     

        <!-- for metro ui-->

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" > 
        <title>Rss Feed Reader</title> 
        <!--///////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //		Styles
        //
        ///////////////////////////////////////////////////////////////////////////////////////////////////--> 
        <link rel='stylesheet' id='camera-css'  href='css/camera.css' type='text/css' media='all'> 

        <style>
            body {
                background-color: #3A3A3A;
                margin: 0;
                padding: 0;
            }
            #back_to_camera {

                clear: both;
                display: block;
                height: 80px;
                line-height: 40px;
                padding: 20px;
            }
            .fluid_container {
                margin: 0 auto;
                max-width: 1000px;
                width: 90%;
            }
        </style>

        <!--///////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //		Scripts
        //
        ///////////////////////////////////////////////////////////////////////////////////////////////////--> 

        <script type='text/javascript' src='js/jquery.min.js'></script>
        <script type='text/javascript' src='js/jquery.mobile.customized.min.js'></script>
        <script type='text/javascript' src='js/jquery.easing.1.3.js'></script> 
        <script type='text/javascript' src='js/camera.min.js'></script> 


        <script>
              
            jQuery(function(){
			 
                jQuery('#camera_random').camera({
                      
                    thumbnails: false,
                    fx: 'simpleFade',
                    hover:false
                });
           
            });
			
        </script>


    </head>
    <?php include("header.html");
    ?>
    <div class="container-fluid">
        <div class="row-fluid">

            <div id="slideshow" class="fluid_container" style="">
                <div class="camera_wrap camera_black_skin" id="camera_random">
                    <?php
                    $size = sizeof($title);
                    for ($i = 0; $i < $size; $i++) {
                        echo '<div class="cameraSlide topToBottom" data-portrait="' . $image[$i] . '" data-src="' . $image[$i] . '">
			<div class="camera_caption moveFromLeft">
                    ' . $title[$i] . '<em> </em>
                </div>
              </div>';
                    }
                    ?>
                </div><!-- #camera_random -->
            </div><!-- .fluid_container -->
              <div class="tile tile-vertical bg-color-darken" style="float:right;right:85px;top:350px;height:100px;width:160px;position:fixed;">
            <div class="" id="download" style="float:right;position:fixed;right:60px;width:160px;">
                <div class="tile-icon-large"  style="width:90px;margin-left:9px;position:fixed;margin-top:7px">
                    <a href="generatePDF.php"><img src="images/pdf.jpg" /></a>
                </div>
            </div>
            </div>
            <div class="tile bg-color-darken" style="height:100px;width:160px;position:fixed;top:350px;">
                <div class="tile-icon-large"  style="width:130px;margin-left: 12px;position:fixed;margin-top:20px">
                    <a href="FeedsList.php"><img src="images/goback.jpg" /></a> 
                </div>
                <span class="tile-label" style="font-size:20pt;position:fixed;"></span>
            </div> 

            <!-- back tile ends-->
            <div style="clear:both; display:block; height:100px"></div>	

        </div>
    </div>
     <footer>
    <hr style="background-color: black;">
    <p class="pull-right" style="margin-right:10px"><a target="_blank" href="http://in.linkedin.com/pub/arti-khatwani/70/b94/392" style="color:white">By Alph@</a></p>

            <p class="body-text" style="color:black;font-size:13px; margin-left:65px;">Rss Feeds Reader</p>
  </footer>

</html>