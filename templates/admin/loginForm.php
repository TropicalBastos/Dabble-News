<?php include "templates/include/header.php"; ?>

<form action="admin.php?action=login" method="post">
  <input type="hidden" name="login" value="true">

<?php if (isset( $results['errorMessage'])):?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php endif;?>
<h2>Login</h2>
  <ul class="article-div">
    <li>
      <h3 style="margin-top:50px">Username:</h3>
      <input style="height:50px;font-size:25px" class="input" type="text" name="username" id="username" placeholder="Your admin username" required autofocus maxlength="20" />
    </li>
    <li>
      <h3>Password:</h3>
      <input style="height:50px;font-size:25px" class="input" type="password" name="password" id="password" placeholder="Your admin password" required maxlength="20" />
    </li>
    <li>
      <button class="button" type="submit" name="login">Login</button>
    </li>
  </ul>

</form>

<?php include "templates/include/footer.php" ?>
