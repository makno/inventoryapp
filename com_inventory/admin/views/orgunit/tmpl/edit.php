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
		if (task == 'orgunit.cancel' || document.formvalidator.isValid(document.id('orgunit-form'))) {
			Joomla.submitform(task, document.getElementById('orgunit-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_inventory&layout=edit&orgunit_id=' . (int) $this->item->orgunit_id); ?>" method="post" name="adminForm" id="orgunit-form" class="form-validate">

	<div class="form-horizontal">

		<div class="row-fluid">
			<div class="span9">
				<div class="form-vertical">
					<?php echo $this->form->getControlGroup('orgunit_id'); ?>
					<?php echo $this->form->getControlGroup('name'); ?>
					<?php echo $this->form->getControlGroup('shortdescription'); ?>
				</div>
			</div>
		</div>
		
	</div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
