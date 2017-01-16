<?php
/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
?>
<div  id="inventorylist">

<h2 class="page-header">
	<?php echo JText::_('COM_INVENTORY_TITLE'); ?> 
		<?php if($this->model->_has_orgunit) { 
			echo JText::_('COM_INVENTORY_FOR') . ' ' . $this->model->_orgunit->name; ?>
			<p style="font-size: 14px;">
				<?php echo $this->model->_orgunit->shortdescription; ?>
			</p>
		<?php }?>
		<?php 
		
		if($this->model->showversion) {
			if(isset($this->model->status)){
				switch($this->model->status){
					case '(Productive)':
						?> <div style="font-size:10px; height: 12px;"> <?php
						break;
					case '(Demo)':
						?> <div class="alert alert-info" role="alert"> <?php
						break;
					case '(Test)':
						?> <div class="alert alert-warning" role="alert"> <?php
						break;
					case '(Development)':
						?> <div class="alert alert-danger" role="alert"> <?php
						break;
					default:
						?> <div class="alert alert-info" role="alert"> <?php
				}
			}else{
				?> <div class="alert alert-success" role="alert"> <?php
			}
				?>

				Version 

				<?php
					echo $this->model->getVersion();
					if(isset($this->model->status)){
						echo ' ' . $this->model->status;
					}
				?>
				
			</div>
			
			<?php
		}
		?>
	
</h2>

<?php echo $this->_modalMessage->render(); ?>

<?php
		
	// PAGINATION
	if($this->model->_has_page_number){
		if($this->model->_page_number==-1){
			$startRecord = 0;
			$endRecord = $this->model->items_total;
		}else{
			$startRecord = ($this->model->_page_number-1) * $this->model->itemsperpage;
			$endRecord = ($this->model->_page_number-1) * $this->model->itemsperpage + $this->model->itemsperpage;
			if($endRecord > $this->model->items_total) 
				$endRecord = $this->model->items_total;
		}
	}else{
		$this->model->_has_page_number = true;
		$this->model->_page_number = 1;
		$startRecord = 0;
		$endRecord = ($this->model->items_total>$this->model->itemsperpage)?$this->model->itemsperpage:$this->model->items_total;
	}

	// TAGGING
	$tagArray = array();
	$emptytags = 0;
	$mytags = '';
	$hasNoTagsSelected = ($this->model->_selectionTag != null && $this->model->_selectionTag == "notag");
	
	foreach($this->model->_selectionTags as $tagTmp) {
		$mytags .= $tagTmp; 
		$mytags .= ',';
	}
	?>
	<form id="tagForm" name="tagForm" method="post" action="<?php echo JRoute::_('index.php?option=com_inventory&controller=default&format=html&menu_orgunitid='.$this->model->_orgunit_id); ?>">
		<input type="hidden" id="tagSelectionAll" name="tagSelectionAll" value="<?php echo $mytags;  ?>" />
		<input type="hidden" id="tagSelection" name="tagSelection" value="" />
		<input type="hidden" id="statusAvailable" name="statusAvailable" value="<?php if($this->model->_has_status_available) echo $this->model->_status_available;  ?>" />
		<input type="hidden" id="statusLent" name="statusLent" value="<?php if($this->model->_has_status_lent) echo $this->model->_status_lent;  ?>" />
		<input type="hidden" id="nameOrder" name="nameOrder" value="<?php if($this->model->_has_name_order) echo $this->model->_name_order;  ?>" />
		<input type="hidden" id="pageNumber" name="pageNumber" value="" /> <!-- Should be inside ... <?php if($this->model->_has_page_number) echo $this->model->_page_number;  ?>-->
	</form>
	<?php
	
	for($i=0, $n = count($this->devices);$i<$n;$i++) {
		if(!empty($this->devices[$i]->tags)){
			$tmpArray = preg_split('#,#',$this->devices[$i]->tags);
			foreach ($tmpArray  as $tag){
				$tag = trim($tag);
				if(array_key_exists($tag,$tagArray)){
					$tagArray[$tag] += 1;
				}else{
					$tagArray[$tag] = 1;
				}
			}
		}else{
			$emptytags += 1;
		}
	}
	
	ksort($tagArray);
		
	// TAGS
	foreach ($tagArray  as $tag => $number){
		?>
			<button class="btn btn-mini" onclick="javascript: selectTag('<?php echo $tag; ?>')" type="button" style="margin-right:5px;margin-bottom:5px;"><?php if(in_array($tag,$this->model->_selectionTags)){ ?><i class="icon-star"></i> <?php } ?><?php echo $tag; ?> (<?php echo $number; ?>)</button>
		<?php
	}

	// NO TAGS
	if($emptytags>0){
		?>
			<a class="btn btn-mini" href="<?php echo JRoute::_('index.php?option=com_inventory&view=device&layout=list&tagSelection=notag&menu_orgunitid='.$this->model->_orgunit_id); ?>" style="margin-right:5px;margin-bottom:5px;"><?php if($hasNoTagsSelected ){ ?><i class="icon-star"></i> <?php } ?><?php echo JText::_('COM_INVENTORY_NO_TAGS'); ?> (<?php echo $emptytags; ?>)</a>
		<?php
	}	
	
	// RESET TAGS
	if((sizeof($tagArray)>0 && sizeof($this->model->_selectionTags)>0) || $this->model->_selectionTag == "notag" ){
		?>
			<button class="btn btn-mini btn-inverse" onclick="javascript: clearTags()" type="button" style="margin-right:5px;margin-bottom:5px;"></i><?php echo JText::_('COM_INVENTORY_CLEAR_FILTER'); ?></button>
		<?php
	}
