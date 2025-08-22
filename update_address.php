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

   $address = $_POST['flat'] .', '.$_POST['building'].', '.$_POST['area'].', '.$_POST['town'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);

   $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
   $update_address->execute([$address, $user_id]);

   $message[] = 'adresse enregistrée!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>changement adresse</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/styledeclia.css">

</head>
<body>
<?php include 'components/user_header.php' ?>
<section class="form-container">

   <form action="" method="post">
      <h3>votre adresse</h3>
      <input type="text" class="box" placeholder="N° d'appartement" required maxlength="50" name="flat">
      <input type="text" class="box" placeholder="N° de bâtiment" required maxlength="50" name="building">
      <input type="text" class="box" placeholder="Quartier" required maxlength="50" name="area">
      <input type="text" class="box" placeholder="Nom de la ville" required maxlength="50" name="town">
      <input type="text" class="box" placeholder="Nom de la grande ville" required maxlength="50" name="city">
      <input type="text" class="box" placeholder="Nom de l'état" required maxlength="50" name="state">
      <input type="text" class="box" placeholder="Nom du pays" required maxlength="50" name="country">
      <input type="number" class="box" placeholder="Code postal" required max="999999" min="0" maxlength="6" name="pin_code">
      <input type="submit" value="Enregistrer l'adresse" name="submit" class="btn">
   </form>
</section>
<?php include 'components/footer.php' ?>
<script src="js/script.js"></script>

</body>
</html>