<div class="alert">
<button class="close" data-dismiss="alert"></button>
Question: Advanced Input Field</div>

<p>
1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.
</p>

<p>
2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field
<?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]

</p>

<div class="alert alert-success">
<button class="close" data-dismiss="alert"></button>
The table you start with</div>

<table class="table table-striped table-bordered table-hover">
<thead>
	<th>
		<span id="add_item_button" class="btn mini green addbutton">
			<i class="icon-plus"></i>
		</span>
	</th>
	<th>Description</th>
	<th>Quantity</th>
	<th>Unit Price</th>
</thead>

<tbody>
	<tr>
		<td>
			<span class="btn mini removebutton">
				<i class="icon-remove"></i>
			</span>
		</td>
		<td>
			<label class="wrap"></label>
			<textarea name="data[1][description]" class="m-wrap hide" rows="2"></textarea>
		</td>
		<td><label></label><input name="data[1][quantity]" class="hide"></td>
		<td><label></label><input name="data[1][unit_price]" class="hide"></td>
	</tr>
</tbody>

</table>


<p></p>
<div class="alert alert-info ">
<button class="close" data-dismiss="alert"></button>
Video Instruction</div>

<p style="text-align:left;">
<video width="78%" controls>
  <source src="/video/q3_2.mov">
Your browser does not support the video tag.
</video>
</p>

<style>
label {
	width: 100%;
	height: 100%;
}

label.wrap {
	white-space: pre-wrap;
}

textarea {
	width: 100%;
	box-sizing: border-box;
}
</style>

<?php $this->start('script_own');?>
<script>
$(document).ready(function() {
	let index = 2;
	$("#add_item_button").click(function() {
		$('.table').append(`
			<tr id="row_${index}">
				<td>
					<span class="btn mini removebutton">
						<i class="icon-remove"></i>
					</span>
				</td>
				<td>
					<label class="wrap"></label>
					<textarea name="data[${index}][description]" class="m-wrap hide" rows="2"></textarea>
				</td>
				<td><label></label><input name="data[${index}][quantity]" class="hide"></td>
				<td><label></label><input name="data[${index}][unit_price]" class="hide"></td>
			</tr>
		`);
		index++;
	});

	$('.removebutton').live('click', function() {
		$(this).closest('tr').remove();
	});

	$('td').live('click', function() {
		let labelElem = $($(this).children()[0]);
		let inputElem = $($(this).children()[1]);
		if (inputElem.hasClass('hide')) {
			labelElem.addClass('hide');
			inputElem.removeClass('hide');
			inputElem.val(labelElem.html());
			inputElem.focus();
		}
	});

	$('textarea, input').live('blur', function() {
		let labelElem = $($(this).prev());
		let inputElem = $(this);
		labelElem.html(inputElem.val());
		labelElem.removeClass('hide');
		inputElem.addClass('hide');
	});
});
</script>
<?php $this->end();?>

