<?php 
/*
Project Name: Live Chat Apllication
App Version: 1.0
Author: https://github.com/BusybrainDotNet
*/
require __DIR__.'/../top.php';
require __DIR__.'/../controller/confirm.php';
?>

<title>Confirm User | Live Chat System | Messaging </title>

  <div class="top-menu">
    <ul class="nav pull-right top-menu">
      <li><a class="logout" href="../login/"><i class="fa fa-users"></i> Login</a></li>
    </ul>
  </div>
</header>

<div id="login-page">
    <div class="container">
      <form class="form-login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <p class="text-center" style="color: indianred; font-weight: bold;">** You're Now Been Confirmed **</p>
        <h2 class="form-login-heading">Confirm User | Join Us</h2>

        <div class="login-wrap">
          <h5>
            <?php if (!empty($response)) { ?>
            <div id="response" class="<?php echo $response['type']; ?>">
              <?php echo $response["message"]; ?>
              </div>
            <?php } ?>
          </h5>
        </div>
        <br>
      </form>
    </div>
  </div>
<?php require __DIR__.'/../foot.php';   ?>