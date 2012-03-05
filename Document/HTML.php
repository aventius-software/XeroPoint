<?php
/**
 * XeroPoint document HTML class
 * 
 * @author Ben Riley <ben.riley@gmail.com>
 */

class XeroPoint_Document_HTML {
	
	/**
	 * holds the body of html for the document
	 * 
	 * @var string
	 */
	protected $body = '';
	
	/**
	 * entries for the header tag
	 * 
	 * @var array
	 */
	protected $head = array ();
	
	/**
	 * holds any linked CSS 
	 * 
	 * @var array
	 */
	protected $linkedCSS = array ();
	
	/**
	 * holds any linked scripts
	 * 
	 * @var array
	 */
	protected $linkedScripts = array ();
	
	/**
	 * holds the document title
	 * 
	 * @var string
	 */
	protected $title;
	
	/**
	 * alias for getHtml()
	 * 
	 * @return string
	 */
	public function __toString() {
		return $this->getHtml ();
	}
	
	/**
	 * add string to the current html body
	 * 
	 * @param string $html
	 * @return XeroPoint_Document_HTML
	 */
	public function addBodyHtml($html) {
		$this->body .= $html;
		return $this;
	}
	
	/**
	 * add a CSS link to the document
	 * 
	 * @param string $cssURI
	 * @return XeroPoint_Document_HTML
	 */
	public function addLinkedCSS($cssURI) {
		$this->linkedCSS [] = $cssURI;
		return $this;
	}
	
	/**
	 * add a script link to the document
	 * 
	 * @param string $scriptURI
	 * @return XeroPoint_Document_HTML
	 */
	public function addLinkedScript($scriptURI) {
		$this->linkedScripts [] = $scriptURI;
		return $this;
	}
	
	/**
	 * return the current html of the document body
	 * 
	 * @return string
	 */
	public function getBodyHtml() {
		return $this->body;
	}
	
	/**
	 * return the current html for the document head
	 * 
	 * @return string
	 */
	public function getHeadHtml() {
		return '<title>' . $this->title . '</title><meta http-equiv="content-type" content="text/html;charset=utf-8"/>' . implode ( '', $this->head );
	}
	
	/**
	 * return the complete html output for this document
	 * 
	 * @return string
	 */
	public function getHtml() {
		// add the header tag
		$html = '<head>' . $this->getHeadHtml () . '</head>';
		
		// and the main body
		$html .= '<body>' . $this->body . '</body>';
		
		// now return the complete document
		return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml">' . $html . '</html>';
	}
	
	/**
	 * return the current list of linked CSS URI's
	 * 
	 * @return array
	 */
	public function getLinkedCSS() {
		return $this->linkedCSS;
	}
	
	/**
	 * return the current list of linked script URI's
	 * 
	 * @return array
	 */
	public function getLinkedScripts() {
		return $this->linkedScripts;
	}
	
	/**
	 * return the current document title
	 * 
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * set the html for the document body
	 * 
	 * @param string $html
	 * @return XeroPoint_Document_HTML
	 */
	public function setBodyHtml($html) {
		$this->body = $html;
		return $this;
	}
	
	/**
	 * set the title of the document
	 * 
	 * @param string $title
	 * @return XeroPoint_Document_HTML
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}
}