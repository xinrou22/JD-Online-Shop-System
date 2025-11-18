<?php
session_start();
include("connect/config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>About us</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">

  <!--page-icon------------>
  <link rel="shortcut icon" href="images/pg-logo.png">

  <style>
    *{
      margin: 0px;
      padding: 0px;
      box-sizing: border-box;
      font-family: 'Quicksand', sans-serif;
    }
    body{
      background-color: #ffff;
    }
    .heading{
      width:90%;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      text-align: center;
      margin: 20px auto;
    }
    .heading h1{
      font-size: 50px;
      color:#000;
      margin-bottom: 25px;
      position: relative;
    }
    .heading h1::after{
      content: "";
      position: absolute;
      width: 100%;
      height: 4px;
      display: block;
      margin: 0 auto;
      background-color: #8b2c50;
    }
    .heading p{
      font-size: 18px;
      color:#666;
      margin-bottom: 35px;
    }
    .container{
      width: 90%;
      margin: 0 auto;
      padding:10px 20px;
    }
    .about{
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      box-align: center;
    /*padding:20px;
    */
    }
    .about-image{
      flex: 1;
      margin-right: 40px;
      overflow: hidden;
      /* margin bottom added by Josh on 21/6/2024*/
      margin-bottom: 40px;
    }
    .about-image img{
      max-width: 80%;
      height: auto;
      display: block;
      float: right;
/*      transition: 0.5s ease;*/
    }
/*    .about-image:hover img{
      transform:scale(1.2);
    }*/
    .about-content{
      flex:1;
    }
    .about-content h2{
      font-size: 23px;
      margin-bottom: 15px;
      color: #333;
    }
    .about-content p{
      font-size: 18px;
      line-height: 1.5;
      color: #666;
    }
    .about-content .read-more{
      display: inline-block;
      padding: 10px 20px;
      /*background-color: #8b2c50;*/
      background: #000000;
      color: #fff;
      font-size: 19px;
      text-decoration: none;
      border-radius: 25px;
      margin-top: 15px;
      transition: 0.3s ease;
    }
    .about-content .read-more:hover{
      /*background-color: #c94f4f;*/
      opacity: 0.7;
    }
    @media screen and (max-width: 768px){
      .heading{
        padding:0px 20px;
      }
      .heading h1{
        font-size: 36px;
      }
      .heading p{
        font-size: 17px;
        margin-bottom: 0px;
      }
      .container{
        padding: 0px;
      }
      .about{
        padding: 20px;
        flex-direction: column;
      }
      .about-image{
        margin-right: 0px;
        margin-bottom: 20px;
      }
      .about-content p{
        padding: 0px;
        font-size: 16px;
      }
      .about-content .read-more{
        font-size: 16px;
      }
    }
  </style>
</head>
<body>
  <?php include 'nav-footer/nav.php'; ?>
  <div class="heading">
    <h1>About Us</h1>
    <p>An exclusieve website just to sell overpriced collectible shoes, because why not?</p>
  </div>
  <div class="container">
    <section class="about">
      <div class="about-image">
        <img src="images/aboutus_new.jpg">
      </div>
      <div class="about-content">
        <h2>Purchase your collectible shoes here!</h2>
        <!--<p>Welcome to our website! We are a company that manufactures and sells different types of sports shoes.</p>-->

        <!--Paragraph below written by Josh on 21/6/2024-->
        <p>Welcome to JD Shop! Where we sell collectible shoes, mainly in the sports realm. For each month we'll release a new design with a limited quantity amount. Our shoes are designed with emphasize on asthetics, functionality and scarcity.</p>

        <p>You can only get these shoes exclusively on this website by signing up to become a member and make a purchase here!</p>

        <p>Disclaimer: This website is a fake website. This website is by no means a “full project proposal”. It has been simplified and customized for the purposes of SWE20001 teaching. All of the names listed in the report are hypothetical scenarios for academic purposes only.</p>

        <!--<a href="" class="read-more">Read More</a>-->
        <!-- read more button removed by josh (29/5/2024)-->
      </div>
    </section>
  </div>
  <?php include 'nav-footer/footer.php'; ?>
  <?php include 'nav-footer/alert-js.php'; ?>
</body>
</html>
