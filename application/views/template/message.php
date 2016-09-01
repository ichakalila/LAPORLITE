
<?php if($this->session->flashdata('alert') != null){?>
<br>
<div class="alert alert-<?php echo $this->session->flashdata('alertType'); ?>" role="alert">
  <p><strong><?php echo $this->session->flashdata('alertTitle'); ?> </strong>
    <?php echo $this->session->flashdata('alert'); ?></p>
</div>
<?php } 
