<?php
include 'components/connect.php';
session_start();
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
};
if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $message[] = 'article du panier supprimé!';
}

if(isset($_POST['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   $message[] = 'tout supprimé du panier!';
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'quantité du panier mise à jour';
}

$grand_total = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>panier</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/styledeclia.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>
<div class="heading">
   <h3>panier</h3>
   <p><a href="home.php">Accueil</a> <span> / panier</span></p>
</div>
<section class="products">
   <h1 class="title">votre panier</h1>
   <div class="box-container">

      <?php
         $grand_total = 0;
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('supprimer cet élément ?');"></button>
         <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
         <div class="name"><?= $fetch_cart['name']; ?></div>
         <div class="flex">
            <div class="price"><?= $fetch_cart['price']; ?><span> DHs</span></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
            <button type="submit" class="fas fa-edit" name="update_qty"></button>
         </div>
         <div class="sub-total"> sous-total : <span><?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?> DHs</span> </div>
      </form>
      <?php
               $grand_total += $sub_total;
            }
         }else{
            echo '<p class="empty">Votre panier est vide</p>';
         }
      ?>

   </div>

   <div class="cart-total">
      <p>total : <span><?= $grand_total; ?> DHs</span></p>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">passer à la caisse</a>
   </div>

   <div class="more-btn">
      <form action="" method="post">
         <button type="submit" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" name="delete_all" onclick="return confirm('tout supprimer du panier?');">supprimer tout</button>
      </form>
      <a href="menu.php" class="btn">continue votre achat</a>
   </div>
   <div class="box-container">
      <a href="" class="box">
         <img src="images/ele.gif" alt="">
         <h2>PLUS VITE !!!</h2>
      </a>
   </div>

</section>
</section>
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>