<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // No direct access

/**
 * @package     it+kapfenberg
 * @subpackage  com_invneotry
 *
 * @copyright   Copyright (C) 2014 Jürgen Kiendler, Mathias Knoll All rights reserved.
 */

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');

$app = JFactory::getApplication();
$input = $app->input;
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task){
		if (task == 'device.cancel' || document.formvalidator.isValid(document.id('device-form'))) {
			Joomla.submitform(task, document.getElementById('device-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_inventory&layout=edit&device_id=' . (int) $this->item->device_id); ?>" method="post" name="adminForm" id="device-form" class="form-validate">

	<div class="form-horizontal">

		<div class="row-fluid">
			<div class="span9">
				<div class="form-vertical">
					<?php echo $this->form->getControlGroup('device_id'); ?>
					<?php echo $this->form->getControlGroup('devicename'); ?>			
					<?php echo $this->form->getControlGroup('imageurl'); ?>
					<?php echo $this->form->getControlGroup('snumber'); ?>
					<?php echo $this->form->getControlGroup('shortdescription'); ?>
					<?php echo $this->form->getControlGroup('description'); ?>
					<?php echo $this->form->getControlGroup('location'); ?>
					<?php echo $this->form->getControlGroup('orgunit'); ?>
					<?php echo $this->form->getControlGroup('qrcode'); ?>
					<?php echo $this->form->getControlGroup('qrcodesvg'); ?>
					<?php echo $this->form->getControlGroup('tags'); ?>
					<?php echo $this->form->getControlGroup('active'); ?>
					
				</div>
			</div>
		</div>
		
	</div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
