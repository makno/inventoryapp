<?php
/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
?>
<div  id="inventorydevice">

<h2 class="page-header">
	<?php echo $this->device->devicename; ?>
	<?php if(!empty($this->device->tags)){ ?>
		<p style="font-size:11px;margin-top:0px;padding-top:0px;margin-bottom:0px;padding-bottom:0px;font-style:italic;font-weight:normal;"><b>Tags: </b><?php echo $this->device->tags; ?></p>
	<?php } ?>
</h2>

<a 
	href="<?php echo JURI::root(); ?>index.php?option=com_inventory&menu_orgunitid=<?php echo $this->model->_orgunit_id; ?>"
	class="btn btn-small pull-right"
	><i class="icon icon-home"></i> <?php echo JText::_('COM_INVENTORY_LIST'); ?> <?php if(!empty($this->model->_orgunit) && $this->model->_orgunit->name!='All') echo ': ' . $this->model->_orgunit->name; ?></a>

<?php echo $this->_modalMessage->render(); ?>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<img class="media-object" src="<?php if(!empty($this->device->imageurl)){ echo $this->device->imageurl;}else{ echo JURI::root().'components/com_inventory/assets/img/holder100x100.png';} ?>" width="100px" height="100px"  style="margin-top:60px;"/>
			<p class="muted text-center" style="text-align:center;"><?php echo $this->device->snumber; ?></p>
			<div align="center" style="margin-top:10px;">
				<?php echo $this->device->qrcodesvg; ?>
				<p style="text-align:center;font-size:10px;font-family:Courier new, sans serif;margin-top:0px;padding-top:0px;margin-bottom:0px;padding-bottom:0px;font-weight:bold;"><?php echo $this->device->qrcode; ?></p>
			</div>
				
				<?php if (!isset($this->hasUser) || $this->hasUser) { ?>
				
					<?php echo $this->_editDeviceView->render(); ?>
					<?php echo $this->_lendDeviceView->render(); ?>
					<?php echo $this->_returnDeviceView->render(); ?>
					
					<div align="center" style="margin-top:10px;">
					
						<?php
							if ($this->device->lent) { 
								if(JFactory::getUser()->id == $this->device->lent_user_id) {?>
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
									
								<?php
								
								if($this->hasRoot){
								
								?>
								
									<a style="margin-bottom:5px;width:75px;" 
										href="#editDeviceModal" 
										onclick="fillEditForm('<?php echo $this->device->device_id; ?>');" 
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

					</div>
					
				<?php } ?>
		</div>
		<div class="span10">
			<div class="tabbable">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#detailsTab" data-toggle="tab"><?php echo JText::_('COM_INVENTORY_DEVICE_DETAILS'); ?></a></li>
					<li><a href="#descriptionTab" data-toggle="tab"><?php echo JText::_('COM_INVENTORY_DEVICE_DESCRIPTION'); ?></a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="detailsTab">
						<p>
							<strong><?php echo JText::_('COM_INVENTORY_DEVICE_NAME'); ?></strong><br />
							<?php echo $this->device->devicename; ?>
						</p>
						<p>
							<strong><?php echo JText::_('COM_INVENTORY_DEVICE_SHORTDESC'); ?></strong><br />
							<?php echo $this->device->shortdescription; ?>
						</p>
						<p>
							<strong><?php echo JText::_('COM_INVENTORY_DEVICE_SNUMBER'); ?></strong><br />
							<?php echo $this->device->snumber; ?>
						</p>
						<p>
							<strong><?php echo JText::_('COM_INVENTORY_DEVICE_QRCODE'); ?></strong><br />
							<?php echo $this->device->qrcode; ?>
						</p>
					</div>
					<div class="tab-pane" id="descriptionTab">
						<?php echo $this->device->description; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $('#detailsTab a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
    });
	$('#descriptionTab a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
    });
</script>

</div>