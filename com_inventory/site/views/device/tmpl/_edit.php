<?php
/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
?>
<div id="editDeviceModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="editDeviceModalLabel" aria-hidden="true" style="width:700px;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel"><?php echo JText::_('COM_INVENTORY_EDIT_DEVICE'); ?></h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid">
			<form name="deviceFormEdit" id="deviceFormEdit" method="post">
				<p class="span12" id="qrcodemessage" style="color:red;"></p>
				
				<input type="hidden" name="device_id" value="" />
				<input type="hidden" name="table" value="device" />
				<input type="hidden" name="type" value="device" />
				
				<label class="control-label" for="editDevicename"><?php echo JText::_('COM_INVENTORY_DEVICE_NAME'); ?></label>
				<input class="span12" type="text" id="editDevicename" name="devicename" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_NAME'); ?>" />
				
				<label class="control-label" for="editImageurl"><?php echo JText::_('COM_INVENTORY_DEVICE_IMAGE'); ?></label>
				<input class="span12" type="text" id="editImageurl" name="imageurl" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_IMAGE'); ?>" />
				
				<label class="control-label" for="editSnumber"><?php echo JText::_('COM_INVENTORY_DEVICE_SNUMBER'); ?></label>
				<input type="text" class="span6" id="editSnumber" name="snumber" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_SNUMBER'); ?>" />
				
				<label class="control-label" for="editQrcode"><?php echo JText::_('COM_INVENTORY_DEVICE_QRCODE'); ?></label>
				<input type="text" class="span6" id="editQrcode" name="qrcode" onchange="checkQRCode(this);" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_QRCODE'); ?>" />
				
				<label class="control-label" for="editShortdescription"><?php echo JText::_('COM_INVENTORY_DEVICE_SHORTDESC'); ?></label>
				<input class="span12" type="text" id="editShortdescription" name="shortdescription" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_SHORTDESC'); ?>" />
				
				<div class="span12">
					<label for="descriptionEdit"><?php echo JText::_('COM_INVENTORY_DEVICE_DESCRIPTION'); ?></label>
					<?php
						if($this->_editor)
							echo $this->_editor->display( 'description', '', '100%', '300', '20', '20', true, 'descriptionEdit', null, JFactory::getUser()->name, $this->_params );
					?>
				</div>
				
				<label class="control-label" for="editLocation"><?php echo JText::_('COM_INVENTORY_DEVICE_LOCATION'); ?></label>
				<input type="text" class="span6" id="editLocation" name="location" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_LOCATION'); ?>" />
				
				<label class="control-label" for="editOrgunit"><?php echo JText::_('COM_INVENTORY_DEVICE_ORGUNIT'); ?></label>
				<select class="selectpicker" id="editOrgunit" name="orgunit_id" readonly>
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
				<!--<input type="text" class="span6" id="editOrgunit" name="orgunit" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_ORGUNIT'); ?>" />-->
				
				<label class="control-label" for="editTags"><?php echo JText::_('COM_INVENTORY_DEVICE_TAGS_LONG'); ?></label>
				<input type="text" class="span6" id="editTags" name="tags" placeholder="<?php echo JText::_('COM_INVENTORY_DEVICE_TAGS'); ?>" />
			</form>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_INVENTORY_CLOSE'); ?></button>
		<button class="btn btn-primary" onclick="javascript: <?php if($this->_editor) echo $this->_editor->save('descriptionEdit'); ?>;editDevice();"><?php echo JText::_('COM_INVENTORY_EDIT'); ?></button>
	</div>
</div>