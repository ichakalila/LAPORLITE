<?php
$this->load->view('template/header');
?>

<div id="top" class="container">
  <div class="row box">
  <?php $this->load->view('template/message');?>

   <h2 class="text-center">LAPOR! <small>lite</small></h2>
   <h5 class="text-center">Layanan Aspirasi dan Pelayanan Online Rakyat</h5>
   <hr>
   <!--a href="#test" class="btn btn-default">Login</a-->
   <!--div id="login"-->
   <!--div id="test"-->
   <form action="<?php echo base_url(); ?>main" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="email">Email/No HP :</label>
      <input type="text" class="form-control" placeholder="Email/No.HP.." name="email" aria-describedby="basic-addon1">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" class="form-control" placeholder="Password..." name="password" aria-describedby="basic-addon1">
    </div>
    <hr>
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
  <button type="submit" class="full btn btn-danger">Login</button>
  <p class="text-center">Tidak punya Akun ? <a href="<?php echo base_url(); ?>daftar/pelapor" class="text-danger"> Daftar di sini </a> | <a href="<?php echo base_url(); ?>lupapasswordload" class="text-danger"> Lupa password?</a></p>
    <hr>
   </form>
   <!--/div-->
   <!--/div-->
   </div>
</div>

<?php
$this->load->view('template/footer');
?>