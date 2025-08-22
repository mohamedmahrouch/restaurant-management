<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
<header class="header">

   <section class="flex">

      <a href="dashboard.php" class="logo">Administrateur</a>

      <nav class="navbar">
         <a href="dashboard.php">Accueil</a>
         <a href="products.php">Produits</a>
         <a href="placed_orders.php">Mes demandes </a>
         <a href="admin_accounts.php">Responsable</a>
         <a href="users_accounts.php">Utilisateur</a>
         <a href="messages.php">Messages</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update_profile.php" class="btn">changer profil</a>
         <a href="../components/admin_logout.php" onclick="return confirm('vous déconnecter de ce site ?');" class="delete-btn">Deconnexion </a>
      </div>
   </section>
</header>