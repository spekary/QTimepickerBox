<?php
	require('../../../framework/qcubed.inc.php');
	
	use QCubed\Plugins\QTimepickerBox;

	class SampleForm extends QForm {
		protected $txtTimepicker1;
		protected $txtTimepicker2;
		
		protected function Form_Create() {
			$this->txtTimepicker1 = new QTimepickerBox($this);
			
			$this->txtTimepicker2 = new QTimepickerBox($this);
			$this->txtTimepicker2->SetStartEndHours (6, 17);
			$this->txtTimepicker2->SetStartEndIntervalMinutes (0, 45, 15);
			$this->txtTimepicker2->ShowPeriod = true;
			$this->txtTimepicker2->Rows = 2;
			$this->txtTimepicker2->ShowLeadingZero = false;
		}		
	}

	SampleForm::Run('SampleForm');
?>