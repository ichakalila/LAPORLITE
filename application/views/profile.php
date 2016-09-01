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
    <form action="<?php echo base_url(); ?>ganti" method="post" enctype="multipart/form-data">

        <input type="hidden" name="userid" value="{user_id}">
       <div class="row">
           <div class="col-xs-12">
            <div class="col-xs-6 nopadding">
                
               <img class="blok bigimg" 
               src=<?php echo ($this->session->userdata('img')!="")?"https://www.lapor.go.id/images/users/thumb/thumb_".$this->session->userdata('img').".jpg":"https://www.lapor.go.id/assets/style/lapor/images/profile-picture.png"; ?> />
            </div>
            <div class="col-xs-6 nopadding">
                
               <a href="<?php echo base_url(); ?>profil/ubah#foto" class="btn standard-btn btn-sm text-center btn-danger"><i class="fa fa-file-image-o"></i> Ganti Foto</a>
               <a href="<?php echo base_url(); ?>profil/ubah#email"class="btn standard-btn btn-sm text-center btn-default"><i class="fa fa-envelope"></i> Ubah Email</a>
               <a href="<?php echo base_url(); ?>profil/ubah#password"class="btn standard-btn btn-sm text-center btn-default"><i class="fa fa-key"></i> Ubah Password</a>
            </div>
           </div>

            <hr>
           {profil}
           <div class="col-xs-12">
               <div class="form-group">
                  <label for="email">Email :</label>
                  <input type="email" class="form-control" placeholder="Email" name="email" value="{email}"aria-describedby="basic-addon1" readonly>
              </div>

               <div class="form-group">
                  <label for="firstname">Nama Depan :</label>
                  <input type="text" class="form-control" placeholder="Nama Depan..." name="firstname" value="{first_name}" aria-describedby="basic-addon1" required title="Tolong Masukkan Nama Depan..">
              </div>

               <div class="form-group">
                  <label for="lastname">Nama Belakang :</label>
                  <input type="text" class="form-control" placeholder="Nama Belakang..." name="lastname" value="{last_name}"aria-describedby="basic-addon1" required  title="Tolong Masukkan Nama Belakang..">
              </div>

               <div class="form-group">
                  <label for="phone">Telpon :</label>
                  <input type="text" class="form-control" placeholder="Telpon..." name="phone" value="{phone}" aria-describedby="basic-addon1">
              </div>

               <div class="form-group">
                  <label for="birthday">Tanggal Lahir :</label>
                  <input type="date" class="form-control" placeholder="Birthday..." name="birthday" value="{birthday}" aria-describedby="basic-addon1">
              </div>

               <div class="form-group">
                  <label for="sex">Jenis Kelamin :</label>
                  <select name="sex">
                      <option value="0" <?php 
                      if($profil[0]->sex == 0){ echo 'selected'; }?>>Laki Laki</option>
                      <option value="1" <?php if($profil[0]->sex == 1){ echo 'selected'; }?> >Perempuan</option>
                  </select>
              </div>

               <div class="form-group">
                  <label for="email">Nomor ID :</label>
                  <input type="text" class="form-control" placeholder="SIM/KTP/STNK/Passport..." name="no_id" value="{no_id}" aria-describedby="basic-addon1">
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


        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

          </div>
          <br>
      </div>
        <hr>
        <button type="submit" class="full btn btn-danger">Update Data Diri</button>
  </form> 
</div>
<?php
$this->load->view('template/top');
?>
</div>

<?php
$this->load->view('template/footer');
?>