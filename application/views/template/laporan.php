 <?php if(count($stream)!=0&&(!isset($stream->error))){?>
 <?php foreach($stream as $resp){ ?>
 <div class="col-xs-12 laporan">
   <div class="content">
    <img class="blok pelaporimg" 
    src=<?php echo (!empty($resp->hash_photo))?"https://www.lapor.go.id/images/users/thumb/thumb_".$resp->hash_photo.".jpg":"https://www.lapor.go.id/assets/style/lapor/images/profile-picture.png"; ?> />
    <h6 class="pelapor"><strong><?php echo $resp->first_name." ".$resp->last_name?></strong>
     
      <?php if(!empty($resp->closed_at)&&$resp->status==9){ ?> <span class="closed pull-right">Selesai</span><?php }?></h6>

      <?php if($resp->status==1){ ?> <span class="closed-blm pull-right">Belum</span><?php }?></h6>


      <?php if($resp->status==7||$resp->status==5){ ?> <span class="closed-pros pull-right">Proses</span><?php }?></h6>
     
     
      <h6 class="topik_name"><a href="<?php echo base_url()."streams/".$resp->topic_nid."/0";?>"><?php echo $resp->topic_name ?></a></h6>
      <h4 class="judullaporan"><a href=<?php echo base_url()."laporan/".$resp->nid;?>><strong><?php echo $resp->subject;?></strong></a></h4>
      
      <hr class="simple-divider">
      <p class="parwrap"align=<?php echo (isset($resp->content['isi']))?"justify":"left"; ?>><?php echo (isset($resp->content['isi']))?$resp->content['isi']:$resp->content;?><br>
        <?php if(isset($resp->content['isLong'])){if($resp->content['isLong']){?><a href="./laporan/<?php echo $resp->nid;?>">Baca Selengkapnya</a><?php }}  ?></p>

        <?php if(!empty($resp->lampiran)){ ?>

        <h6> Lampiran : </h6>
        <div class="row">
          <div class="col-xs-12 tempatlampiran">
            <?php foreach($resp->lampiran as $lamp){ ?>
            <div class="col-xs-1 filelampiran">
              <?php switch($lamp->fileext){
                case "pdf":
                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-pdf-o"></i> </a>';
                break;

                case "docx":
                case "doc":
                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-word-o"></i> </a>';
                break;

                case "7zip":
                case "rar":
                case "zip":
                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-archive-o"></i> </a>';
                break;

                case "mp3":
                case "wav":
                case "m3a":
                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-film"></i> </a>';
                break;

                case "mp4":
                case "3gp":
                case "mpeg":
                case "wmv":
                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-audio-o"></i> </a>';
                break;

                case "csv":
                case "xls":
                case "xlsx":
                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-excel-o"></i> </a>';
                break;

                case "ppt":
                case "pptx":
                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-powerpoint-o"></i> </a>';
                break;

                case "png":
                case "jpg":
                case "psd":
                case "svg":
                case "gif":
                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-image-o"></i> </a>';
                break;

                case "txt":
                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-text-o"></i> </a>';
                break;

                default:
                echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-o"></i> </a>';
                break;

              } ?>
            </div>
            <?php }
            echo "</div></div>";
            ?>

            <?php } ?>

            <hr class="laporan-divider">
            <a class="blok" href="<?php echo base_url()."dukung/".$gotowhere."/".$resp->nid; ?>"><i class="fa fa-thumbs-up"></i> Dukung</a> <a 
            <?php if(count($stream)!=1){ echo 'href="'.base_url()."laporan/".$resp->nid.'#komen"';}?> class="blok komenblok"> <?php echo ($resp->comments!=0)?'<i class="fa fa-comment"></i>'." ".$resp->comments." Komentar":""; ?></a>
              <div><span class="blue-color"><?php if($resp->agree !=0){ echo "<strong>".$resp->agree." Dukungan</strong> <span class='tambahan'>-</span> ";}?> </span> <span class="tambahan">
                <?php 
                $d = date_create($resp->tanggal);
                $now = date_create(date("Y-m-d"));
                $diff=date_diff($d,$now);
                if($diff->y != 0) echo $diff->y." tahun lalu";
                else if($diff->m != 0 ) echo $diff->m." bulan lalu";
                else if($diff->d != 0 ) echo $diff->d." hari lalu";
                else if($diff->h != 0) echo $diff->h." jam lalu";
                else if($diff->i != 0) echo $diff->i." menit lalu";
                else if($diff->s != 0) echo $diff->s." detik lalu";
                ?>
              </span></div>
            </div>
            <?php if($resp->verified==0&&$resp->status==0){ ?>
            <div class="text-center verifikasi">
              <h9>(Laporan Anda sedang kami verifikasi)</h9><br>
              <a href="<?php echo base_url()."hapus/".$resp->nid ?>"class="text-danger"><i class="fa fa-times"></i> Hapus Laporan</a>
            </div>
            <?php }?>
            <?php if($resp->status==2){ ?>
            <div class="text-center verifikasi">
              <h9>(Laporan di-pending karena sedang menunggu verifikasi lanjutan (tambahan data dan informasi laporan) dan/atau karena instansi yang dituju belum terhubung ke LAPOR!)</h9><br>
              <a class="text-danger"><i class="fa fa-times"></i> Hapus Laporan</a>
            </div>
            <?php } if($resp->status !=2 && $resp->verified!=0&& $resp->status!=0){?>
            <div id="tindaklanjut">

              <h5 class="text-center"><a href="<?php echo base_url().'tindaklanjut/'.$resp->nid.'#tindaklanjut'; ?>"> <?php echo ($resp->JmlTL==0)?"Belum Ada":"(".$resp->JmlTL.")"; ?> Tindak Lanjut  <i class="fa fa-caret-down"></i></a></h5>
            </div>

            <?php if(isset($tindaklanjut)&&!isset($tindaklanjut->error)){foreach($tindaklanjut as $tl){ ?>
            <div class="col-xs-12 div-tl">
              <div class="col-xs-2 left-zero">
                <img class="komentar-img" src="<?php if(!empty($tl->logo)){ echo "https://www.lapor.go.id/images/instansi/thumb/thumb_".$tl->logo.".jpg"; } else if(!empty($tl->hash_photo)){ echo "https://www.lapor.go.id/images/users/thumb/thumb_".$tl->hash_photo.".jpg";} else { echo "https://www.lapor.go.id/assets/style/lapor/images/profile-picture.png"; } ?>"/>
              </div>
              <div class="col-xs-10 right-zero">
                <h6 class="time"><?php 
                  $d = date_create($tl->tanggal);
                  $now = date_create(date("Y-m-d"));
                  $diff=date_diff($d,$now);
                  if($diff->y != 0) echo $diff->y." tahun lalu";
                  else if($diff->m != 0 ) echo $diff->m." bulan lalu";
                  else if($diff->d != 0 ) echo $diff->d." hari lalu";
                  else if($diff->h != 0) echo $diff->h." jam lalu";
                  else if($diff->i != 0) echo $diff->i." menit lalu";
                  else if($diff->s != 0) echo $diff->s." detik lalu";
                  ?></h6>
                  <h6><strong><?php echo (!empty($tl->LevelName))?$tl->LevelName:($tl->first_name." ".$tl->last_name);?></strong></h6>

                  <div class="rating"><strong>Rating</strong> : <?php if(isset($resp->rate)){
                    for($x = 0;$x < $resp->rate;$x++){
                      echo '<i class="fa shine fa-star"></i>';
                    }for($x = 0;$x < (5-$resp->rate);$x++){
                      echo '<i class="fa redup fa-star"></i>';
                    }
                  }else{echo '<i class="fa redup fa-star"></i><i class="fa redup fa-star"></i><i class="fa redup fa-star"></i><i class="fa redup fa-star"></i><i class="fa redup fa-star"></i>';}
                  ?></div>

                  <hr class="simple-divider">
                  <p> <?php echo $tl->claim_text; ?> </p>
                  <?php if(!empty($tl->Lampiran)){ ?>

                  <h6> Lampiran : </h6>
                  <div class="row">
                    <div class="col-xs-12 tempatlampiran">
                      <?php foreach($tl->Lampiran as $lamp){ ?>
                      <div class="col-xs-1 filelampiran">
                        <?php switch($lamp->file_extension){
                          case "pdf":
                          echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-pdf-o"></i> </a>';
                          break;

                          case "docx":
                          case "doc":
                          echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-word-o"></i> </a>';
                          break;

                          case "7zip":
                          case "rar":
                          case "zip":
                          echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-archive-o"></i> </a>';
                          break;

                          case "mp3":
                          case "wav":
                          case "m3a":
                          echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-film"></i> </a>';
                          break;

                          case "mp4":
                          case "3gp":
                          case "mpeg":
                          case "wmv":
                          echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-audio-o"></i> </a>';
                          break;

                          case "csv":
                          case "xls":
                          case "xlsx":
                          echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-excel-o"></i> </a>';
                          break;

                          case "ppt":
                          case "pptx":
                          echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-powerpoint-o"></i> </a>';
                          break;

                          case "png":
                          case "jpg":
                          case "psd":
                          case "svg":
                          case "gif":
                          echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-image-o"></i> </a>';
                          break;

                          case "txt":
                          echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-text-o"></i> </a>';
                          break;

                          case null:
                          case "":
                          echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-o"></i> </a>';
                          break;

                          default:
                          echo '<a href="https://www.lapor.go.id/home/download/lampiran/'.$lamp->id.'"> <i class="fa fa-file-o"></i> </a>';
                          break;

                        } ?>
                      </div>
                      <?php }
                      echo "</div></div>";
                      ?>

                      <?php } ?>
                    </div>
                  </div>
                  <?php }}} ?>
                  <div id="komen">

                    <?php if(!isset($tindaklanjut)){ ?>
                    <div class="comment"><h7>Komentar</h7>

                      <?php }if(isset($komen)&&!isset($komen->error)){foreach($komen as $koms){ ?>

                      <div class="col-xs-12 div-notif">
                        <div class="col-xs-2 left-zero">
                          <img class="komentar-img" src="<?php echo (!empty($koms->hash_photo))?"https://www.lapor.go.id/images/users/thumb/thumb_".$koms->hash_photo.".jpg":"https://www.lapor.go.id/assets/style/lapor/images/profile-picture.png"; ?>"/>
                        </div>

                        <div class="col-xs-10 right-zero">
                          <h6 class="time"><?php 
                            $d = date_create($koms->tanggal);
                            $now = date_create(date("Y-m-d"));
                            $diff=date_diff($d,$now);
                            if($diff->y != 0) echo $diff->y." tahun lalu";
                            else if($diff->m != 0 ) echo $diff->m." bulan lalu";
                            else if($diff->d != 0 ) echo $diff->d." hari lalu";
                            else if($diff->h != 0) echo $diff->h." jam lalu";
                            else if($diff->i != 0) echo $diff->i." menit lalu";
                            else if($diff->s != 0) echo $diff->s." detik lalu";
                            ?></h6>
                            <h6><?php echo $koms->first_name." ".$koms->last_name;?></h6>

                            <hr class="simple-divider">
                            <p> <?php echo $koms->content; ?> </p>
                          </div>
                        </div>
                        <?php } 
                        echo "<hr>";
                      } ?>

                    </div>

                    <?php if($user_id==$resp->user_id&&isset($tindaklanjut)&&$resp->status!=9&&($resp->status==5||$resp->status==7||$resp->status==1)) {?>

                    <div class="tlbar"><h7>Tambahkan Tindak Lanjut</h7>
                      <form action="<?php echo base_url().'kirimtindaklanjut';?>" method="post" enctype="multipart/form-data">
                        <textarea class="form-control" rows="5" id="lapor" name="tindaklanjut" placeholder="Tulis Tindak Lanjut..."></textarea>
                        <input type="hidden" name="nid" value="<?php echo $resp->nid;?>"></input>
                        <div class="form-group">
                          <label class="control-label">Tambahkan Data Pendukung :</label>
                          <input type="file" class="btn upload" name='userfile[]' multiple/>
                        </div>
                        <input type="hidden" name="nid" value="<?php echo $resp->nid;?>"></input>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                        <input type="submit" class="btn btn-xs btn-danger full" value="Kirim Tindak Lanjut" />
                      </form>

                      <?php }if(!isset($tindaklanjut)){ ?>

                      <form action="<?php echo base_url().'kirimkomentar';?>" method="post" enctype="multipart/form-data">
                        <textarea class="form-control" rows="5" id="lapor" name="komentar" placeholder="Tulis Komentar..."></textarea>
                        <input type="hidden" name="nid" value="<?php echo $resp->nid;?>"></input>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="submit" class="btn btn-xs btn-komen btn-default full" value="Kirim Komentar" />
                      </form>
                      <?php } ?>
                    </div>
                  </div>
                  <?php 
                  $last = $resp->last_activity;
                } ?>

                <?php if(isset($nextempty)){if(!$nextempty){?>
                <div class="col-xs-12">
                  <?php if(isset($laporanku)){ ?>
                  <a href="<?php echo base_url()."laporanku/".$last;?>" class="text-center nextlaporan pull-right">Laporanku Sebelumnya <i class="fa fa-caret-down"></i></a>

                  <?php } else{?>

                  <a href="<?php echo base_url()."streams/0/".$last;?>" class="text-center nextlaporan pull-right">Laporan Sebelumnya <i class="fa fa-caret-down"></i></a>

                  <?php } } } ?>
                </div>

                <?php }else if(isset($stream->error)){?>
                <div class="row">
                  <div class="col-xs-12">
                    <h4 class="text-center nextlaporan pull-right">Tidak Dapat Mengambil Laporan</h4>
                  </div>
                </div>
                <hr class="simple-divider">

                <?php } 
                else{?>
                <div class="row">
                  <div class="col-xs-12">
                    <h4 class="text-center nextlaporan pull-right">Tidak Ada Laporan</h4>
                  </div>
                </div>
                <hr class="simple-divider">
                <?php } ?>