<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR number = ?");
   $select_user->execute([$email, $number]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'E-mail ou le numéro existe déjà!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirmer que le mot de passe ne correspond pas!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, number, password) VALUES(?,?,?,?)");
         $insert_user->execute([$name, $email, $number, $cpass]);
         $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
         $select_user->execute([$email, $pass]);
         $row = $select_user->fetch(PDO::FETCH_ASSOC);
         if($select_user->rowCount() > 0){
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>connexion</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/styledeclia.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>connexion maintenant</h3>
      <input type="text" name="name" required placeholder="entrez votre nom" class="box" maxlength="50">
      <input type="email" name="email" required placeholder="entrer votre Email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="number" name="number" required placeholder="Entrez votre numéro" class="box" min="0" max="9999999999" maxlength="10">
      <input type="password" name="pass" required placeholder="tapez votre mot de passe" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="confirmez votre mot de passe" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="S'inscrire" name="submit" class="btn">
      <p>Vous avez déjà un compte? <a href="login.php">connexion</a></p>
   </form>

</section>
<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>