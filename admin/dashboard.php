<?php
include '../components/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>tableau de bord</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../components/admin_header.php' ?>

<section class="dashboard">
   <h1 class="heading">tableau de bord</h1>
   <div class="box-container">
      <div class="box">
         <h3>Bienvenue!</h3>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update_profile.php" class="btn">mettre à jour le profil</a>
      </div>
      <div class="box">
         <?php
            $total_pendings = 0;
            $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_pendings->execute(['pending']);
            while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
               $total_pendings += $fetch_pendings['total_price'];
            }
         ?>
         <h3><?= $total_pendings; ?><span> DHs</span></h3>
         <p>total des attentes</p>
         <a href="placed_orders.php" class="btn">voir les commandes</a>
      </div>

      <div class="box">
         <?php
            $total_completes = 0;
            $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_completes->execute(['completed']);
            while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
               $total_completes += $fetch_completes['total_price'];
            }
         ?>
         <h3><?= $total_completes; ?><span> DHs</span></h3>
         <p>total terminé</p>
         <a href="placed_orders.php" class="btn">voir les commandes</a>
      </div>
      <div class="box">
         <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            $numbers_of_orders = $select_orders->rowCount();
         ?>
         <h3><?= $numbers_of_orders; ?></h3>
         <p>commandes totales</p>
         <a href="placed_orders.php" class="btn">voir les commandes</a>
      </div>

      <div class="box">
         <?php
            $select_products = $conn->prepare("SELECT * FROM `products`");
            $select_products->execute();
            $numbers_of_products = $select_products->rowCount();
         ?>
         <h3><?= $numbers_of_products; ?></h3>
         <p>produits ajoutés</p>
         <a href="products.php" class="btn">voir les produits</a>
      </div>

      <div class="box">
         <?php
            $select_users = $conn->prepare("SELECT * FROM `users`");
            $select_users->execute();
            $numbers_of_users = $select_users->rowCount();
         ?>
         <h3><?= $numbers_of_users; ?></h3>
         <p>comptes d'utilisateurs</p>
         <a href="users_accounts.php" class="btn">voir les utilisateurs</a>
      </div>

      <div class="box">
         <?php
            $select_admins = $conn->prepare("SELECT * FROM `admin`");
            $select_admins->execute();
            $numbers_of_admins = $select_admins->rowCount();
         ?>
         <h3><?= $numbers_of_admins; ?></h3>
         <p>administrateurs</p>
         <a href="admin_accounts.php" class="btn">voir les administrateurs</a>
      </div>

      <div class="box">
         <?php
            $select_messages = $conn->prepare("SELECT * FROM `messages`");
            $select_messages->execute();
            $numbers_of_messages = $select_messages->rowCount();
         ?>
         <h3><?= $numbers_of_messages; ?></h3>
         <p>nouveaux messages</p>
         <a href="messages.php" class="btn">voir les messages</a>
      </div>
   </div>
</section>
<script src="../js/admin_script.js"></script>
</body>
</html>