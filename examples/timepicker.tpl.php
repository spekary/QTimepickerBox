<?php require(__DOCROOT__ . __EXAMPLES__ . '/includes/header.inc.php'); ?>
	<?php $this->RenderBegin(); ?>

	<div class="instructions">
		<h1 class="instruction_title">QTimepicker: Formatting and Validation of a time field</h1>

		<b>QTimepickerBox</b> is base on the jquery.ui.timepicker.js file. It allows you to
		quickly pick times for a time field. Highly customizable to let your users quickly choose
		times, but also type in custom times if desired. See
		<a href="http://fgelinas.com/code/timepicker/" target="_blank">Timepicker Home Page</a>
		for a complete description and examples of usage. The styling of the control is a combination
		of options you set, and whatever jQuery UI style you are using.
		
	</div>

	<p>Default: <?php $this->txtTimepicker1->Render(); ?></p>
	<p>US Hours 15-min: <?php $this->txtTimepicker2->Render(); ?></p>
			
	<?php $this->RenderEnd(); ?>
<?php require(__DOCROOT__ . __EXAMPLES__ . '/includes/footer.inc.php'); ?>