<style type="text/css">
	.footer_container{
		max-width: 1170px;
		margin:auto;
	}
	.row{
		display: flex;
		flex-wrap: wrap;
	}
	.footer{
		background-color: #24262b;
		padding: 70px 0;
	}
	.footer-col{
		width: 25%;
		padding: 0 15px;
	}
	.footer-col h4{
		font-size: 18px;
		color: #ffffff;
		text-transform: capitalize;
		margin-bottom: 35px;
		font-weight: 500;
		position: relative;
	}
	.footer-col h4::before{
		content: '';
		position: absolute;
		left:0;
		bottom: -10px;
		background-color: #e91e63;
		height: 2px;
		box-sizing: border-box;
		width: 50px;
	}
	.footer-col ul li:not(:last-child) {
		margin-bottom: 10px;
	}
	.footer-col ul li a{
		font-size: 16px;
		text-transform: capitalize;
		color: #ffffff;
		text-decoration: none;
		font-weight: 300;
		color: #bbbbbb;
		display: block;
		margin-left: -35px;
	}
	.footer-col ul li a:hover{
		color: #ffffff;
		padding-left: 8px;
	}
	.footer-col .social-links a{
		display: inline-block;
		height: 40px;
		width: 40px;
		background-color: rgba(255,255,255,0.2);
		margin:0 10px 10px 0;
		text-align: center;
		line-height: 40px;
		border-radius: 50%;
		color: #ffffff;
		transition: all 0.5s ease;
	}
	.footer-col .social-links a:hover{
		color: #24262b;
		background-color: #ffffff;
	}
</style>
 <footer class="footer">
        <div class="footer_container">
            <div class="row">
                <div class="footer-col">
                    <h4>company</h4>
                    <ul class="footer-ul">
                        <li><a href="aboutus.php">about us</a></li>
                        <li><a href="ourservices.php">our services</a></li>
                        <li><a href="privacypolicy.php">privacy policy</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>get help</h4>
                    <ul class="footer-ul">
                        <li><a href="contactus.php">Contact Us</a></li>
                        <!-- <li><a href="#">shipping</a></li> -->
                        <li><a href="orderhistory.php">order status</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Shop</h4>
                    <ul>
                        <li><a href="product.php">All shoes</a></li>
                       <!--  <li><a href="#">Men</a></li>
                        <li><a href="#">Women</a></li> -->
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>follow us</h4>
                    <div class="social-links">
                        <a href="https://www.facebook.com/jdsportsmalaysia/"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/JDSports"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/jdsportsmy/"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>