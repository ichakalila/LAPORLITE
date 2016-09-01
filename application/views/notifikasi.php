<?php
$this->load->view('template/header');
?>

<div id="top"class="container">
  <div class="row box padbot">

    <?php $this->load->view('template/topbar'); ?>
    <div class="row">

     <ul class="nav nav-tabs">
      <li role="presentation"><a href="<?php echo base_url(); ?>beranda"><i class="fa fa-home"></i> Beranda</a></li>
      <li role="presentation"><a href="<?php echo base_url(); ?>laporanku"><i class="fa fa-file-text-o"></i> Laporanku</a></li>
      <li role="presentation" ><a href="<?php echo base_url(); ?>profil/main"><i class="fa fa-user"></i> Profil</a></li>
    </ul>
  </div>

  <hr class="simple-divider">
  <div class="row">

    <?php if($notifications->status==1){
      if(count($notifications->data)!=0){ ?>
      
    <h3 class="text-center"> Notifikasi Anda</h3>
      <?php 
      foreach ($notifications->data as $data ) {
        switch($data->group_notification){
          case 'DUKUNGJUGA':?>
          <div class="col-xs-12 div-notif">
            <div class="col-xs-4">
              <img class="notif-img" src="<?php echo $data->avatar;?>"/>
            </div>

            <div class="col-xs-8">
              <h6 class="time"><?php 
                $d = date_create($data->tanggal);
                $now = date_create(date("Y-m-d"));
                $diff=date_diff($d,$now);
                if($diff->y != 0) echo $diff->y." tahun lalu";
                else if($diff->m != 0 ) echo $diff->m." bulan lalu";
                else if($diff->d != 0 ) echo $diff->d." hari lalu";
                else if($diff->h != 0) echo $diff->h." jam lalu";
                else if($diff->i != 0) echo $diff->i." menit lalu";
                else if($diff->s != 0) echo $diff->s." detik lalu";
                ?></h6>
                <h6><?php echo $data->name?></h6>
                <h5><a href="<?php echo base_url()."laporan/".$data->stream_nid;?>"><?php echo $data->subject;?></a></h5>

                <hr class="simple-divider">
                <p> <?php echo $data->message; ?> </p>
              </div>
            </div>
            <?php
            break;

            case 'SUDAHDIDISPOSISIKAN':?>
            <div class="col-xs-12 div-notif">

              <h5><strong>Laporan Anda Sudah Didisposisikan.</strong></h5>

              <h6>Tracking ID :<a href="<?php echo base_url()."laporan/".$data->stream_nid;?>"><?php echo $data->stream_nid; ?> </a></h6>
              <hr class="simple-divider">
              <h6 class="time"><?php 
                $d = date_create($data->tanggal);
                $now = date_create(date("Y-m-d"));
                $diff=date_diff($d,$now);
                if($diff->y != 0) echo $diff->y." tahun lalu";
                else if($diff->m != 0 ) echo $diff->m." bulan lalu";
                else if($diff->d != 0 ) echo $diff->d." hari lalu";
                else if($diff->h != 0) echo $diff->h." jam lalu";
                else if($diff->i != 0) echo $diff->i." menit lalu";
                else if($diff->s != 0) echo $diff->s." detik lalu";
                ?></h6>
              </div>
              <?php
              break;

              case 'TINDAKLANJUT':?>
              <div class="col-xs-12 div-notif">

                <h5><strong>Laporan Anda Telah Ditindaklanjuti.</strong></h5>

                <h6>Tracking ID :<a href="<?php echo base_url()."laporan/".$data->stream_nid;?>"><?php echo $data->stream_nid; ?> </a></h6>
                <hr class="simple-divider">
                <h6 class="time"><?php 
                  $d = date_create($data->tanggal);
                  $now = date_create(date("Y-m-d"));
                  $diff=date_diff($d,$now);
                  if($diff->y != 0) echo $diff->y." tahun lalu";
                  else if($diff->m != 0 ) echo $diff->m." bulan lalu";
                  else if($diff->d != 0 ) echo $diff->d." hari lalu";
                  else if($diff->h != 0) echo $diff->h." jam lalu";
                  else if($diff->i != 0) echo $diff->i." menit lalu";
                  else if($diff->s != 0) echo $diff->s." detik lalu";
                  ?></h6>
                </div><?php 
                break;

                default:
                break;

              }
            } 
          }
        }else{ ?>

        <div class="row">
          <div class="col-xs-12">
            <h4 class="text-center nextlaporan pull-right">Tidak Ada Notifikasi</h4>
          </div>
        </div>
        <hr class="simple-divider">

        <?php 
      }
      ?>


    </div>
  </div>

  <?php
  $this->load->view('template/footer');
  ?>