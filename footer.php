<footer class="footer">

   <section class="box-container">

      <div class="box">
         <h3>quick links</h3>
         <a href="home.php"> <i class="fas fa-angle-right"></i> Home</a>
         <a href="shop.php"> <i class="fas fa-angle-right"></i> Shop</a>
         <a href="about.php"> <i class="fas fa-angle-right"></i> About</a>
         <a href="contact.php"> <i class="fas fa-angle-right"></i> Contact</a>
      </div>

      <div class="box">
         <h3>extra links</h3>
         <a href="cart.php"> <i class="fas fa-angle-right"></i> Giỏ hàng</a>
         <a href="wishlist.php"> <i class="fas fa-angle-right"></i> Yêu thích</a>
         <a href="login.php"> <i class="fas fa-angle-right"></i> Đăng nhập</a>
         <a href="register.php"> <i class="fas fa-angle-right"></i> Đăng kí</a>
      </div>

      <div class="box">
         <h3>contact info</h3>
         <p> <i class="fas fa-phone"></i> +84 999 999 999 </p>
         <p> <i class="fas fa-envelope"></i> OnlineMarket@gmail.com </p>
         <p> <i class="fas fa-map-marker-alt"></i> 484 Lạch Tray - Hải Phòng </p>
      </div>

      <div class="box">
         <h3>follow us</h3>
         <a href="https://www.facebook.com/profile.php?id=100068638026196"> <i class="fab fa-facebook-f"></i> Facebook </a>
         <a href="#"> <i class="fab fa-tiktok"></i> Tiktok </a>
         <a href="https://www.instagram.com/yangzil.07/?fbclid=IwY2xjawHHfVJleHRuA2FlbQIxMAABHZiSo5x2ErOteP_k9o7ep5ARrtpY_0u0Z8tQ7106czuXHhx3xxwYu_-WvQ_aem_ZJ3bqqrr201ZRbfibt5oBA"> <i class="fab fa-instagram"></i> Instagram </a>
        
      </div>

   </section>
   <p class="credit"> &copy; copyright @ <?= date('Y'); ?> by <span>OnlineMarket</span> | author_Mui_Lan_Thu </p>
</footer>

<!DOCTYPE html>
<html lang="en">
   <style>
      .footer{
         background-color: var(--white);
      }

      .footer .box-container{
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(27rem, 1fr));
         gap:2.5rem;
         align-items: flex-start;
      }

      .footer .box-container .box h3{
         text-transform: uppercase;
         color:var(--black);
         margin-bottom: 2rem;
         font-size: 2rem;
      }

      .footer .box-container .box a,
      .footer .box-container .box p{
         display: block;
         padding:1.3rem 0;
         font-size: 1.6rem;
         color:var(--light_color);
      }

      .footer .box-container .box a i,
      .footer .box-container .box p i{
         color:var(--green);
         padding-right: 1rem;
      }

      .footer .box-container .box a:hover{
         text-decoration: underline;
         color:var(--green);
      }

      .footer .credit{
         margin-top: 2rem;
         padding: 2rem 1.5rem;
         padding-bottom: 2.5rem;
         line-height: 1.5;
         border-top: var(--border);
         text-align: center;
         font-size: 2rem;
         color:var(--black);
      }
      
      .footer .credit span{
         color:var(--green);
      }
      </style>
</body>
</html>