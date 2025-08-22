<?php
include '../components/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
}
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_order->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   header('location:users_accounts.php');
}
?>
<!DOCTYPE html>
<html >
<head>
   <meta charset="UTF-8">
   <title>users accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../components/admin_header.php' ?>

<section class="accounts">

   <h1 class="heading">compte utilisateur</h1>
   <div class="box-container">

   <?php
      $select_account = $conn->prepare("SELECT * FROM `users`");
      $select_account->execute();
      if($select_account->rowCount() > 0){
         while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <p> ID de l'utilisateur : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> nom d'utilisateur : <span><?= $fetch_accounts['name']; ?></span> </p>
      <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('supprimer ce compte ?');">supprimer </a>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">aucun compte disponible</p>';
   }
   ?>
   </div>
</section>
<script src="../js/admin_script.js"></script>
</body>
</html>