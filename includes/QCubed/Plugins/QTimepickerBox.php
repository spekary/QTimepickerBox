<?php

	/**
	*
	* Wrapper for the QTickpickerBase class. This is the glue between the jQuery widget
	* and QCubed. Formatting is based on the current jQuery UI theme.
	*/
	
	namespace QCubed\Plugins;

	class QTimepickerBox extends QTimepickerBase {

		// MISC
		protected $strLabelForInvalid = 'Invalid Time';
				
		public static function ParseForTimeValue($strText) {
			// Trim and Clean
			
			$strText = strtolower(trim($strText));
			while(strpos($strText, '  ') !== false)
				$strText = str_replace('  ', ' ', $strText);
			$strText = str_replace('.', '', $strText);
			$strText = str_replace('@', ' ', $strText);

			// Are we ATTEMPTING to parse a Time value?
			if ((strpos($strText, ':') === false) &&
				(strpos($strText, 'am') === false) &&
				(strpos($strText, 'pm') === false)) {
				// There is NO TIME VALUE
				return null;
			}

			// Add ':00' if it doesn't exist AND if 'am' or 'pm' exists
			if (strpos($strText, 'pm') !== false) {
				if (strpos($strText, ' pm') === false) {
					$strText = str_replace('pm', ' pm', $strText);
				}

				if (strpos($strText, ':') === false) {
					$strText = str_replace(' pm', ':00 pm', $strText, $intCount);
				}
			} else if ((strpos($strText, 'am') !== false)) { 
				if (strpos($strText, ' am') === false) {
					$strText = str_replace('am', ' am', $strText);
				}
				if ((strpos($strText, ':') === false)) {
					$strText = str_replace(' am', ':00 am', $strText);
				}
			}

			$dttToReturn = new QDateTime($strText);
			return $dttToReturn;
		}

		public function SetStartEndHours($intStart, $intEnd) {
			$a = array ('starts'=>$intStart, 'ends'=>$intEnd);
			$this->mixHoursArray = $a;
		}
		
		public function SetStartEndIntervalMinutes($intStart, $intEnd, $intInterval) {
			$a = array ('starts'=>$intStart, 'ends'=>$intEnd, 'interval'=>$intInterval);
			$this->mixMinutesArray = $a;
		}

		public function Validate() {
			if (parent::Validate()) {
				if ($this->strText != "") {
					$dttTest = self::ParseForTimeValue($this->strText);
					if (!$dttTest) {
						$this->strValidationError = $this->strLabelForInvalid;
						return false;
					}
				}
			} else
				return false;

			$this->strValidationError = '';
			return true;
		}
				
		/////////////////////////
		// Public Properties: GET
		/////////////////////////
		public function __get($strName) {
			switch ($strName) {
				// MISC
				case 'DateTime': return self::ParseForTimeValue($this->Text);
				case 'LabelForInvalid': return $this->strLabelForInvalid;
				case 'Minutes': 
					$dttTime = self::ParseForTimeValue($this->strText);
					if ($dttTime) {
						return $dttTime->Hour * 60 + $dttTime->Minute;
					}
					else {
						return 0;
					}
					

				default:
					try {
						return parent::__get($strName);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}

		/////////////////////////
		// Public Properties: SET
		/////////////////////////
		public function __set($strName, $mixValue) {
			$this->blnModified = true;
			
			switch ($strName) {
				// MISC
				case 'DateTime':
					try {
						$dtt = QType::Cast($mixValue, QType::DateTime);
						$this->Text = $dtt->__toString ("h:mm z");
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					
				case 'LabelForInvalid':
					try {
						return ($this->strLabelForInvalid = QType::Cast($mixValue, QType::String));
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
										
				default:
					try {
						parent::__set($strName, $mixValue);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;
			}
		}		
	}
	
	
?>