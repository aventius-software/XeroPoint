<?php
/**
 * XeroPoint control abstract class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 * @package XeroPoint
 */

abstract class XeroPoint_Control_Abstract {
	
	/**
	 * GET method identifier
	 * 
	 * @var string
	 */
	const METHOD_GET = 'get';
	
	/**
	 * POST method identifier
	 * 
	 * @var string
	 */
	const METHOD_POST = 'post';
	
	/**
	 * holds any html that will be appended to the control inside its container
	 * 
	 * @var string
	 */
	protected $appendHtml = '';
	
	/**
	 * holds the name of the container tag to encase controls in (if applicable)
	 * 
	 * @var string
	 */
	protected $container = '';
	
	/**
	 * holds the ID's of all declared controls in a single script
	 * 
	 * @var array
	 */
	protected static $controls = array ();
	
	/**
	 * flag to indicate if this control is disabled or not
	 * 
	 * @var bool
	 */
	protected $disabled = false;
	
	/**
	 * flag to indicate display or not for the controls label
	 * 
	 * @var bool
	 */
	protected $displayLabel = true;
	
	/**
	 * the ID of this control
	 * 
	 * @var string
	 */
	protected $id;
	
	/**
	 * contains the label text
	 * 
	 * @var string
	 */
	protected $label;
	
	/**
	 * holds the max length in characters of a control value (default max of 255)
	 * 
	 * @var int
	 */
	protected $maxLength = 255;
	
	/**
	 * holds the transmission method
	 * 
	 * @var string
	 */
	protected $method;
	
	/**
	 * holds the name of the control
	 * 
	 * @var string
	 */
	protected $name;
	
	/**
	 * holds any html that will be prepended to the control inside its container
	 * 
	 * @var string
	 */
	protected $prependHtml = '';
	
	/**
	 * flag to indicate if this control is readonly or not (default is not readonly)
	 * 
	 * @var bool
	 */
	protected $readOnly = false;
	
	/**
	 * holds the value of this control
	 * 
	 * @var mixed
	 */
	protected $value;
	
	/**
	 * create a new control
	 * 
	 * @param string $id
	 * @param string $method
	 */
	public function __construct($id, $method = self::METHOD_POST) {
		// must specify a form name!
		if (empty ( $id )) {
			throw new Exception ( 'you must specify an id when creating a control' );
		}
		
		// when performing tests reset the cache!
		if (class_exists ( 'PHPUnit_Framework_TestCase' ) && array_key_exists ( $id, self::$controls )) {
			unset ( self::$controls [$id] );
		}
		
		// is this a duplicate form?
		if (in_array ( $id, self::$controls )) {
			throw new Exception ( 'this control is already defined elsewhere in this script' );
		}
		
		// set the id/name of this control
		$this->id = $id;
		
		// save this form
		self::$controls [$id] = $id;
		
		// save the method type
		$this->method = $method;
	}
	
	/**
	 * appends html to the control inside its container (if it has a container that is...)
	 * 
	 * @param string $html
	 * @return XeroPoint_Control_Abstract
	 */
	public function appendHtml($html) {
		$this->appendHtml = $html;
		return $this;
	}
	
	/**
	 * returns the append html if any
	 * 
	 * @return string
	 */
	public function getAppendHtml() {
		return $this->appendHtml;
	}
	
	/**
	 * returns the current container for this control, if any is set
	 * 
	 * @return string
	 */
	public function getContainer() {
		return $this->container;
	}
	
	/**
	 * must implement this method to return string for the controls html
	 * 
	 * @return string
	 */
	abstract protected function getControlHtml();
	
	/**
	 * returns the complete html for this control with any label and container
	 * 
	 * @return string
	 */
	public function getHtml() {
		$control = $this->prependHtml . $this->getLabelHtml () . $this->getControlHtml () . $this->appendHtml;
		
		return $this->container == '' ? $control : '<' . $this->container . ' id="' . $this->id . '_container">' . $control . '</' . $this->container . '>';
	}
	
