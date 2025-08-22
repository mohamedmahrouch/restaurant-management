<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      if($address == ''){
         $message[] = 'veuillez ajouter votre adresse!';
      }else{
         
         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'commande passée avec succès!';
      }
      
   }else{
      $message[] = 'Votre panier est vide';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>checkout</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/styledeclia.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>
<div class="heading">
   <h3>vérification</h3>
   <p><a href="home.php">Accueil</a> <span> / vérificattion</span></p>
</div>

<section class="checkout">
   <h1 class="title">Récapitulatif de la commande</h1>
<form action="" method="post">

   <div class="cart-items">
      <h3>articles du panier</h3>
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
      <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price"><?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?> DHs</span></p>
      <?php
            }
         }else{
            echo '<p class="empty">Votre panier est vide!</p>';
         }
      ?>
      <p class="grand-total"><span class="name">prix total :</span><span class="price"><?= $grand_total; ?> DHs</span></p>

   </div>

   <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

   <div class="user-info">
      <select name="method" class="box" required>
         <option value="" disabled selected>Sélectionnez le mode de paiement --</option>
         <option value="cash on delivery">paiement à la livraison</option>
         <option value="credit card">carte de crédit</option>
         <option value="paytm">paytm</option>
         <option value="paypal">paypal</option>
      </select>
      <input type="submit" value="Passer la commande" class="btn <?php if($fetch_profile['address'] == ''){echo 'désactivé';} ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
   </div>
</form>
</section>
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>