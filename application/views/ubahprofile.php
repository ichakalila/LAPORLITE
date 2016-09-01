<?php
$this->load->view('template/header');
?>

<div id="top" class="container">
  <div class="row box bot">

    <?php $this->load->view('template/topbar'); ?>

    <div class="row">
     <ul class="nav nav-tabs">
      <li role="presentation"><a href="<?php echo base_url(); ?>beranda"><i class="fa fa-home"></i> Beranda</a></li>
      <li role="presentation" ><a href="<?php echo base_url(); ?>laporanku"><i class="fa fa-file-text-o"></i> Laporanku</a></li>
      <li role="presentation" class="active"><a href="<?php echo base_url(); ?>profil/main"><i class="fa fa-user"></i> Profil</a></li>
    </ul>
  </div>

  <hr class="simple-divider">

  <?php $this->load->view('template/message');?>
  <br>
  <div class="row">
   <div class="col-xs-12">
    <div class="col-xs-12 nopadding">

     <img class="blok bigimg centerimg" 
     src=<?php echo ($this->session->userdata('img')!="")?"https://www.lapor.go.id/images/users/thumb/thumb_".$this->session->userdata('img').".jpg":"https://www.lapor.go.id/assets/style/lapor/images/profile-picture.png"; ?> />
   </div>
            <!--div class="col-xs-6 nopadding">
                
               <a class="btn standard-btn btn-sm text-center btn-danger"><i class="fa fa-file-image-o"></i> Ganti Foto</a>
               <a class="btn standard-btn btn-sm text-center btn-default"><i class="fa fa-envelope"></i> Ubah Email</a>
               <a class="btn standard-btn btn-sm text-center btn-default"><i class="fa fa-key"></i> Ubah Password</a>
             </div-->
           </div>

           <hr>
           {profil}
           <div class="col-xs-12" id="foto">
               <h4 class="text-center"><i class="fa fa-file-image-o"></i> Ganti Foto</h4>
               <hr class="simple-divider">
               <form action="<?php echo base_url(); ?>gantiavatar" method="post" enctype="multipart/form-data">
                <input type="hidden" name="userid" value="{user_id}">
                <input type="file" class="btn upload" name='userfile' />

                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <button type="submit" class="full btn btn-sm btn-danger"><i class="fa fa-file-image-o"></i> Unggah Foto</button>

              </form>
            </div>

            <div class="col-xs-12" id="email">
             <h4 class="text-center"><i class="fa fa-envelope"></i> Ganti Email</h4>
             <hr class="simple-divider">
             <form action="<?php echo base_url(); ?>gantiemail" method="post" enctype="multipart/form-data">
              <input type="hidden" name="userid" value="{user_id}">

              <div class="form-group">
                <label for="emailnew">Masukkan Email Baru :</label>
                <input type="email" class="form-control" placeholder="Email Baru" name="emailnew" aria-describedby="basic-addon1">
              </div>

              <div class="form-group">
                <label for="emailkonf">Konfirmasi Email Baru :</label>
                <input type="email" class="form-control" placeholder="Konfirmasi Email Baru" name="emailkonf" aria-describedby="basic-addon1">
              </div>

              <div class="form-group">
                <label for="password">Masukkan Password :</label>
                <input type="password" class="form-control" placeholder="Password" name="password" aria-describedby="basic-addon1">
              </div>


                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <button type="submit" class="full btn btn-sm btn-default"><i class="fa fa-envelope"></i> Ganti Email</button>
            </form>
          </div>

          <div class="col-xs-12" id="password">
             <h4 class="text-center"><i class="fa fa-key"></i> Ganti Password</h4>
             <hr class="simple-divider">
             <form action="<?php echo base_url(); ?>gantipassword" method="post" enctype="multipart/form-data">
              <input type="hidden" name="userid" value="{user_id}">
              <div class="form-group">
                <label for="passwordold">Masukkan Password Lama :</label>
                <input type="password" class="form-control" placeholder="Password Lama" name="passwordold" aria-describedby="basic-addon1" required>
              </div>

              <div class="form-group">
                <label for="passwordnew">Masukkan Password Baru :</label>
                <input type="password" class="form-control" placeholder="Email Baru" name="passwordnew" aria-describedby="basic-addon1" required>
              </div>

              <div class="form-group">
                <label for="passwordkonf">Konfirmasi Password Baru :</label>
                <input type="password" class="form-control" placeholder="Konfirmasi Email Baru" name="passwordkonf" aria-describedby="basic-addon1" required>
              </div>

                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

              <button type="submit" class="full btn btn-sm btn-danger"><i class="fa fa-key"></i> Ganti Password</button>
            </form>
          </div>

               <!--div class="form-group">
                  <label for="email">Password Lama :</label>
                  <input type="password" class="form-control" placeholder="Password Lama.." name="oldpass" aria-describedby="basic-addon1">
              </div>

               <div class="form-group">
                  <label for="email">Password Baru :</label>
                  <input type="password" class="form-control" placeholder="Password Baru.." name="newpass" aria-describedby="basic-addon1">
              </div>

               <div class="form-group">
                  <label for="email">Konfirmasi Password :</label>
                  <input type="password" class="form-control" placeholder="Konfirmasi..." name="confirmpass" aria-describedby="basic-addon1">
                </div-->
                {/profil}



              <br>
            </div>
            <hr>
          </div>
          <?php
          $this->load->view('template/top');
          ?>
        </div>

        <?php
        $this->load->view('template/footer');
        ?>