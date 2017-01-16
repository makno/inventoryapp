// @package     it+kapfenberg
// @subpackage  com_inventory

// @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
// @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt

//add a device
function addDevice()
{
	var deviceInfo = {};
	jQuery("#deviceFormAdd :input").each(function(idx,ele){
		deviceInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});
	
	jQuery.ajax({
		url:'index.php?option=com_inventory&controller=add&format=raw&tmpl=component',
		type:'POST',
		data:deviceInfo,
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success ){
				jQuery("#device-list").append(data.html);
				jQuery("#newDeviceModal").modal('hide');
				jQuery("#qrcodegenerated").html('');
				deviceFormAdd.reset();
			}else{
				alert(data.msg);
			}
		},
		error:function(data)
		{
			// alert(data.statusText);
			var recipe =  window.open('','RecipeWindow','width=600,height=600');
			recipe.document.open();
			recipe.document.write(data.responseText);
			recipe.document.close();
		}
	});

}

// Check QRCode while adding
function checkQRCode(field){
	jQuery("#qrcodemessage").html('');
	jQuery("#deviceFormAdd :input").attr("disabled",true);
	jQuery.ajax({
		url:'index.php?option=com_inventory&controller=qrcode&format=raw&tmpl=component',
		type:'POST',
		data: 'qrcode='+field.value,
		dataType: 'json',
		success:function(data)
		{
			if(data)
			{
				if(data.hasCode){
					jQuery("#qrcodemessage").html(data.msg);
					deviceFormAdd.qrcode.value = '';
					jQuery("#deviceFormAdd :input").attr("disabled",false);	
					deviceFormAdd.qrcode.focus();
				}else{
					jQuery("#deviceFormAdd :input").attr("disabled",false);	
					deviceFormAdd.description.focus();
				}
				
			}
		},
		error:function(data)
		{
			jQuery("#deviceFormAdd :input").attr("disabled",false);
		}
	});
	
}

// Fill Edit form before actually update/edit
function fillEditForm(device_id){
	jQuery("#deviceFormEdit :input").attr("disabled",true);	
	jQuery.ajax({
		url:'index.php?option=com_inventory&controller=device&format=raw&tmpl=component',
		type:'POST',
		data: 'id='+device_id,
		dataType: 'JSON',
		success:function(data)
		{
			if(data.success)
			{
				deviceFormEdit.device_id.value = data.device.device_id;
				deviceFormEdit.devicename.value = data.device.devicename;
				deviceFormEdit.imageurl.value = data.device.imageurl;
				deviceFormEdit.snumber.value = data.device.snumber;
				deviceFormEdit.location.value = data.device.location;
				deviceFormEdit.orgunit_id.value = data.device.orgunit_id;
				deviceFormEdit.qrcode.value = data.device.qrcode;
				deviceFormEdit.tags.value = data.device.tags;
				deviceFormEdit.shortdescription.value = data.device.shortdescription;
				deviceFormEdit.description.innerHTML = data.device.description;
				if(typeof WFEditor != 'undefined')
					WFEditor.setContent('descriptionEdit',data.device.description);
			}else{
				alert(data.msg);
			}
			jQuery("#deviceFormEdit :input").attr("disabled",false);	
		},
		error:function(data){
			alert(data.msg);
			jQuery("#deviceFormEdit :input").attr("disabled",false);	
		}
	});

}

// edit device
function editDevice(device_id)
{
	var deviceInfo = {};
	jQuery("#deviceFormEdit :input").each(function(idx,ele){
		deviceInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});

	jQuery.ajax({
		url:'index.php?option=com_inventory&controller=edit&format=raw&tmpl=component',
		type:'POST',
		data:deviceInfo,
		dataType:'JSON',
		success:function(data)
		{
			
			if ( data.success ){
				jQuery("#deviceRow"+deviceInfo['device_id']).replaceWith(data.html);
				jQuery("#editDeviceModal").modal('hide');
				jQuery("#qrcodegenerated").html('');
				deviceFormEdit.reset();
			}else{
				alert(data.msg);
			}
		},
		error:function(data)
		{
			// alert(data.statusText);
			var recipe =  window.open('','RecipeWindow','width=600,height=600');
			recipe.document.open();
			recipe.document.write(data.responseText);
			recipe.document.close();
		}
	});
}

// Show modal and fill 
function lendDeviceModal(device_id)
{
	jQuery("#lendDeviceModal").modal('show');
	jQuery("#deviceid").val(device_id);
}

