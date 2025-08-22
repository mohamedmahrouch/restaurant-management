<?php
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>à propos </title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/styledeclia.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>à propos </h3>
   <p><a href="home.php">accueil</a> <span> /à propos</span></p>
</div>
<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>Pourquoi nous choisir?</h3>
         <p>Choisissez-nous pour une expérience exceptionnelle car nous nous engageons à vous offrir des produits de qualité, un service client attentif et une livraison rapide, afin de vous satisfaire à chaque bouchée.</p>
         <a href="menu.php" class="btn">NOTRE MENU</a>
      </div>

   </div>

</section>
<section class="steps">

   <h1 class="title">Étapes simples</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/step-1.png" alt="">
         <h3>choisir la commande</h3>
         <p>Nous avons méticuleusement sélectionné chaque commande pour notre site web afin de garantir une expérience fluide et optimale pour nos clients.</p>
      </div>

      <div class="box">
         <img src="images/step-2.png" alt="">
         <h3>livraison rapide</h3>
         <p>Profitez de notre livraison rapide pour recevoir vos commandes sans attendre, car nous comprenons l'importance de votre temps</p>
      </div>

      <div class="box">
         <img src="images/step-3.png" alt="">
         <h3>Super nourriture</h3>
         <p>Savourez une expérience culinaire inégalée avec notre incroyable sélection de super nourriture, spécialement préparée pour vous offrir une explosion de saveurs</p>
      </div>

   </div>

</section>
<section class="reviews">

   <h1 class="title">avis des clients</h1>

   <div class="swiper reviews-slider">

      <div class="swipuy b">
         <div class="swiper-slide slide">
            <img src="images/pic-3.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos voluptate eligendi laborum molestias ut earum nulla sint voluptatum labore nemo.</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Mahrouch mohamed</h3>
         </div>

      </div>

      <div class="swipuy b">
         <div class="swiper-slide slide">
            <img src="images/pic-3.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos voluptate eligendi laborum molestias ut earum nulla sint voluptatum labore nemo.</p>
            <div class="stars">
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star"></i>
               <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Bannany Brahim</h3>
         </div>

      </div>

      <div class="swiper-pagination"></div>

   </div>
</section>
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>

<script>

</body>
</html>