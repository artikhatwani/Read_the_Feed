<!DOCTYPE html>
<?php session_start(); ?>
<html>
    <head>

        <title>Read the Feed</title>


        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="css/prettify.css">
        <link rel="stylesheet" type="text/css" href="css/metro.css">


        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.transit.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/prettify.js"></script>
        <script type="text/javascript" src="js/metro.js"></script>



        <style type="text/css">
            body {
                background-color: #3A3A3A;
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
        $htmlData = "";
        $title = array();
        $image = array();
        $description = "";
        $link = array();

        if (isset($_POST['url']) || isset($_GET['url'])) {
            if (isset($_POST["url"])) {
                $url = $_POST["url"];
            } else {
                $url = $_GET["url"];
            }

            require_once("class.Rss.php");
            $rssObj = new Rss();
            $GLOBALS['valid'] = $rssObj->validateFeed($url);
            $_SESSION['valid'] = json_encode($GLOBALS['valid']);
            if ($GLOBALS['valid'] == true) {
                $whole = $rssObj->readFeed($url);

                $GLOBALS['htmlData'] = $whole[0];

                $GLOBALS['title'] = $whole[1];

                $GLOBALS['image'] = $whole[2];

                $GLOBALS['description'] = $whole[3];

                $GLOBALS['link'] = $whole[4];

                $size = sizeof($GLOBALS['title']);
                for ($i = 0; $i < $size; $i++) {

                    $GLOBALS['titles'][$i]=utf8_encode($GLOBALS['title'][$i]);
                }

                $_SESSION['htmlData'] = $GLOBALS['htmlData'];
                $_SESSION['title'] = json_encode($GLOBALS['titles']);

                $_SESSION['image'] = json_encode($GLOBALS['image']);
                $_SESSION['description'] = json_encode($GLOBALS['description']);
                $_SESSION['link'] = json_encode($GLOBALS['link']);
                ?>

                <!-- body of elements -->

<div class="container-fluid" align="center">
                        <div class="metro">
                            <div class="metro-sections">
                                 <div class="metro-section" >
                                     
                                     <table>
                <?php
               
                $size = sizeof($title);
                for ($i = 0; $i < $size; $i++) {
                    if ($i % 2 == 0) {

                        echo '<tr><td>
                                <div class="tile tile-quadro tile-multi-content bg-color-blue ">
                            <div class="tile-content-main">
                                <div style="padding: 10px;">
                                 
                                    <img src="' . $image[$i] . '" style="height:100px;width:100px;margin-top:35px;margin-right: 20px" class="place-left" />
                           
                                         <div style="margin-left: 115px; margin-top: 10px">
                                        
                                     
                                        <p style="font-size:20px;margin-top:50px">'.$title[$i].'</p>
                                        
                                    </div>
                                </div>
                                <span class="tile-label"></span>
                            </div>
                            <div style="font-size:16px;" class="tile-content-sub bg-color-blueDark ">' . $description[$i] . '.....</div></div>
                         </td><td> <div> <a href="' . $link[$i] . '" style="color:white;" target="_blank">Read More </a></div><td></tr>
                           ';// div for container fluid
                    } else {
                        echo ' <tr><td>
                              <div class="tile tile-quadro tile-multi-content bg-color-green">
                            <div class="tile-content-main">
                                <div style="padding: 10px;">
                                 
                                    <img src="' . $image[$i] . '" style="height:100px;width:100px;margin-top:35px;margin-right: 20px" class="place-left" />
                           
                                         <div style="margin-left: 115px; margin-top: 10px">
                                       
                                     
                                        <p style="font-size:20px; margin-top:50px">'.$title[$i].'</p>
										
                                    </div>
                                </div>
                               
                            </div>
                            <div style="font-size:16px;" class="tile-content-sub bg-color-greenDark ">' . $description[$i] . '.....
                            </div></div></td><td> <div> <a href="' . $link[$i] . '" style="color:white;" target="_blank">Read More </a></div></td></tr>
                     ';
                    }
                }
                ?></table>
                                    </div>                     
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

            <div class="container" id="containerDiv">
                <div  class="metro">
                    <div class="metro-sections">
                        <div class="metro-section">
                             <table>
                            
                            <?php
                            $title = json_decode($_SESSION['title']);
                            $image = json_decode($_SESSION['image']);
                            $htmlData = json_decode($_SESSION['htmlData']);
                            $desc = json_decode($_SESSION['description']);
                            $link =json_decode($_SESSION['link']);
                            
                            $size = sizeof($title);
                            for ($i = 0; $i < $size; $i++) {
                                if ($i % 2 == 0) {
                                    echo '<tr><td><div class="tile tile-quadro tile-multi-content bg-color-blue ">
                            <div class="tile-content-main">
                                <div style="padding: 10px;">
                                    <img src="' . $image[$i] . '" style="height:100px;width:100px;margin-top:35px;margin-right: 20px" class="place-left" />
                                         <div style="margin-left: 115px; margin-top: 10px">
                                          <p style="font-size: 20px; margin-top: 50px">' . $title[$i] . '</p>
                                    </div>
                                </div>
                          </div>
                    <div style="font-size:16px;" class="tile-content-sub bg-color-blueDark ">' . $desc[$i] . '.....</div></div></td>
                        <td> <div><a href="'.$link[$i].'" style="color:white;" target="_blank">Read More</a></div></td></tr>';
                                } else {
                                    echo '<tr><td><div class="tile tile-quadro tile-multi-content bg-color-green">
                            <div class="tile-content-main">
                                <div style="padding: 10px;">
                                    <img src="' . $image[$i] . '" style="height:100px;width:100px;margin-top:35px;margin-right: 20px" class="place-left" />
                                     <div style="margin-left: 115px; margin-top: 10px">
                                      <p style="font-size: 20px; margin-top: 50px">' . $title[$i] . '</p>
                                    </div>
                                </div>
                           
                            </div>
                          <div style="font-size:16px;" class="tile-content-sub bg-color-greenDark">' . $desc[$i] . '....</div></div></td><td> <div> <a href="' . $link[$i] . '" style="color:white;" target="_blank">Read More </a></div></td></tr>';
                                }
                            }
                            ?>
                             </table>
                        </div>
                    </div>
                </div>
            </div> 
        
        <?php }
        ?>


        <?php
        $valid = json_decode($_SESSION['valid']);
        if ($valid == true) {
            ?>
            <a href="slideshow.php">
                <div class="tile-vertical bg-color-purple" style="height:200px;width:200px;position:fixed;right:30px;top:300px">
                    <div class="tile-icon-large" style="width:100px;position:fixed;right:80px;top:350px;">
                        <img src="images/slideshow.jpg" />
                    </div>
                    <span class="tile-label" style="position:fixed;top:460px;right:65px;color:black;font-size:22px;"><b>Slide Show</b></span>
                </div></a>
        <?php } ?>

        <script type="text/javascript">
            $(function(){
                window.prettyPrint && prettyPrint();
            })

            $(".metro").metro();
            

        </script>

        
  <footer>
    <hr style="background-color: black;">
    <p class="pull-right" style="margin-right:10px"><a target="_blank" href="http://in.linkedin.com/pub/arti-khatwani/70/b94/392" style="color:white">By Alph@</a></p>

            <p class="body-text" style="color:black;font-size:13px; margin-left:65px;">Rss Feeds Reader</p>
  </footer>
      
    </body>
</html>