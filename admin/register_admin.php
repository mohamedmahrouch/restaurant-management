<?php
include '../components/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};
if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
   $select_admin->execute([$name]);
   
   if($select_admin->rowCount() > 0){
      $message[] = "Ce nom d'utilisateur existe déjà!";
   }else{
      if($pass != $cpass){
         $message[] = 'confirmez que le mot de passe ne correspond pas !';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admin`(name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = 'nouvel administrateur enregistré !';
      }
   }
}
?>
<!DOCTYPE html>
<html >
<head>
   <meta charset="UTF-8">
   <title>registre</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
<?php include '../components/admin_header.php' ?>

<section class="form-container">
   <form action="" method="POST">
      <h3>inscrivez-vous nouveau</h3>
      <input type="text" name="name" maxlength="20" required placeholder="Entrez votre nom d'utilisateur" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="tapez votre mot de passe" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" maxlength="20" required placeholder="confirmer votre mot de passe" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="S'inscrire maintenant" name="submit" class="btn">
   </form>
</section>
<script src="../js/admin_script.js"></script>
</body>
</html>