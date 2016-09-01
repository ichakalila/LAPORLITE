<?php
$this->load->view('template/header');
?>

<div id="top"class="container">
  <div class="row box padbot">

      <?php $this->load->view('template/topbar'); ?>

      <div class="row">
         <ul class="nav nav-tabs">
          <li role="presentation"><a href="<?php echo base_url(); ?>beranda"><i class="fa fa-home"></i> Beranda</a></li>
          <li role="presentation" class="active"><a href="<?php echo base_url(); ?>laporanku"><i class="fa fa-file-text-o"></i> Laporanku</a></li>
          <li role="presentation" ><a href="<?php echo base_url(); ?>profil/main"><i class="fa fa-user"></i> Profil</a></li>
      </ul>
  </div>

  <hr class="simple-divider">
  <div class="row">

<?php $this->load->view('template/message');?>


<?php $this->load->view('template/laporan');?>
   
    
</div>

</div>
<?php
$this->load->view('template/top');
?>
</div>

<?php
$this->load->view('template/footer');
?>