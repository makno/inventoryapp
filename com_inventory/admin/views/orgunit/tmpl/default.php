<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
 
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		document.getElementById('orgunit-form').task.value = task;
		document.getElementById('orgunit-form').submit();
	}
</script>


<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container" class="span12">
<?php endif;?>

		<form action="<?php echo JRoute::_('index.php?option=com_inventory&controller=orgunit&view=orgunit&layout=default'); ?>" method="post" name="adminForm" id="orgunit-form" class="form-validate">
		
			<div class="form-horizontal">
				
				<input type="hidden" name="orgunit_id" value="<?php if($this->orgunit!=null) echo $this->orgunit->orgunit_id;?>" />
				<input type="hidden" name="table" value="orgunit" />
				<input type="hidden" name="type" value="orgunit" />
				
				<label class="control-label" for="addOrgunbitName"><b>Name</b></label>
				<input class="span12" type="text" id="addOrgunbitName" name="name" placeholder="Name" value="<?php if($this->orgunit!=null) echo $this->orgunit->name;?>"/>
					
				<label class="control-label" for="addOrgunitDescription"><b>Description</b></label>
				<input class="span12" type="text" id="addOrgunitDescription" name="shortdescription" placeholder="Description" value="<?php if($this->orgunit!=null) echo $this->orgunit->shortdescription;?>"/>
				
			</div>
		
			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>
		</form>
    </div>
    
  					