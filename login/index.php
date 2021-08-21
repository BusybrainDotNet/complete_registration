<?php 
/*
****** Project Name: Live Chat Apllication
****** App Version: 1.0
****** @Author: https://github.com/BusybrainDotNet
*/
require __DIR__.'/../top.php';
require __DIR__.'/../controller/login.php';
?>
<title>Welcome Back | Live Chat System | Messaging </title>


  <div class="top-menu">
    <ul class="nav pull-right top-menu">
      <li><a class="logout" href="../"><i class="fa fa-user"></i> Join Us</a></li>
    </ul>
  </div>
</header>


    <!--main content start-->
    <section id="main-content-centered">
        <div class="row">
          <!-- /col-lg-12 -->
          <div class="col-lg-12 mt">
              <!-- /panel-heading -->
              <div class="panel-body">
                <div class="tab-content">
                  <div id="overview" class="tab-pane active">
                    <div class="row">
                      <div class="col-lg-6 detailed mt">
                        <br><br>
                          <h4>Welcome To Gist-Ville</h4>
                          <h5 class="centered" style="font-weight: bold; color: #000;">Your Number One Interactive Chat Community.</h5>
                          <div class="recent-activity">
                            <div class="activity-icon bg-theme"><i class="fa fa-check"></i></div>
                            <div class="activity-panel">
                              <h5 style="font-weight: bold; color: #000;">Our Focus</h5>
                              <p style="font-weight: bold; color: #000;">Gist-ville Helps You Connect And Share With The People Around You.</p>
                            </div>
                            <div class="activity-icon bg-theme04"><i class="fa fa-rocket"></i></div>
                            <div class="activity-panel">
                              <h5 style="font-weight: bold; color: #000;">Our Aim</h5>
                              <p style="font-weight: bold; color: #000;">Freedom Of Expression For All Internet Users</p>
                            </div>
                          <!-- /recent-activity -->
                        </div>
                        <!-- /detailed -->
                      </div>
                      <!-- /col-md-6 -->
                      <div class="col-lg-6 detailed">
                         <form class="form-login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                            <p class="text-center" style="color: indianred; font-weight: bold;">** All Fields Are Required **</p>
                            <h2 class="form-login-heading">Welcome Back | Login</h2>
                            <div class="login-wrap">
                              <h5><?php if (!empty($response)) { ?>
                                <div id="response" class="<?php echo $response['type']; ?>">
                                  <?php echo $response["message"]; ?>
                                  </div>
                                <?php } ?>
                              </h5>
                              <input type="text" class="form-control" name="user" placeholder="User ID Or Email" autofocus>
                              <br>
                              <input type="password" class="form-control" name="password" placeholder="Password">
                              <br>
                              <button class="btn btn-theme btn-block" type="submit" name="login"><i class="fa fa-unlock"></i> Sign In</button>
                            </div>
                            <center>
                              <a data-toggle="modal" href="index.php#myModal"> Forgot Password?</a>
                            </center>
                             <br> <br>
                          </form>
                            <!-- Modal -->
                            <form class="form-login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" style="color:white;">Forgot Password ?</h4>
                                  </div>
                                  <div class="modal-body">
                                    <p>Enter your e-mail address below to reset your password.</p>
                                    <input type="text" name="user" placeholder="User ID Or Email" class="form-control" required autofocus>
                                  </div>
                                  <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button"><i class="fa fa-cancel"></i> Cancel</button>
                                    <button class="btn btn-theme" type="submit" name="pass"><i class="fa fa-unlock"></i> Submit</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- modal -->
                          </form>
                        </div>
                        <!-- /row -->
                      </div>
                      <!-- /col-md-6 -->
                    </div>
                    <!-- /OVERVIEW -->
                  </div>
                  <!-- /tab-pane -->
                </div>
                <!-- /tab-content -->
              </div>
              <!-- /panel-body -->
            </div>
            <!-- /col-lg-12 -->
          </div>
          <!-- /row -->
        </div>
        <!-- /container -->
    </section>
<?php require __DIR__.'/../foot.php';   ?>