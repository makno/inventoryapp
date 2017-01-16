<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

class JFormFieldQrcode extends JFormFieldText {

	protected $type = 'qrcode';
	protected $field = 'mkQRCode';
	protected $qrcodesvgfield = 'qrcodesvg';

	protected  function getInput()
	{
		// Translate placeholder text
		$hint = $this->translateHint ? JText::_($this->hint) : $this->hint;
	
		// Initialize some field attributes.
		$size         = !empty($this->size) ? ' size="' . $this->size . '"' : '';
		$maxLength    = !empty($this->maxLength) ? ' maxlength="' . $this->maxLength . '"' : '';
		$class        = !empty($this->class) ? ' class="' . $this->class . '"' : '';
		$readonly     = $this->readonly ? ' readonly' : '';
		$disabled     = $this->disabled ? ' disabled' : '';
		$required     = $this->required ? ' required aria-required="true"' : '';
		$hint         = $hint ? ' placeholder="' . $hint . '"' : '';
		$autocomplete = !$this->autocomplete ? ' autocomplete="off"' : ' autocomplete="' . $this->autocomplete . '"';
		$autocomplete = $autocomplete == ' autocomplete="on"' ? '' : $autocomplete;
		$autofocus    = $this->autofocus ? ' autofocus' : '';
		$spellcheck   = $this->spellcheck ? '' : ' spellcheck="false"';
		$pattern      = !empty($this->pattern) ? ' pattern="' . $this->pattern . '"' : '';
		$inputmode    = !empty($this->inputmode) ? ' inputmode="' . $this->inputmode . '"' : '';
		$dirname      = !empty($this->dirname) ? ' dirname="' . $this->dirname . '"' : '';
		
		// References to changable field
		$qrcodesvgfield = !empty($this->qrcodesvgfield) ? ' qrcodesvgfield="' . $this->qrcodesvgfield . '"' : '';
		
		// Initialize JavaScript field attributes.
		$onchange = ' onkeyup="checkQRCode(this);"';
		$onchange .= ' onchange="getQRCode(this);"';
	
		// Including fallback code for HTML5 non supported browsers.
		JHtml::_('jquery.framework');
		JHtml::_('script', 'system/html5fallback.js', false, true);
	
		$datalist = '';
		$list     = '';
	
		/* Get the field options for the datalist.
			Note: getSuggestions() is deprecated and will be changed to getOptions() with 4.0. */
		$options  = (array) $this->getSuggestions();
	
		if ($options)
		{
			$datalist = '<datalist id="' . $this->id . '_datalist">';
	
			foreach ($options as $option)
			{
				if (!$option->value)
				{
					continue;
				}
	
				$datalist .= '<option value="' . $option->value . '">' . $option->text . '</option>';
			}
	
			$datalist .= '</datalist>';
			$list     = ' list="' . $this->id . '_datalist"';
		}
	
		$ajaxScript = $this->getAjaxScript() . $this->getQRCodeScript($this->qrcodesvgfield);
		$ajaxMessage = '&nbsp;<span id="mkQRCodeMessage"></span>'."\n";
		
		
		
		$html[] = $ajaxScript;
		$html[] = '<input type="text" name="' . $this->name . '" id="' . $this->id . '"' . $dirname . ' value="'
				. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '"' . $class . $size . $disabled . $readonly . $list
				. $hint . $onchange . $maxLength . $required . $autocomplete . $autofocus . $spellcheck . $inputmode . $pattern . $qrcodesvgfield . ' />';
		$html[] = $datalist;
		$html[] = $ajaxMessage;
	
		return implode($html);
	}

	private function getAjaxScript(){
		$script = "\n";
		$script .= '<script type="text/javascript">'."\n";
		$script .= 'function checkQRCode(field){'."\n";
		$script .= '	jQuery.ajax({'."\n";
		$script .= '		url:\''.JURI::root().'/index.php?option=com_inventory&controller=qrcode&format=raw&tmpl=component\','."\n";
		$script .= '		type:\'POST\','."\n";
		$script .= '		data: \'qrcode=\'+field.value,'."\n";
		$script .= '		dataType: \'json\','."\n";
		$script .= '		success:function(data)'."\n";
		$script .= '		{'."\n";
		$script .= '			if(data)'."\n";
		$script .= '			{'."\n";
		$script .= '				if(data.hasCode){'."\n";
		$script .= '					jQuery("#mkQRCodeMessage").html(data.msg);'."\n";
		$script .= '				}else{'."\n";
		$script .= '					jQuery("#mkQRCodeMessage").html();'."\n";
		$script .= '			    }'."\n";		
		$script .= '			}'."\n";
		$script .= '		},'."\n";
		$script .= '		error:function(data)'."\n";
		$script .= '		{'."\n";
		$script .= '			jQuery("#mkQRCodeMessage").html(data.msg);'."\n";
		$script .= '		}'."\n";
		$script .= '	});	'."\n";
		$script .= '}'."\n";
		$script .= '</script>'."\n";
		
		return $script; 
	}
	
	private function getQRCodeScript($field){
		$script = "\n";
		$script .= '<script type="text/javascript">'."\n";
		$script .= 'function getQRCode(field){'."\n";
		$script .= '	jQuery.ajax({'."\n";
		$script .= '		url:\''.JURI::root().'/index.php?option=com_inventory&controller=qrcode&format=raw&tmpl=component\','."\n";
		$script .= '		type:\'POST\','."\n";
		$script .= '		data: \'qrcode=\'+field.value,'."\n";
		$script .= '		dataType: \'json\','."\n";
		$script .= '		success:function(data)'."\n";
		$script .= '		{'."\n";
		$script .= '			if(data)'."\n";
		$script .= '			{'."\n";
		$script .= '				if(data.hasSVG){'."\n";
		$script .= '					jQuery("textarea[name=\'jform['.$field.']\']").html(data.qrcode);'."\n";
		$script .= '					jQuery("#'.$this->field.'").html(data.qrcode);'."\n";
		$script .= '				}else{'."\n";
		$script .= '					jQuery("#'.$this->field.'").html();'."\n";
		$script .= '			    }'."\n";
		$script .= '			}'."\n";
		$script .= '		},'."\n";
		$script .= '		error:function(data)'."\n";
		$script .= '		{'."\n";
		$script .= '			jQuery("#mkQRCodeMessage").html(data.msg);'."\n";
		$script .= '		}'."\n";
		$script .= '	});	'."\n";
		$script .= '}'."\n";
		$script .= '</script>'."\n";
	
		return $script;
	}

}
?>