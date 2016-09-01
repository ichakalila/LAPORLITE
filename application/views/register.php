<?php
$this->load->view('template/header');
?>

<div id="top" class="container">
  <div class="row box">
    <?php $this->load->view('template/message');?>

    <h2 class="text-center">LAPOR! <small>lite</small></h2>
    <h5 class="text-center">Layanan Aspirasi dan Pelayanan Online Rakyat</h5>
    <hr class="simple-divider">
    <!--a href="#test" class="btn btn-default">Login</a-->
    <!--div id="login"-->
    <!--div id="test"-->

    <h3 class="text-center">Form Pendaftaran</small></h3>   
    <hr class="simple-divider">
    <div class="register">
    <form action="<?php echo base_url(); ?>daftarkan" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="email">*Email :</label>
        <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo (isset($email))?$email:""; ?>" aria-describedby="basic-addon1" required title="Tolong Masukkan Email..">
      </div>

      <div class="form-group">
        <label for="firstname">*Password :</label>
        <input type="password" class="form-control" placeholder="Password..." name="password" aria-describedby="basic-addon1" required title="Tolong Masukkan Password.." min=6>
      </div>

      <div class="form-group">
        <label for="firstname">*Konfirmasi Password :</label>
        <input type="password" class="form-control" placeholder="Masukkan Password Sekali lagi..." name="confirmpass" aria-describedby="basic-addon1" required title="Tolong Masukkan Password Sekali lagi.." min=6>
      </div>


      <div class="form-group">
        <label for="firstname">*Nama Depan :</label>
        <input type="text" class="form-control" placeholder="Nama Depan..." name="firstname" value="<?php echo str_replace('%20', ' ', (isset($firstname))?$firstname:""); ?>"aria-describedby="basic-addon1" required title="Tolong Masukkan Nama Depan..">
      </div>

      <div class="form-group">
        <label for="lastname">*Nama Belakang :</label>
        <input type="text" class="form-control" placeholder="Nama Belakang..." name="lastname" value="<?php echo str_replace('%20', ' ', (isset($lastname))?$lastname:""); ?>"aria-describedby="basic-addon1" required  title="Tolong Masukkan Nama Belakang..">
      </div>

      <div class="form-group">
        <label for="phone">*Telpon :</label>
        <input type="text" class="form-control" placeholder="Telpon..." name="phone" value="<?php echo str_replace('%20', ' ', (isset($phone))?$phone:""); ?>" aria-describedby="basic-addon1" required title="Tolong Masukkan Nomor Telpon Anda..">
      </div>
      <hr>
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <p class="text-center">* Wajib Diisi</p>
      <button type="submit" class="full btn btn-danger">Daftar</button>
      <hr>
      <a href="<?php echo base_url()?>"> Kembali Ke Login</a>

    </form>
    </div>
    <!--/div-->
    <!--/div-->
  </div>
</div>

<?php
$this->load->view('template/footer');
?>