	/**
	 * returns basic html for an input control, lazy sets type as 'text'
	 * 
	 * @param string $type
	 * @param array $extendedAttributes
	 * @return string
	 */
	protected function getInputHtml($type = 'text', $extendedAttributes = array()) {
		// set the ID field
		$id = 'id="' . $this->id . '"';
		
		// is this field disabled?
		$disabled = $this->disabled ? ' disabled="disabled"' : '';
		
		// set the max length
		$maxLength = ' maxlength="' . $this->maxLength . '"';
		
		// set the name field
		$name = is_null ( $this->name ) ? '' : ' name="' . $this->name . '"';
		
		// is this read only?
		$readOnly = $this->readOnly ? ' readonly="readonly"' : '';
		
		// set the type
		$type = ' type="' . $type . '"';
		
		// set the value
		$value = ' value="' . htmlentities ( $this->value ) . '"';
		
		// any extended attributes
		$extensions = '';
		
		foreach ( $extendedAttributes as $attributeName => $attributeValue ) {
			$extensions .= ' ' . $attributeName . '="' . $attributeValue . '"';
		}
		
		// return the xhtml code
		return '<input ' . $id . $name . $type . $maxLength . $readOnly . $disabled . $extensions . $value . '/>';
	}
	
	/**
	 * returns the ID of this control
	 * 
	 * @return string
	 */
	public function getID() {
		return $this->id;
	}
	
	/**
	 * returns this controls label html
	 * note that if no label text has been set this method will return just a blank string and no tags at all
	 * 
	 * @return string
	 */
	public function getLabelHtml() {
		return is_null ( $this->label ) || ! $this->displayLabel ? '' : '<label id="' . $this->id . '_label" for="' . $this->id . '">' . htmlentities ( $this->label ) . '</label>';
	}
	
	/**
	 * returns the current max length of input value in characters for this control
	 * 
	 * @return int
	 */
	public function getMaxLength() {
		return $this->maxLength;
	}
	
	/**
	 * returns the current method for use when collecting value for this control
	 * 
	 * @return string
	 */
	public function getMethod() {
		return $this->method;
	}
	
	/**
	 * returns the name of this control
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * returns the prepend html if any
	 * 
	 * @return string
	 */
	public function getPrependHtml() {
		return $this->prependHtml;
	}
	
	/**
	 * tells this control to not output a label
	 * 
	 * @return XeroPoint_Control_Abstract
	 */
	public function hideLabel() {
		$this->displayLabel = false;
		return $this;
	}
	
	/**
	 * set the html to be prepended to the control inside its container
	 * 
	 * @param string $html
	 * @return XeroPoint_Control_Abstract
	 */
	public function prependHtml($html) {
		$this->prependHtml = $html;
		return $this;
	}
	
	/**
	 * set the container tag for this control e.g. DIV
	 * 
	 * @param string $container
	 * @return XeroPoint_Control_Abstract
	 */
	public function setContainer($container) {
		$this->container = strtolower ( $container );
		return $this;
	}
	
	/**
	 * set the text for this controls label
	 * note that all html will be encoded within the label when it is finally rendered
	 * 
	 * @param string $label
	 * @return XeroPoint_Control_Abstract
	 */
	public function setLabel($label) {
		$this->label = $label;
		return $this;
	}
	
	/**
	 * set the max length for this controls input value
	 * 
	 * @param int $maxLength
	 * @return XeroPoint_Control_Abstract
	 */
	public function setMaxLength($maxLength) {
		if ((is_int ( $maxLength ) || ctype_digit ( $maxLength )) && ( int ) $maxLength > 0) {
			$this->maxLength = $maxLength;
		} else {
			throw new Exception ( 'max control value length specified was not a valid integer value' );
		}
		
		return $this;
	}
	
	/**
	 * set the method for this control
	 * 
	 * @param string $method
	 * @return XeroPoint_Control_Abstract
	 */
	public function setMethod($method) {
		$this->method = $method;
		return $this;
	}
	
	/**
	 * set the name of this control
	 * 
	 * @param string $name
	 * @return XeroPoint_Control_Abstract
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	/**
	 * tells this control to output a label if there is one
	 * 
	 * @return XeroPoint_Control_Abstract
	 */
	public function showLabel() {
		$this->displayLabel = true;
		return $this;
	}
}