<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>home</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="css/styledeclia.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="hero">

   <div class="swiper hero-slider">
      <div class="swiper-wrapper">
         <div class="fond">
         <div class="swiper-slide slide">
                     <div class="content">
                        <a href="menu.php" class="btn">voir les menus</a>
                     </div>
                     <div class="image">
                        <img src="images/home-img-1.png" alt="">
                     </div>
                  </div>

                  <div class="swiper-slide slide">
                     <div class="content">
                        <a href="menu.php" class="btn">voir les menus</a>
                     </div>
                     <div class="image">
                        <img src="images/home-img-2.png" alt="">
                     </div>
                  </div>

                  <div class="swiper-slide slide">
                     <div class="content">
                        <a href="menu.php" class="btn">voir les menus</a>
                     </div>
                           <div class="image">
                              <img src="images/home-img-3.png" alt="">
                           </div>
                           </div>
         </div>
         <div class="pagination">
               <button class="prev" onclick="prevSlide()"><u><i class='bx bx-left-arrow-alt'></i></u></button>
               <button class="next" onclick="nextSlide()"><u><i class='bx bx-right-arrow-alt'></i></u></button>
         </div>
        
</div>
   </div>
  
</section>
<script>
    var currentSlide = 0;
var slides = document.getElementsByClassName("slide");

function showSlide(n) {
  for (var i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  currentSlide = (n + slides.length) % slides.length;
  slides[currentSlide].style.display = "block";
}

function prevSlide() {
  showSlide(currentSlide - 1);
}

function nextSlide() {
  showSlide(currentSlide + 1);
}
showSlide(currentSlide);
   </script>
  <section>
<h1 class="title">catégorie alimentaire</h1>

<div class="video">
<div class="row">

   <div class="about-video">
      <div class="about-video-img" style="background-image: url(images/imagevideo.webp);"> </div>
   <div class="play-btn-wp">
      <a href="images/video.mp4" data-fancybox="video" class="play-btn">
         <button  class="voir"><u><i class='bx bx-play-circle'  ></i></i></u>voir le video</button>
      </a>
   </div>
</div>
</div>
</div>
</section>
         
<section class="category">
   <h1 class="title">catégorie alimentaire</h1>
   <div class="box-container">

      <a href="category.php?category=fast food" class="box">
         <img src="images/imagescat-1.jpeg" alt="">
         <h3>Fast food</h3>
      </a>

      <a href="category.php?category=main dish" class="box">
         <img src="images/maindishes.jpeg" alt="">
         <h3>main dishes</h3>
      </a>

      <a href="category.php?category=drinks" class="box">
         <img src="images/boissons.jpg" alt="">
         <h3>boissons</h3>
      </a>

      <a href="category.php?category=desserts" class="box">
         <img src="images/desserts.jpeg" alt="">
         <h3>desserts</h3>
      </a>

   </div>
</section>

<section class="products">
   <h1 class="title">derniers plats</h1>

   <div class="box-container">

      <?php
         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
         <div class="name"><?= $fetch_products['name']; ?></div>
         <div class="flex">
            <div class="price"><?= $fetch_products['price']; ?><span>DHs</span></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">aucun produit ajouté pour instant!</p>';
         }
      ?>

   </div>

   <div class="more-btn">
      <a href="menu.php" class="btn ">Voir tout</a>
   </div>

</section>
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>