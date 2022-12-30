<?php
require "../includes/db.inc.php";
    // Settings
    $sql1 = "SELECT * FROM settings;";
    $result1 = mysqli_query($conn,$sql1);
    $row1 = mysqli_fetch_assoc($result1);
    $facebook = $row1['facebook'];
    $twitter = $row1['twitter'];
    $instagram = $row1['instagram'];
    $whatsapp = $row1['phone'];
?>

<footer>
  <div class="footer-text text-center">
    Copyrights Ⓒ 2022 All Rights reserved | Design By <a href="http://wa.me/2349016242310">CodeXtra</a>
    </div>
    <div class="footer-icons">
      <a href="<?php echo $facebook ?>">
        <i class="bi bi-facebook"></i>
      </a>
      <a href="<?php echo $twitter ?>">
        <i class="bi bi-twitter"></i>
      </a>
      <a href="<?php echo $instagram ?>">
        <i class="bi bi-instagram"></i>
      </a>
      <a href="https://wa.me/<?php echo $whatsapp ?>">
        <i class="bi bi-whatsapp"></i>
      </a>
    </div>
</footer>