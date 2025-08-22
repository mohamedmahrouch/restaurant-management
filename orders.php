<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Demmandes</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/styledeclia.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>demmandes</h3>
   <p><a href="html.php">home</a> <span> / demmandes</span></p>
</div>

<section class="orders">

   <h1 class="title">votre demmandes</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">veuillez vous connecter pour voir vos commandes</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>placé sur : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>nom : <span><?= $fetch_orders['name']; ?></span></p>
      <p>email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>nombre : <span><?= $fetch_orders['number']; ?></span></p>
      <p>adresse : <span><?= $fetch_orders['address']; ?></span></p>
      <p>mode de paiement: <span><?= $fetch_orders['method']; ?></span></p>
      <p>yvotre demandes : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>prix total: <span><?= $fetch_orders['total_price']; ?> DHs</span></p>
      <p> statut de paiement : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">aucune commande passée pour instant!</p>';
      }
      }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>