<?php
include '../components/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
}
if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   if(!empty($name)){
      $select_name = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
      $select_name->execute([$name]);
      if($select_name->rowCount() > 0){
         $message[] = 'Nom d utilisateur déjà pris!';
      }else{
         $update_name = $conn->prepare("UPDATE `admin` SET name = ? WHERE id = ?");
         $update_name->execute([$name, $admin_id]);
      }
   }

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $select_old_pass = $conn->prepare("SELECT password FROM `admin` WHERE id = ?");
   $select_old_pass->execute([$admin_id]);
   $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
   $prev_pass = $fetch_prev_pass['password'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = "l'ancien mot de passe ne correspond pas !";
      }else{
         if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
            $update_pass->execute([$confirm_pass, $admin_id]);
            $message[] = 'Mot de passe mis à jour avec succès!';
         }else{
            $message[] = 'veuillez entrer un nouveau mot de passe !';
         }
      }
   }

}

?>

<!DOCTYPE html>
<html >
<head>
   <meta charset="UTF-8">
   <title>mise à jour du profil</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<section class="form-container">
   <form action="" method="POST">
      <h3>mettre à jour le profil</h3>
      <input type="text" name="name" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['name']; ?>">
      <input type="password" name="old_pass" maxlength="20" placeholder="entrez votre ancien mot de passe" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" maxlength="20" placeholder="Entrez votre nouveau mot de passe" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" maxlength="20" placeholder="confirmez votre nouveau mot de passe" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Mettez à jour" name="submit" class="btn">
   </form>
</section>
<script src="../js/admin_script.js"></script>
</body>
</html>