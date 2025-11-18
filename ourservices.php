<?php
session_start();
include("connect/config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Our Services</title>
	<link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">

  <!--page-icon------------>
  <link rel="shortcut icon" href="images/pg-logo.png">

  <style>
    *{
      margin: 0px;
      padding: 0px;
      box-sizing: border-box;
      font-family: sans-serif;
    }
    body {
      background-color: #fff;
      width:100%;
    }
    .title h1{
      text-align: center;
      padding-top: 50px;
      font-size: 42px;
    }
    .title h1::after{
      content:"";
      height: 4px;
      width:230px;
      background-color: #0000;
      display: block;
      margin: auto;
      background-color: #8b2c50
    }
    .services{
      width:85%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 75px auto;
      text-align: center;
    }
    .card{
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-direction: column;
      margin: 0px 20px;
      padding: 20px 20px;
      background-color: #25262b;
      border-radius: 10px;
      cursor: pointer;
    }
/*    .card:hover{
      background-color: #b8d4de;
      transition: 0.4s ease;
    }*/
    .card .icon img{
      font-size: 35px;
      margin-bottom: 10px;
      width: 50px;
      height: 50px;
    }
    .card h2{
      font-size: 28px;
      color: #333;
      /*color:#fff;*/
      /* text color changed back to black */
      margin-bottom: 20px;
    }
    .card p{
      font-size: 17px;
      margin-bottom: 30px;
      line-height: 1.5;
      color:#666;
    }
    .button{
      font-size: 15px;
      text-decoration: none;
      background: #000000;
      color: #fff;
      padding: 8px 12px;
      border-radius: 5px;
      letter-spacing: 1px;
    }
    .button:hover{
      /*background-color: #c94f4f;*/
      /*transition: 0.4s ease;*/
      opacity: 0.7;
      color: #fff;
    }
    @media screen and (max-width: 940px){
      .services{
        display: flex;
        flex-direction: column;
      }
      .card{
        width: 85%;
        display: flex;
        margin: 20px 0px;
      }
    }
  </style>
</head>
<body>
  <?php include 'nav-footer/nav.php'; ?>
  <div class="section">
    <div class="title">
      <h1>Our Services</h1>
    </div>
    <div class="services">
      <div class="card">
        <div class="icon">
          <!--<i class="fas fa-calendar"></i>-->
          <img src="https://cdn-icons-png.freepik.com/512/6012/6012938.png?ga=GA1.1.533706336.1716097836">
        </div>
        <h2>Online Purchases</h2>
        <p>In layman's term, anyone that is interested in buying limited design shoes can register as a member, and place their orders. Once placed, the staff will verify the order and process the order accordingly. Shipping price is included. This website is by no means a “full project proposal”. It has been simplified and customized for the purposes of SWE20001 teaching. All of the names listed in the report are hypothetical scenarios for academic purposes only.</p>
        <!--<a href="" class="button">Read More</a>-->
        <!-- read more button removed by josh (29/5/2024)-->
      </div>
      <div class="card">
        <div class="icon">
          <!--<i class="fas fa-wrench"></i>-->
          <img src="https://cdn-icons-png.freepik.com/512/13026/13026403.png">
        </div>
        <h2>Payment</h2>
        <p>currently the paument function has not implimented yet and customers will get a manual PayPal invoice sent by JD staffs, but customers "supposedly" be able to make the payment automatically through debit card in the future. This website is by no means a “full project proposal”. It has been simplified and customized for the purposes of SWE20001 teaching. All of the names listed in the report are hypothetical scenarios for academic purposes only.</p>
        <!--<a href="" class="button">Read More</a>-->
        <!-- read more button removed by josh (29/5/2024)-->
      </div>
    </div>
  </div>
  <?php include 'nav-footer/footer.php'; ?>
  <?php include 'nav-footer/alert-js.php'; ?>
</body>
</html>