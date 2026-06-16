<?php
session_start();
require_once '../inc/auth.php';
require_auth();
require_perfil();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_once 'inc/head.php'; ?>
  </head>
  <body>
    <header id="header">
      <?php include_once 'inc/header.php'; ?>
    </header>
    <?php include_once 'inc/nav.php'; ?>
    <!-- <section id="paginado"></section> -->
    <div class="slider_container">
      <div class="flexslider">
          <ul class="slides">
          <li>
            <a><img src="../view/imagenes/logoIMU.png" height="500"  width="900" alt="" title=""/></a>
          </li>
          <!-- <li>
            <a href="http://www.freshdesignweb.com"><img src="view/images/slider/slide2.jpg" alt="" title=""/></a>
            <div class="flex-caption">
              <div class="caption_title_line"><h2>Beautiful Hairstyle</h2><p>The latest hairstyles and instructions on how to create them here. Total Beauty has your complete hairstyles guide</p></div>
            </div>
          </li>
          <li>
            <a href="http://www.freshdesignweb.com"><img src="view/images/slider/slide3.jpg" alt="" title=""/></a>
            <div class="flex-caption">
              <div class="caption_title_line"><h2>Party Dresses</h2><p>If you are looking for something a little special for your big night out, check out Rare London's collection of stunning party dresses</p></div>
            </div>
          </li>
          <li>
            <a href="http://www.freshdesignweb.com"><img src="view/images/slider/slide4.jpg" alt="" title=""/></a>
            <div class="flex-caption">
              <div class="caption_title_line"><h2>Bodycon Dresses</h2><p>The bodycon dress is a key silhouette for this season's party girl; from sleek colour-block panelling to geometric prints the bodycon.</p></div>
            </div>
          </li> -->
        </ul>
      </div>
    </div>
    <?php include_once 'inc/script-lib.php'; ?>
  </body>
</html>
