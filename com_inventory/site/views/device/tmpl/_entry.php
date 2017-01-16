<?php
/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
?>
<tr id="deviceRow<?php echo $this->device->device_id; ?>">
	<td>
		<div class="media" id="device-row-<?php echo $this->device->device_id; ?>">
			<a class="pull-left" href="<?php echo JRoute::_('index.php?option=com_inventory&view=device&layout=device&id='.$this->device->device_id.'&menu_orgunitid='.$this->model->_orgunit_id); ?>"><img class="media-object" src="<?php if(!empty($this->device->imageurl)){ echo $this->device->imageurl;}else{ echo JURI::root().'components/com_inventory/assets/img/holder100x100.png';} ?>" width="100px" height="100px"/></a>
			<div class="media-body" style="margin-left:110px;">
				<h4 class="media-heading"><a  href="<?php echo JRoute::_('index.php?option=com_inventory&view=device&layout=device&id='.$this->device->device_id.'&menu_orgunitid='.$this->model->_orgunit_id); ?>"><?php echo $this->device->devicename; ?></a></h4>
				<span class="muted"><?php echo $this->device->snumber; ?></span>
				<p style="font-size:13px;line-height:14px;"><?php echo $this->device->shortdescription; ?></p>
				<p style="font-size:11px;line-height:12px;"><?php if($this->device->location){ ?>
					<b><?php echo JText::_('COM_INVENTORY_DEVICE_LOCATION'); ?>:</b> <?php echo $this->device->location; ?>
				<?php } ?>
				<?php if($this->device->orgunit){ ?>
					<br/><b><?php echo JText::_('COM_INVENTORY_DEVICE_ORGUNIT'); ?>:</b> <?php echo $this->device->orgunit; ?>
				<?php } ?>
				<?php if($this->device->tags){ ?>
					<br/><b><?php echo JText::_('COM_INVENTORY_DEVICE_TAGS'); ?>:</b> <?php echo $this->device->tags; ?>
				<?php } ?></p>
			</div>
		</div>
	</td>
	<td class="small">
		<?php echo $this->device->qrcodesvg; ?>
		<p style="font-size:10px;font-family:Courier new, sans serif;margin-top:0px;padding-top:0px;margin-bottom:0px;padding-bottom:0px;font-weight:bold;"><?php echo $this->device->qrcode; ?></p>
	</td>
	<td class="small">
		<?php if($this->device->lent) {  ?>
			<span class="label label-warning"><?php echo JText::_('COM_INVENTORY_LENT'); ?></span>
			<p style="font-size:11px;line-height:12px;">
			<b><?php echo JText::_('COM_INVENTORY_BORROWER'); ?></b><br />
			<?php 
				$tmpUser =& JFactory::getUser($this->device->lent_user_id);
				if($tmpUser){
					echo $tmpUser->name . ' <i>(' . $tmpUser->id . ')</i>';
				}else{
					echo JText::_('COM_INVENTORY_NO_USER');
				}
			?>
			<?php if(!empty($this->device->lent_description)){ ?>
				<b><?php echo JText::_('COM_INVENTORY_FOR'); ?></b><br />
				<?php echo $this->device->lent_description; ?>
			<?php } ?>
			</p>
		<?php } else { ?>
			<span class="label label-success"><?php echo JText::_('COM_INVENTORY_AVAILABLE'); ?></span>
		<?php } ?>
	</td>
	
	<?php if (!isset($this->hasUser) || $this->hasUser) { ?>
	
		<td class="small">
		
			<?php
				if ($this->device->lent) { 
					if(JFactory::getUser()->id == $this->device->lent_user_id || JFactory::getUser()->get('isRoot')) {?>
						<a  style="margin-bottom:5px;width:75px;"
							href="javascript:void(0);" 
							role="button" 
							class="btn btn-small pull-right" 
							onclick="returnDeviceModal('<?php echo $this->device->device_id; ?>');"
								><i class="icon icon-refresh"></i> <?php echo JText::_('COM_INVENTORY_RETURN'); ?></a>                   
			<?php	} 
				} else { ?>
					<a  style="margin-bottom:5px;width:75px;"
						href="javascript:void(0);" 
						class="btn btn-small pull-right" 
						role="button" 
						data-toggle="modal" 
						onclick="lendDeviceModal('<?php echo $this->device->device_id; ?>');"
						><i class="icon icon-share"></i> <?php echo JText::_('COM_INVENTORY_LEND_DEVICE'); ?></a>
					
					<?php if ($this->hasRoot){ ?>
					
					<a  style="margin-bottom:5px;width:75px;"
						href="#editDeviceModal" 
						onclick="javascript: fillEditForm('<?php echo $this->device->device_id; ?>');" 
						role="button" 
						data-toggle="modal" 
						class="btn btn-small pull-right"
						><i class="icon icon-edit"></i> <?php echo JText::_('COM_INVENTORY_EDIT'); ?></a>
					
					<a  style="margin-bottom:5px;width:75px;"
						href="javascript:void(0);" 
						onclick="deleteDevice('<?php echo $this->device->device_id; ?>');" 
						class="btn btn-small pull-right"
						><i class="icon icon-trash"></i> <?php echo JText::_('COM_INVENTORY_DELETE'); ?></a>
			<?php
					}
				} ?>	
		</td>
		
	<?php } ?>
		
</tr>
