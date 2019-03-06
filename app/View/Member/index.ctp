<div class="row-fluid">

  <div id="alertMessage" class="alert" style="display: none;">
		<h3></h3>
  </div>

	<div class="alert">
		<h3>Member Migration Form</h3>
	</div>

  <?php
    echo $this->Form->create('Member', ['type' => 'file', 'id' => 'memberForm']);
    echo $this->Form->input('file', array('label' => 'File Upload', 'type' => 'file'));
    echo $this->Form->submit('Upload', array('class' => 'btn btn-primary'));
    echo $this->Form->end();
  ?>
  <div class="modal fade" id="modalLoader" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <div class="loader"></div>
          <div clas="loader-txt">
            <small>Migrating file...</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.loader {
  position: relative;
  text-align: center;
  margin: 15px auto 35px auto;
  z-index: 9999;
  display: block;
  width: 80px;
  height: 80px;
  border: 10px solid rgba(0, 0, 0, .3);
  border-radius: 50% !important;
  border-top-color: #000;
  box-sizing: border-box;
  animation: spin 1s ease-in-out infinite;
  -webkit-animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

@-webkit-keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

.modal-content {
  border-radius: 0px;
  box-shadow: 0 0 20px 8px rgba(0, 0, 0, 0.7);
}

.modal-backdrop.show {
  opacity: 0.75;
}

.loader-txt {
  small {
    font-size: 11.5px;
    color: #999;
  }
}
</style>

<?php $this->start('script_own');?>
<script>
$(document).ready(function() {
  function showAlert(message, state) {
    $('#alertMessage').attr('class', `alert alert-${state}`);
    $('#alertMessage').show();
    $('#alertMessage > h3').html(message);
  };

	$('#memberForm').submit(function(e) {
    e.preventDefault();

    $('#alertMessage').hide();
    $("#modalLoader").modal({
      backdrop: "static",
      keyboard: false,
      show: true
    });

    $.ajax({
      url: "<?php echo Router::url(array('controller' => 'Member', 'action' =>'upload_excel'), true); ?>",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache : false,
      processData: false,
      success: function(data) {
        $('#modalLoader').modal('hide');
        $('input[type="file"]').val('');
        $('#alertMessage').show();
        showAlert('Migration Successful', 'success');
      },
      error: function(error) {
        $('#modalLoader').modal('hide');
        showAlert('Invalid File Type', 'error');
      }
    });
  });
});
</script>
<?php $this->end();?>