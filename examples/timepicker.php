<?php
	require('../../../framework/qcubed.inc.php');

	class SampleForm extends QForm {
		protected $txtTimepicker1;

		protected function Form_Create() {
			$this->txtTimepicker1 = new QTimepickerBox($this);
		}		
	}

	SampleForm::Run('SampleForm');
?>