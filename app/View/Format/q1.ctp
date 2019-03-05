
<div id="message1">


<?php echo $this->Form->create('Type',array('id'=>'form_type','type'=>'file','url'=>array('controller'=>'format', 'action'=>'q1_success'),'method'=>'POST','autocomplete'=>'off','inputDefaults'=>array(
				
				'label'=>false,'div'=>false,'type'=>'text','required'=>false)))?>
	
<?php echo __("Hi, please choose a type below:")?>
<br><br>

<?php $options_new = array(
 		'Type1' => __('<span class="showPopover" data-id="popover_1" style="color:blue">Type1</span><div id="popover_1" class="hide" title="Type 1">
 				<span style="display:inline-block"><ul><li>Description .......</li>
 				<li>Description 2</li></ul></span>
 				</div>'),
		'Type2' => __('<span class="showPopover" data-id="popover_2" style="color:blue">Type2</span><div id="popover_2" class="hide" title="Type 2">
 				<span style="display:inline-block"><ul><li>Desc 1 .....</li>
 				<li>Desc 2...</li></ul></span>
 				</div>')
		);?>

<?php echo $this->Form->input('type', array('legend'=>false, 'type' => 'radio', 'options'=>$options_new,'before'=>'<label class="radio line notcheck">','after'=>'</label>' ,'separator'=>'</label><label class="radio line notcheck">'));?>

<?php echo $this->Form->submit('Save', array('id' => 'saveBtn', 'class' => 'hide btn btn-primary')); ?>

<?php echo $this->Form->end();?>

</div>

<style>
.showPopover:hover{
	text-decoration: underline;
}

#message1 .radio{
	vertical-align: top;
	font-size: 13px;
}

.control-label{
	font-weight: bold;
}

.wrap {
	white-space: pre-wrap;
}

</style>

<?php $this->start('script_own')?>
<script>

$(document).ready(function(){
	$('.showPopover').each(function() {
		let id = $(this).data('id');
		let elem = $(`#${id}`);

		$(this).popover({
			title: elem.attr('title'),
			content: elem.html(),
			html: true,
			trigger: 'hover'
		});
	});

	$('input[type=radio]').change(function(){
		$('#saveBtn').removeClass('hide');
	});
});

</script>
<?php $this->end()?>