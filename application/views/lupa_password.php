<?php
$this->load->view('template/header');
?>

<div id="top" class="container">
  <div class="row box">
  <div class="row top-divide">
      <div class="col-xs-5 brand">
        <h3 class="nomargin-b blok"><strong>LAPOR!</strong> <small>lite</small></h3>
         <h5 class="nomargin-h">Layanan Aspirasi dan Pelayanan Online Rakyat</h5>
      </div>
      
      </div>    
    <?php $this->load->view('template/message');?>   
    <!--a href="#test" class="btn btn-default">Login</a-->
    <!--div id="login"-->
    <!--div id="test"-->

    <h3 class="text-center">Lupa Password</small></h3>   
    <hr class="simple-divider">
    <form action="<?php echo base_url(); ?>lupapassword" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="email">Masukkan alamat email anda</label>
        <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo (isset($email))?$email:""; ?>" aria-describedby="basic-addon1" required title="Tolong Masukkan Email..">
      </div>
      <hr>
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

      <button type="submit" class="full btn btn-danger">Kirim</button>      
      <p class="text-center"> <a href="<?php echo base_url()?>" class="text-danger">Kembali Ke Login</a></p>      
    </form>

    <!--/div-->
    <!--/div-->
  </div>
</div>

<?php
$this->load->view('template/footer');
?>