?>

<?php if($this->model->items_total > $this->model->itemsperpage) {?>
	<div class="pagination">
		<ul>
			<li <?php if($this->model->_has_page_number) if ($this->model->_page_number==-1) echo 'class="active"'; ?>><a href="javascript:void(0);" onclick="selectPage(-1);"><b><?php echo JText::_('COM_INVENTORY_CLEAR_FILTER'); ?></b></a><li>
			<?php 
				$pages = ceil($this->model->items_total/$this->model->itemsperpage);
				for($iC=1; $iC<=$pages; $iC++){ ?>
				<li <?php if($this->model->_has_page_number) if ($this->model->_page_number==$iC) echo 'class="active"'; ?>><a href="javascript:void(0);" onclick="selectPage(<?php echo $iC; ?>);"><?php echo ($iC-1)*$this->model->itemsperpage+1; ?>-<?php if($iC!=$pages){ echo (($iC-1)*$this->model->itemsperpage+$this->model->itemsperpage); }else{ echo $this->model->items_total; } ?></a><li>
			<?php } ?>
		</ul>
	</div>
<?php } ?>

<?php	

	$user = JFactory::getUser();
	$hasUser=!$user->get('guest');
	$hasRoot=$user->get('isRoot');
	
	if ($hasUser && $hasRoot){
?>
		<a 
			href="#newDeviceModal" 
			role="button" 
			data-toggle="modal" 
			class="btn btn-info pull-right"
			>
				<i class="icon icon-plus"></i> <?php echo JText::_('COM_INVENTORY_ADD_DEVICE'); ?>
		</a>
			
		<?php echo $this->_addDeviceView->render(); ?>
		<?php echo $this->_editDeviceView->render(); ?>
		<?php echo $this->_lendDeviceView->render(); ?>
		<?php echo $this->_returnDeviceView->render(); ?>
<?php
	}
?>
	
<div class="row-fluid">
	<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped">
		<thead>
			<tr>
				<th>
					<a 
						href="javascript:void(0);" 
						onclick="javascript: orderName();">
							<?php 
							echo JText::_('COM_INVENTORY_DEVICE_NAME').'&nbsp;'; 
							if($this->model->_has_name_order && $this->model->_name_order=='desc') { ?>
								<i class="icon-arrow-down-3"></i>
							<?php }else{ ?>
								<i class="icon-arrow-up-3"></i>
							<?php }  
							
							?>
					</a>
					&nbsp;
					<?php if($this->model->_has_status_available && strtolower($this->model->_status_available)=='available') { ?>
						<a href="javascript:void(0);" onclick="javascript: selectStatus('Available',false);" ><span class="label label-success"><?php echo JText::_('COM_INVENTORY_AVAILABLE'); ?> <i class="icon-remove"></i></span></a>
					<?php }else { ?>
						<a href="javascript:void(0);" onclick="javascript: selectStatus('Available',true);" ><span class="label"><?php echo JText::_('COM_INVENTORY_AVAILABLE'); ?> <i class="icon-ok"></i></span></a>
					<?php } ?>
					&nbsp;
					<?php if($this->model->_has_status_lent && strtolower($this->model->_status_lent)=='lent') { ?>
						<a href="javascript:void(0);" onclick="javascript: selectStatus('Lent', false);" ><span class="label label-warning"><?php echo JText::_('COM_INVENTORY_LENT'); ?> <i class="icon-remove"></i></span></a>
					<?php }else { ?>
						<a href="javascript:void(0);" onclick="javascript: selectStatus('Lent', true);" ><span class="label"><?php echo JText::_('COM_INVENTORY_LENT'); ?> <i class="icon-ok"></i></span></a>
					<?php } ?>	
				</th>
				<th>
					<?php echo JText::_('COM_INVENTORY_DEVICE_QRCODE'); ?>
				</th>
				<th>
					<?php echo JText::_('COM_INVENTORY_STATUS'); ?>
				</th>
				<?php if($hasUser) { ?>
					<th><?php echo JText::_('COM_INVENTORY_ACTIONS'); ?></th>
				<?php } ?>
			</tr>
		</thead>
		<tbody id="device-list">
			<?php
			for($i=$startRecord,$n=$endRecord;$i<$n;$i++) {
				$this->_deviceListView->device = $this->devices[$i];
				$this->_deviceListView->type = 'device';
				$this->_deviceListView->hasUser = $hasUser;
				$this->_deviceListView->hasRoot = $hasRoot;
				echo $this->_deviceListView->render();
			} 
			?>
		</tbody>
	</table>

</div>
</div>

<script type="text/javascript">
//
//	if(window.top==window) {
//		(function refresher(){
//			jQuery('#tagForm').submit();
//			setTimeout(refresher, 10000);
//		})();
//	}
</script>