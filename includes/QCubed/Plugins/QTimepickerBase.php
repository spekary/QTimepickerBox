<?php
	/** 
	*
	*	API for the jquery.ui.timepicker.js jQuery widget. This closely reflects what
	*	is in the actual jQuery plugin.
	*
	* @property string $TimeSeparator The character to use to separate hours and minutes. (default: ':')
	* @property bool $ShowLeadingZero Define whether or not to show a leading zero for hours < 10. (default: true)
	* @property bool $ShowMinutesLeadingZero Define whether or not to show a leading zero for minutes < 10. (default: true)
	* @property bool $ShowPeriod Define whether or not to show AM/PM with selected time. (default: false)
	* @property bool $ShowPeriodLabels Define if the AM/PM labels on the left are displayed. (default: true)
	* @property string $PeriodSeparator The character to use to separate the time from the time period.
	* @property string $AltField Define an alternate input to parse selected time to
	* @property string $DefaultTime Used as default time when input field is empty or for inline 
	* 		timePicker (set to 'now' for the current time, '' for no highlighted time, default value: now)
	* @property string $ShowOn Define when the timepicker is shown.
	*                          'focus': when the input gets focus, 'button' when the button trigger element is clicked,
	*                          'both': when the input gets focus and when the button is clicked.
	* @property string $Button jQuery selector that acts as button trigger. ex: '#trigger_button'
	* @property string $HourText Define the locale text for "Hours"
	* @property string $MinuteText Define the locale text for "Minute"
	* @property string $AmPmText Define the locale text for periods
	* @property string $MyPosition Corner of the dialog to position, used with the jQuery UI Position utility if present.
	* @property string $AtPosition Corner of the input to position
	* @property string $AtPosition Corner of the input to position
	* @property array $HoursArray Custom hours. Keys: 
	* 	 starts:0		 number to start with 
	* 	 ends:23 		 number to end with
	* @property array $MinutesArray Custom minutes. Keys: 
	*	 starts: 0,                 First displayed minute
	*   ends: 55,                  Last displayed minute
	*   interval: 5                Interval of displayed minutes
	* @property int $Rows Number of rows for the input tables, minimum 2, makes more sense if you use multiple of 2
	* @property bool $ShowHours Define if the hours section is displayed or not. Set to false to get a minute only dialog
	* @property bool $ShowMinutes Define if the minutes section is displayed or not. Set to false to get an hour only dialog
	* @property bool $ShowCloseButton Shows an OK button to confirm the edit
	* @property string $CloseButtonText Text for the confirmation button (ok button)
	* @property bool $ShowNowButton Shows the 'now' button
	* @property string $NowButtonText Text for the now button
	* @property bool $ShowDeselectButton Shows the deselect time button
	* @property string $DeselectButton Text for the deselect button
	*/
	namespace QCubed\Plugins;
	use \QTextBox, \QType, \JavascriptHelper;
	
	class QTimepickerBase extends QTextBox	{
		/** @var boolean */
		protected $blnDisabled = null;
		/** @var string */
		protected $strButton = null;
		/** @var string */
		protected $strTimeSeperator = null;
		/** @var boolean */
		protected $blnShowPeriod = null;
		/** @var boolean */
		protected $blnShowPeriodLabels = null;
		/** @var boolean */
		protected $blnShowLeadingZero = null;
		/** @var boolean */
		protected $blnShowMinutesLeadingZero = null;
		/** @var string */
		protected $strPeriodSeparator = null;
		/** @var string */
		protected $strAltField = null;
		/** @var string */
		protected $strDefaultTime = null;
		/** @var string */
		protected $strShowOn = null;
		/** @var string */
		protected $strHourText = null;
		/** @var string */
		protected $strMinuteText = null;
		/** @var string */
		protected $strAmPmText = null;
		/** @var string */
		protected $strMyPosition = null;
		/** @var string */
		protected $strAtPosition = null;
		/** @var array */
		protected $mixHoursArray = null;
		/** @var array */
		protected $mixMinutesArray = null;
		/** @var integer */
		protected $intRows = null;
		/** @var boolean */
		protected $blnShowHours = null;
		/** @var boolean */
		protected $blnShowMinutes = null;
		/** @var boolean */
		protected $blnShowCloseButton = null;
		/** @var string */
		protected $strCloseButtonText = null;
		/** @var boolean */
		protected $blnShowNowButton = null;
		/** @var string */
		protected $strNowButtonText = null;
		/** @var boolean */
		protected $blnShowDeselectButton = null;
		/** @var string */
		protected $strDeselectButtonText = null;
		
		/** @var array $custom_events Event Class Name => Event Property Name */
		protected static $custom_events = array(
		);
		
		public function __construct($objParentObject, $strDefaultAreaCode = null, $strControlId = null) {
			parent::__construct($objParentObject, $strControlId);
			
			$this->AddCssFile(__JQUERY_CSS__); // make sure they know 
			$this->AddPluginJavascriptFile("QTimepicker", "jquery.ui.timepicker.js");
			$this->AddPluginCssFile("QTimepicker", "jquery.ui.timepicker.css");
		}
		
		protected function makeJsProperty($strProp, $strKey) {
			$objValue = $this->$strProp;
			if (null === $objValue) {
				return '';
			}

			return $strKey . ': ' . JavaScriptHelper::toJsObject($objValue) . ', ';
		}

		protected function makeJqOptions() {
			$strJqOptions = '';
			$strJqOptions .= $this->makeJsProperty('Button', 'button');
			$strJqOptions .= $this->makeJsProperty('TimeSeperator', 'timeSeperator');
			$strJqOptions .= $this->makeJsProperty('ShowPeriod', 'showPeriod');
			$strJqOptions .= $this->makeJsProperty('ShowPeriodLabels', 'showPeriodLabels');
			$strJqOptions .= $this->makeJsProperty('ShowLeadingZero', 'showLeadingZero');
			$strJqOptions .= $this->makeJsProperty('ShowMinutesLeadingZero', 'showMinutesLeadingZero');
			$strJqOptions .= $this->makeJsProperty('PeriodSeparator', 'periodSeparator');
			$strJqOptions .= $this->makeJsProperty('AltField', 'altField');
			$strJqOptions .= $this->makeJsProperty('DefaultTime', 'defaultTime'); 
			$strJqOptions .= $this->makeJsProperty('ShowOn', 'showOn'); 
			$strJqOptions .= $this->makeJsProperty('HourText', 'hourText');
			$strJqOptions .= $this->makeJsProperty('MinuteText', 'minuteText');
			$strJqOptions .= $this->makeJsProperty('AmPmText', 'amPmText');
			$strJqOptions .= $this->makeJsProperty('MyPosition', 'myPosition');
			$strJqOptions .= $this->makeJsProperty('AtPosition', 'atPosition');
			$strJqOptions .= $this->makeJsProperty('HoursArray', 'hours');
			$strJqOptions .= $this->makeJsProperty('MinutesArray', 'minutes');
			$strJqOptions .= $this->makeJsProperty('Rows', 'rows');
			$strJqOptions .= $this->makeJsProperty('ShowHours', 'showHours');
			$strJqOptions .= $this->makeJsProperty('ShowMinutes', 'showMinutes');
			$strJqOptions .= $this->makeJsProperty('ShowCloseButton', 'showCloseButton');
			$strJqOptions .= $this->makeJsProperty('CloseButtonText', 'closeButtonText');
			$strJqOptions .= $this->makeJsProperty('ShowNowButton', 'showNowButton');
			$strJqOptions .= $this->makeJsProperty('NowButtonText', 'nowButtonText');
			$strJqOptions .= $this->makeJsProperty('ShowDeselectButton', 'showDeselectButton');
			$strJqOptions .= $this->makeJsProperty('DeselectButtonText', 'deselectButtonText');

			if ($strJqOptions) $strJqOptions = substr($strJqOptions, 0, -2);
			return $strJqOptions;
		}

		protected function getJqSetupFunction() {
			return 'timepicker';
		}

		public function GetControlJavaScript() {
			return sprintf('jQuery("#%s").%s({%s})', $this->getJqControlId(), $this->getJqSetupFunction(), $this->makeJqOptions());
		}

		public function GetEndScript() {
			return  $this->GetControlJavaScript() . '; ' . parent::GetEndScript();
		}

		/**
		 * Call a JQuery UI Method on the object.
		 * 
		 * @param string $strMethodName the method name to call
		 * @param mixed[optional] $mixParam1 
		 * @param mixed[optional] $mixParam2 
		 */
		public function CallJqUiMethod($strMethodName, $mixParam1 = null, $mixParam2 = null) {
			$args = array();
			$args[] = $strMethodName;
			if ($mixParam1) {
				$args[] = $mixParam1;
			}
			if ($mixParam2) {
				$args[] = $mixParam2;
			}

			$strArgs = JavaScriptHelper::toJsObject($args);
			$strJs = sprintf('jQuery("#%s").%s(%s)', 
				$this->getJqControlId(),
				$this->getJqSetupFunction(),
				substr($strArgs, 1, strlen($strArgs)-2));	// params without brackets
			QApplication::ExecuteJavaScript($strJs);
		}
		
		/**
		 * Remove the autocomplete functionality completely. This will return the
		 * element back to its pre-init state.
		 */
		public function Destroy() {
			$this->CallJqUiMethod ('destroy');
		}

		/**
		 * Disable the autocomplete.
		 */
		public function Disable() {
			$this->CallJqUiMethod ('disable');
		}

		/**
		 * Enable the autocomplete.
		 */
		public function Enable() {
			$this->CallJqUiMethod ('enable');
		}

		/**
		 * Get or set any autocomplete option. If no value is specified, will act as a
		 * getter.
		 * @param $optionName
		 * @param $value
		 */
		public function Option($optionName, $value = null) {
			$this->CallJqUiMethod ('enable', $optionName, $value);
		}

		/**
		 * Set multiple autocomplete options at once by providing an options object.
		 * @param $options
		 */
		public function Options($options) {
			$this->CallJqUiMethod ('enable', $options);
		}

		/**
		 * returns the property name corresponding to the given custom event
		 * @param QEvent $objEvent the custom event
		 * @return the property name corresponding to $objEvent
		 */
		protected function getCustomEventPropertyName(QEvent $objEvent) {
			$strEventClass = get_class($objEvent);
			if (array_key_exists($strEventClass, QAutocomplete::$custom_events))
				return QAutocomplete::$custom_events[$strEventClass];
			return null;
		}

		/**
		 * Wraps $objAction into an object (typically a QJsClosure) that can be assigned to the corresponding Event
		 * property (e.g. OnFocus)
		 * @param QEvent $objEvent
		 * @param QAction $objAction
		 * @return mixed the wrapped object
		 */
		protected function createEventWrapper(QEvent $objEvent, QAction $objAction) {
			$objAction->Event = $objEvent;
			return new QJsClosure($objAction->RenderScript($this));
		}

		/**
		 * If $objEvent is one of the custom events (as determined by getCustomEventPropertyName() method)
		 * the corresponding JQuery event is used and if needed a no-script action is added. Otherwise the normal
		 * QCubed AddAction is performed.
		 * @param QEvent  $objEvent
		 * @param QAction $objAction
		 */
		public function AddAction($objEvent, $objAction) {
			$strEventName = $this->getCustomEventPropertyName($objEvent);
			if ($strEventName) {
				$this->$strEventName = $this->createEventWrapper($objEvent, $objAction);
				if ($objAction instanceof QAjaxAction) {
					$objAction = new QNoScriptAjaxAction($objAction);
					parent::AddAction($objEvent, $objAction);
				} else if (!($objAction instanceof QJavaScriptAction)) {
					throw new Exception('handling of "' . get_class($objAction) . '" actions with "' . get_class($objEvent) . '" events not yet implemented');
				}
			} else {
				parent::AddAction($objEvent, $objAction);
			}
		}

		public function __get($strName) {
			switch ($strName) {
				case 'Disabled': return $this->blnDisabled;
				case 'Button': return $this->strButton;
				case 'TimeSeperator': return $this->strTimeSeperator;
				case 'ShowPeriod': return $this->blnShowPeriod;
				case 'ShowPeriodLabels': return $this->blnShowPeriodLabels;
				case 'ShowLeadingZero': return $this->blnShowLeadingZero;
				case 'ShowMinutesLeadingZero': return $this->blnShowMinutesLeadingZero;
				case 'PeriodSeparator': return $this->strPeriodSeparator;
				case 'AltField': return $this->strAltField;
				case 'DefaultTime': return $this->strDefaultTime;
				case 'ShowOn': return $this->strShowOn;
				case 'HourText': return $this->strHourText;
				case 'MinuteText': return $this->strMinuteText;
				case 'AmPmText': return $this->strAmPmText;
				case 'MyPosition': return $this->strMyPosition;
				case 'AtPosition': return $this->strAtPosition;
				case 'HoursArray': return $this->mixHoursArray;
				case 'MinutesArray': return $this->mixMinutesArray;
				case 'Rows': return $this->intRows;
				case 'ShowHours': return $this->blnShowHours;
				case 'ShowMinutes': return $this->blnShowMinutes;
				case 'ShowCloseButton': return $this->blnShowCloseButton;
				case 'CloseButtonText': return $this->strCloseButtonText;
				case 'ShowNowButton': return $this->blnShowNowButton;
				case 'NowButtonText': return $this->strNowButtonText;
				case 'ShowDeselectButton': return $this->blnShowDeselectButton;
				case 'DeselectButtonText': return $this->strDeselectButtonText;
				default: 
					try { 
						return parent::__get($strName); 
					} catch (QCallerException $objExc) { 
						$objExc->IncrementOffset(); 
						throw $objExc; 
					}
			}
		}

		public function __set($strName, $mixValue) {
			$this->blnModified = true;

			switch ($strName) {
				case 'Disabled':
					try {
						$this->blnDisabled = QType::Cast($mixValue, QType::Boolean);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					
				case 'Button':
					try {
						$this->strButton = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'TimeSeperator':
					try {
						$this->strTimeSeperator = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					
				case 'ShowPeriod':
					try {
						$this->blnShowPeriod = QType::Cast($mixValue, QType::Boolean);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					
				case 'ShowPeriodLabels':
					try {
						$this->blnShowPeriodLabels = QType::Cast($mixValue, QType::Boolean);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					
				case 'ShowLeadingZero':
					try {
						$this->blnShowLeadingZero = QType::Cast($mixValue, QType::Boolean);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					
				case 'ShowMinutesLeadingZero':
					try {
						$this->blnShowMinutesLeadingZero = QType::Cast($mixValue, QType::Boolean);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
				case 'PeriodSeparator': 					
					try {
						$this->strPeriodSeparator = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
				case 'AltField': 
					try {
						$this->strAltField = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
								case 'DefaultTime': 
					try {
						$this->strDefaultTime = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ShowOn': 
					try {
						$this->strShowOn = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'HourText': 
					try {
						$this->strHourText = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'MinuteText': 
					try {
						$this->strMinuteText = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'AmPmText': 
					try {
						$this->strAmPmText = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'MyPosition': 
					try {
						$this->strMyPosition = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'AtPosition': 
					try {
						$this->strAtPosition = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'HoursArray': 
					try {
						$this->mixHoursArray = QType::Cast($mixValue, QType::ArrayType);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'MinutesArray': 
					try {
						$this->mixMinutesArray = QType::Cast($mixValue, QType::ArrayType);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Rows': 
					try {
						$this->intRows = QType::Cast($mixValue, QType::Integer);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ShowHours': 
					try {
						$this->blnShowHours = QType::Cast($mixValue, QType::Boolean);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ShowMinutes': 
					try {
						$this->blnShowMinutes = QType::Cast($mixValue, QType::Boolean);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ShowCloseButton': 
					try {
						$this->blnShowCloseButton = QType::Cast($mixValue, QType::Boolean);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'CloseButtonText': 
					try {
						$this->strCloseButtonText = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ShowNowButton': 
					try {
						$this->blnShowNowButton = QType::Cast($mixValue, QType::Boolean);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'NowButtonText': 
					try {
						$this->strNowButtonText = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ShowDeselectButton': 
					try {
						$this->blnShowDeselectButton = QType::Cast($mixValue, QType::Boolean);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'DeselectButtonText': 
					try {
						$this->strDeselectButtonText = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					
				default:
					try {
						parent::__set($strName, $mixValue);
						break;
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}
	}

?>
