<?php
$this->load->view('template/header');
?>

<div id="top" class="container">
  <div class="row box">

    <?php $this->load->view('template/topbar'); ?>
  
      <div class="row">
         <ul class="nav nav-tabs">
          <li role="presentation" class="active"><a href="<?php echo base_url(); ?>beranda"><i class="fa fa-home"></i> Beranda</a></li>
          <li role="presentation"><a href="<?php echo base_url(); ?>laporanku"><i class="fa fa-file-text-o"></i> Laporanku</a></li>
          <li role="presentation"><a href="<?php echo base_url(); ?>profil/main"><i class="fa fa-user"></i> Profil</a></li>
      </ul>
  </div>

  <hr class="simple-divider">
  </div>  

  <?php 
  if($this->session->userdata('level') == 1){
    ?>

    <?php $this->load->view('template/message');?>

  <form class="lapor" action="<?php echo base_url(); ?>send" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label class="laporlabel"for="lapor"><strong>Lapor :</strong></label>

      <div class="pull-right ">
        <div class="fifty check checkbox">
          <label >
            <input type="checkbox" class="check" name="rahasia">
            <div class="hover">
              <div class="tooltip"><p class="text-center">Laporan anda akan dirahasiakan dari publik</p></div>
              <span class="btn btn-sm full btn-default">Rahasia</span>
            </div>
          </label>
        </div>

        <div class="checkbox check">
          <label>
            <input type="checkbox" name="anonim">
            <div class="hover">
              <div class="tooltip2 pull-right"><p class="text-center">Nama anda akan tidak akan ditampilkan ke publik</p></div>
              <span class="btn btn-sm full btn-default">Anonim</span>
            </div>
          </label>
        </div>
      </div>
      <textarea class="form-control" rows="5" id="lapor" name="laporan" placeholder="Laporan Anda di sini.."></textarea>
    </div>


    <div class="form-group">      
      <label class="control-label">Upload Data Pendukung :</label>
      <!--<input id= "userfile" type="file" class="btn upload" name="userfile">-->
      <table id="tabelUpload">
        <tr>
          <td>
            <!--<input type="text" name="txtRow1" id="txtRow1" size="40" />-->
            <input id= "userfile" type="file" class="btn upload" name="userfile[]">
          </td>                    
        </tr>        
      </table>
      <span class="btn btn-sm btn-default" onclick="createNewRow()">Tambah</span>
      <span class="btn btn-sm btn-default" onclick="deleteRow()">Hapus</span>         
    </div>
    <div class="form-group">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

      <button type="submit" class="full btn btn-danger">Laporkan</button>
    </div>
    
  </form>
  <?php } ?>

  <div class="row box padbot">
    
    <hr class="home-separator">
     <h3 class="text-center"><strong>Laporan Terbaru</strong></h3>
    <div class="row laporandiv">  
     
<?php $this->load->view('template/laporan');?>
   
  </div>
</div>

<?php
$this->load->view('template/top');
?>
</div>

<script>
function createNewRow() {
  var table = document.getElementById("tabelUpload");
  var lastRow = table.rows.length;
  var row = table.insertRow(0);
  var cell1 = row.insertCell(0); 
  cell1.innerHTML = '<input id="userfile" type="file" class="btn upload" name="userfile[]">';  
}

function deleteRow(){
  document.getElementById("tabelUpload").deleteRow(0);
}
</script>

<?php
$this->load->view('template/footer');
?>

