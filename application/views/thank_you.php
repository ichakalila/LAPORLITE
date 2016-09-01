<?php
$this->load->view('template/header');
?>
    <div id="top"class="container">
        <div class="row box2">
            <h3 class="text-center"> Terima Kasih Telah Melapor</h3>
            <div class="panel panel-default">
              <div class="panel-body">
                <strong>Tracking ID Anda :</strong> {nid}
            </div>
        </div>
        <a href="<?php echo base_url()?>" class="btn full btn-danger">Kembali Ke LAPOR! Lite</a> 
        <br><br>
        <a href="<?php echo base_url().'laporan/'?>{nid}" class="btn full btn-default">Lihat Laporan Anda</a>  
    </div>
</div>
<?php
$this->load->view('template/footer');
?>