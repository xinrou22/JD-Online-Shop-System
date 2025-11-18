<!DOCTYPE html>
<html lang="en">
<?php
include("connect/config.php");
error_reporting(0); 
session_start(); 

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width = device-width, intital-scale = 1">
    <!--page-icon------------>
    <link rel="shortcut icon" href="images/pg-logo.png">
    <title>Homepage</title>
</head>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<link rel="stylesheet" href=css/style.css>

<html>
<body style=background-color:white>
    <!-- Insert Navbar -->
    <?php include'nav-footer/nav.php' ?>
    <!-- Slideshow container -->
    <div class="slideshow-container">

        <!-- Full-width images with number and caption text -->
        <div class="mySlides">
            <img src="images/shoesImage5.jpg" style="width: 100%;">
        </div>

        <div class="mySlides">
            <img src="images/shoesImage6.jpg" style="width: 100%">
        </div>

        <div class="mySlides">
            <img src="images/shoesImage4.jpg" style="width:100%">
        </div>

        <div class="mySlides">
            <img src="images/shoesImage7.jpg" style="width:100%">
        </div>

        <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
    <br>

    <!-- The dots/circles -->
    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
    </div>
    <br><br><br>
    <h1 class="bookGroup">New Arrivals</h1>

    <table class="table1" width="90%" align="center">

        <tr>
            <?php
// Include your database connection file
            include("connect/config.php");

// Query to fetch new arrivals products
            $sql = "SELECT * FROM products WHERE arrival_date >= DATE_SUB(NOW(), INTERVAL 30 DAY) LIMIT 4";
            $result = mysqli_query($conn, $sql);

// Check if there are any new arrivals
            if (mysqli_num_rows($result) > 0) {
    // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <td class="td">

                        <img src="admin/product/<?php echo $row['img']; ?>" alt="Product Image" width="100%" class="cover">
                        <p>
                            <b class="title"><?php echo $row["name"]; ?></b><br><b class="price">RM<?php echo $row["price"]; ?></b>
                        </p>

                        <a href="product.php"><button class="btn-1" style="width:100%">view</button></a>
                    </td>
                    <?php


                }
            } else {
                echo "<tr><td colspan='4'>No products found</td></tr>";
            }

// Close database connection
            mysqli_close($conn);
            ?>
        </tr>

    </table>


    <!--Map Location-->
    <div class="Map">
        <h1>The Map</h1>
        <iframe style="width:90rem;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.082452833053!2d101.60447287409028!3d3.0726469969030643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4c87994e6e83%3A0x6ec95f9bde584169!2sJD%20Sports!5e0!3m2!1sen!2smy!4v1715050969036!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <!-- Insert Footer -->
    <?php include'nav-footer/footer.php' ?>
    <?php include 'nav-footer/alert-js.php' ?>

    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <!-- custom js file link  -->
    <script src="js/HomeScript.js"></script>
</body>
</html>