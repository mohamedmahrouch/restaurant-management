<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'message déjà envoyé!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);
      $message[] = 'message envoyé avec succès!';

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>contact</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/styledeclia.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>contact</h3>
   <p><a href="home.php">Acueil</a> <span> / contact</span></p>
</div>
<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>
      <form action="" method="post">
         <h3>dis-nous quelque chose!</h3>
         <input type="text" name="name" maxlength="50" class="box" placeholder="entrez votre nom" required>
         <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="Entrez votre numéro" required maxlength="10">
         <input type="email" name="email" maxlength="50" class="box" placeholder="entrer votre Email" required>
         <textarea name="msg" class="box" required placeholder="entrez votre message" maxlength="500" cols="30" rows="10"></textarea>
         <input type="submit" value="envoyer le message" name="send" class="btn">
      </form>
   </div>
</section>

<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>