// Perform loan
function lendDevice()
{

	var lendInfo = {};
	jQuery("#lendForm :input").each(function(idx,ele){
		lendInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});
	
	jQuery.ajax({
		url:'index.php?option=com_inventory&controller=lend&format=raw&tmpl=component',
		type:'POST',
		data:lendInfo,
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success )
			{
				jQuery("#deviceRow"+lendInfo['device_id']).replaceWith(data.html);
				jQuery("#lendDeviceModal").modal('hide');
			}else{
				alert(data.msg);
			}
		},
		error:function(data){
			alert(data.msg);
		}
	});
}

// Return Modal
function returnDeviceModal(device_id)
{
	jQuery("#returnDeviceModal").modal('show');
	jQuery("#device_id").val(device_id);
}

// Actually return device
function returnDevice()
{
	var returnInfo = {};
	jQuery("#returnForm :input").each(function(idx,ele){
		returnInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});

	jQuery.ajax({
		url:'index.php?option=com_inventory&controller=lend&format=raw&tmpl=component',
		type:'POST',
		data: returnInfo,
		dataType: 'JSON',
		success:function(data)
		{
			if(data.success)
			{
				jQuery("#deviceRow"+returnInfo['device_id']).replaceWith(data.html);
				jQuery("#returnDeviceModal").modal('hide');
			} else {
				alert(data.msg);
			}
		},
		error:function(data){
			alert(data.msg);
		}
	});
}

// Delete device
function deleteDevice(device_id) 
{
	jQuery.ajax({
		url:'index.php?option=com_inventory&controller=delete&format=raw&tmpl=component',
		type:'POST',
		data: 'device_id='+device_id,
		dataType: 'JSON',
		success:function(data)
		{
			alert(data.msg);
			if(data.success)
			{
				jQuery("tr#deviceRow"+device_id).hide();
			}
		},
		error:function(data){
			alert(data.msg);
		}
	});
}


// OTHER STUFF NOT USED RIGHT NOW

function loadInventoryModal(device_id, borrower_id, borrower, waitlist_id){
	jQuery("#lendDeviceModal").modal('show');
	jQuery('#borrower_name').html(borrower);
	jQuery("#device_id").val(device_id);
	jQuery("#borrower_id").val(borrower_id);
	jQuery("#waitlist_id").val(waitlist_id);
}

function requestDeviceModal(device_id){
	jQuery("#borrowDeviceModal").modal('show');
	var html = jQuery("#device-row-"+device_id).html();
	jQuery("#device-modal-info").html(html);
	jQuery("#device-id").val(decvice_id);
}

function requestDevice(){
	var requestInfo = {};
	jQuery("#borrowForm :input").each(function(idx,ele){
		requestInfo[jQuery(ele).attr('name')] = jQuery(ele).val();
	});
	
	jQuery.ajax({
		url:'index.php?option=com_inventory&controller=borrow&format=raw&tmpl=component',
		type:'POST',
		data:requestInfo,
		dataType:'JSON',
		success:function(data){
			if ( data.success ){
				jQuery("#borrowDeviceModal").modal('hide');
			} else {
			}
		}
	});
}

function cancelRequest(waitlist_id) {
	jQuery.ajax({
		url:'index.php?option=com_inventory&controller=delete&format=raw&tmpl=component',
		type:'POST',
		data: 'waitlist_id='+waitlist_id,
		dataType: 'JSON',
		success:function(data){
			alert(data.msg);
		}
	});
}

function selectPage(pageno){
	jQuery('#pageNumber').val(pageno);
	jQuery('#tagForm').submit();
}

function selectTag(tagname){
	jQuery('#tagSelection').val(tagname);
	jQuery('#tagForm').submit();
}

function selectStatus(status, isOn){
	if(isOn){
		jQuery('#status'+status).val(status);
	}else{
		jQuery('#status'+status).val('');
	}
	// Fail safe
	if(jQuery('#statusAvailable').val()=='' && jQuery('#statusLent').val()==''){
		jQuery('#status'+status).val(status);
	}else{
		jQuery('#tagForm').submit();
	}
}

function orderName(){
	if(jQuery('#nameOrder').val()=='desc'||jQuery('#nameOrder').val()==''){
		jQuery('#nameOrder').val('asc');
	}else{
	jQuery('#nameOrder').val('desc');
	}
	jQuery('#tagForm').submit();
}

function clearTags(){
	jQuery('#tagSelection').val('');
	jQuery('#tagSelectionAll').val('');
	jQuery('#tagForm').submit();
}
