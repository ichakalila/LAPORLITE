<div class="row top-divide">
      <div class="col-xs-5 brand">
        <h3 class="nomargin-b blok"><strong>LAPOR!</strong> <small>lite</small></h3>
         <h5 class="nomargin-h">Layanan Aspirasi dan Pelayanan Online Rakyat</h5>
      </div>
      <div class="col-xs-7 nopad">
      <span class="blok pull-right">
          <img class="blok thumbimg" 
          src=<?php echo ($this->session->userdata('img')!="")?"https://www.lapor.go.id/images/users/thumb/thumb_".$this->session->userdata('img').".jpg":"https://www.lapor.go.id/assets/style/lapor/images/profile-picture.png"; ?> />
          <h6 class="loginas text-right">Halo <br><strong><?php echo $firstname." ".$lastname; ?> </strong><hr class="login-divider">
          <span class="sm-badge<?php echo ($notif==0)?"-zero":"";?> badge"><a <?php if($this->session->userdata('level')!= 99){echo "href=".base_url()."notifications"; }?>><i class="fa fa-bell"> <?php echo $notif; ?> </i></a></span>
          <a href="<?php echo base_url(); ?>logout/1">Keluar</a></h6>
        </span>
      </div>
      </div>