<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

class JFormFieldQrcodesvg extends JFormFieldTextarea{
	
	protected $type = 'qrcodesvg';
	
	protected function getInput()
	{
		// Translate placeholder text
		$hint = $this->translateHint ? JText::_($this->hint) : $this->hint;
	
		// Initialize some field attributes.
		$class        = !empty($this->class) ? ' class="' . $this->class . '"' : '';
		$disabled     = $this->disabled ? ' disabled' : '';
		$readonly     = $this->readonly ? ' readonly' : '';
		$columns      = $this->columns ? ' cols="' . $this->columns . '"' : '';
		$rows         = $this->rows ? ' rows="' . $this->rows . '"' : '';
		$required     = $this->required ? ' required aria-required="true"' : '';
		$hint         = $hint ? ' placeholder="' . $hint . '"' : '';
		$autocomplete = !$this->autocomplete ? ' autocomplete="off"' : ' autocomplete="' . $this->autocomplete . '"';
		$autocomplete = $autocomplete == ' autocomplete="on"' ? '' : $autocomplete;
		$autofocus    = $this->autofocus ? ' autofocus' : '';
		$spellcheck   = $this->spellcheck ? '' : ' spellcheck="false"';
	
		// Initialize JavaScript field attributes.
		$onclick = $this->onclick ? ' onclick="' . $this->onclick . '"' : '';
	
		// Including fallback code for HTML5 non supported browsers.
		JHtml::_('jquery.framework');
		JHtml::_('script', 'system/html5fallback.js', false, true);
		
		$qrcodeElement = '<div id="mkQRCode">'.$this->value.'</div>';
	
		return '<textarea name="' . $this->name . '" id="' . $this->id . '"' . $columns . $rows . $class
		. $hint . $disabled . $readonly  . $onclick . $required . $autocomplete . $autofocus . $spellcheck . ' >'
				. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '</textarea>'.$qrcodeElement;
	}
	

	
}