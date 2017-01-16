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
		document.getElementById('device-form').task.value = task;
		document.getElementById('device-form').submit();
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

		<form action="<?php echo JRoute::_('index.php?option=com_inventory&controller=device&view=device&layout=default'); ?>" method="post" name="adminForm" id="device-form" class="form-validate">
		
			<h3 id="myModalLabel"><?php echo JText::_('COM_INVENTORY_ADD_DEVICE'); ?></h3>
		
			<div class="row-fluid">

					<p class="span12" id="qrcodemessage" style="color:red;"></p>
					
					<input type="hidden" name="table" value="device" />
					<input type="hidden" name="type" value="device" />
					
					<label class="control-label" for="addDevicename"><?php echo JText::_('COM_INVENTORY_DEVICE_NAME'); ?></label>
					<input class="span12" type="text" id="addDevicename" name="devicename" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_NAME'); ?>" />
					
					<label class="control-label" for="addImageurl"><?php echo JText::_('COM_INVENTORY_DEVICE_IMAGE'); ?></label>
					<input class="span12" type="text" id="addImageurl" name="imageurl" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_IMAGE'); ?>" />
					
					<label class="control-label" for="addSnumber"><?php echo JText::_('COM_INVENTORY_DEVICE_SNUMBER'); ?></label>
					<input type="text" class="span6" id="addSnumber" name="snumber" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_SNUMBER'); ?>" />
					
					<label class="control-label" for="addQrcode"><?php echo JText::_('COM_INVENTORY_DEVICE_QRCODE'); ?></label>
					<input type="text" class="span6" id="addQrcode" name="qrcode" onchange="checkQRCode(this);" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_QRCODE'); ?>" />
					
					<label class="control-label" for="addShortdescription"><?php echo JText::_('COM_INVENTORY_DEVICE_SHORTDESC'); ?></label>
					<input class="span12" type="text" id="addShortdescription" name="shortdescription" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_SHORTDESC'); ?>" />
					
					<div class="span12">
						<label for="descriptionAdd"><?php echo JText::_('COM_INVENTORY_DEVICE_DESCRIPTION'); ?>:</label>
						<?php
							if($this->_editor)
								echo $this->_editor->display( 'description', '', '100%', '300', '20', '20', true, 'descriptionAdd', null, JFactory::getUser()->name, $this->_params );
						?>
					</div>
					
					<label class="control-label" for="addLocation"><?php echo JText::_('COM_INVENTORY_DEVICE_LOCATION'); ?></label>
					<input type="text" class="span6" id="addLocation" name="location" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_LOCATION'); ?>" />
					
					<label class="control-label" for="addOrgunit"><?php echo JText::_('COM_INVENTORY_DEVICE_ORGUNIT'); ?></label>
					<select class="selectpicker" id="addOrgunit" name="orgunit_id">
						<?php 
							if(!empty($this->model->_orgunitlist)) {
								foreach($this->model->_orgunitlist as $orgunitTmp) {
									?>
										<option value="<?php echo $orgunitTmp->orgunit_id; ?>" <?php if($this->model->_has_orgunit) if($this->model->_orgunit_id == $orgunitTmp->orgunit_id) echo 'selected'; else echo 'disabled';  ?>><?php echo $orgunitTmp->name; ?></option>
									<?php
								}
							}
						?>			
					</select>
					<input type="text" class="span6" id="addOrgunit" name="orgunit" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_ORGUNIT'); ?>" />
					
					<label class="control-label" for="addTags"><?php echo JText::_('COM_INVENTORY_DEVICE_TAGS_LONG'); ?></label>
					<input type="text" class="span6" id="addTags" name="tags" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_TAGS'); ?>" />
				</form>
			</div>
	
			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>
		</form>
    </div>
    
  					