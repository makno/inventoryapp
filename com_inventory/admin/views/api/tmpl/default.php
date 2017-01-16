<?php
/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
?>

<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container" class="span12">
<?php endif;?>

		<div class="thumbnail" style="margin-bottom:5px;">
			<form class="form-inline" id="deviceinfobyid" method="post" target="_blank" action="<?php echo JURI::root(); ?>index.php?option=com_inventory">
				
				<fieldset>
					<legend><b>Get</b> a device by its Id 
					<div class="btn-group pull-right">
						<input class="btn  btn-primary" type="button" name="Self" value="_self" onclick="checkOutput('<?php echo JURI::root(); ?>','deviceinfobyid');"/>
						<input class="btn  btn-success" type="button" name="Clear" value="_clear" onclick="clearOutput('deviceinfobyid');"/>
						<input class="btn  btn-info" type="submit" name="Submit" value="_blank" />
					</div>
					</legend>
					<div class="input-prepend">
						<span class="add-on">controller</span>
						<input readonly type="text" name="controller" value="deviceinfobyid" />
					</div>
					<span style="display: inline-block;width: auto;height: 15px;min-width: 16px;padding: 4px 5px;font-size: 13px;font-weight: normal;line-height: 15px;text-align: center;text-shadow: 0 1px 0 #ffffff;background-color: #eeeeee;border: 1px solid #ccc;">format</span>
					<select onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfobyid');" name="format"><option selected>raw</option><option>json</option></select>
					<div class="input-prepend">
						<span class="add-on">username</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfobyid');"  class="input-small" type="text" name="username" value="kmu" />
					</div>
					<div class="input-prepend">
						<span class="add-on">password</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfobyid');" class="input-small" type="text" name="password" value="kmugoesmobile" />
					</div>
					<div class="input-prepend">
						<span class="add-on">id</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfobyid');" class="input-small" type="text" name="id" value="1" />
					</div>
					<br/><code class="span9" class="text-info" id="deviceinfobyidcode"></code>
					<div class="span9" ><pre id="deviceinfobyidoutput">Output ...</pre></div>
				</fieldset>	
			</form>
		</div>	
		
		<div class="thumbnail" style="margin-bottom:5px;">
			<form class="form-inline" id="deviceinfoall" method="post" target="_blank" action="<?php echo JURI::root(); ?>index.php?option=com_inventory">
				<fieldset>
					<legend><b>Get all</b> devices
					<div class="btn-group pull-right">
						<input class="btn  btn-primary" type="button" name="Self" value="_self" onclick="checkOutput('<?php echo JURI::root(); ?>','deviceinfoall');"/>
						<input class="btn  btn-success" type="button" name="Clear" value="_clear" onclick="clearOutput('deviceinfoall');"/>
						<input class="btn  btn-info" type="submit" name="Submit" value="_blank" />
					</div>
					</legend>
					<div class="input-prepend">
						<span class="add-on">controller</span>
						<input readonly type="text" name="controller" value="deviceinfoall" />
					</div>
					<span style="display: inline-block;width: auto;height: 15px;min-width: 16px;padding: 4px 5px;font-size: 13px;font-weight: normal;line-height: 15px;text-align: center;text-shadow: 0 1px 0 #ffffff;background-color: #eeeeee;border: 1px solid #ccc;">format</span>
					<select onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfoall');" name="format"><option selected>raw</option><option>json</option></select>
					<div class="input-prepend">
						<span class="add-on">username</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfoall');" class="input-small" type="text" name="username" value="kmu" />
					</div>
					<div class="input-prepend">
						<span class="add-on">password</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfoall');" class="input-small" type="text" name="password" value="kmugoesmobile" />
					</div>
					<span style="display: inline-block;width: auto;height: 15px;min-width: 16px;padding: 4px 5px;font-size: 13px;font-weight: normal;line-height: 15px;text-align: center;text-shadow: 0 1px 0 #ffffff;background-color: #eeeeee;border: 1px solid #ccc;">status</span>
					<select onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfoall');" name="status"><option selected>all</option><option>lent</option><option>available</option></select>
					<span style="display: inline-block;width: auto;height: 15px;min-width: 16px;padding: 4px 5px;font-size: 13px;font-weight: normal;line-height: 15px;text-align: center;text-shadow: 0 1px 0 #ffffff;background-color: #eeeeee;border: 1px solid #ccc;">orgunit</span>
					<select onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfoall');" name="orgunit"><option selected value="-1">All</option><option value="1">IT+Kapfenberg</option><option value="2">EVU</option></select>
					<br/><code class="span9" class="span12" id="deviceinfoallcode"></code>
					<div class="span9" ><pre id="deviceinfoalloutput">Output ...</pre></div>
				</fieldset>
			</form>
		</div>	

                <div class="thumbnail" style="margin-bottom:5px;">
                        <form class="form-inline" id="orgunits" method="post" target="_blank" action="<?php echo JURI::root(); ?>index.php?option=com_inventory">
                                <fieldset>
                                        <legend><b>Get all</b> orgunits
                                        <div class="btn-group pull-right">
                                                <input class="btn  btn-primary" type="button" name="Self" value="_self" onclick="checkOutput('<?php echo JURI::root(); ?>','orgunits');"/>
                                                <input class="btn  btn-success" type="button" name="Clear" value="_clear" onclick="clearOutput('orgunits');"/>
                                                <input class="btn  btn-info" type="submit" name="Submit" value="_blank" />
                                        </div>
                                        </legend>
                                        <div class="input-prepend">
                                                <span class="add-on">controller</span>
                                                <input readonly type="text" name="controller" value="orgunits" />
                                        </div>
                                        <span style="display: inline-block;width: auto;height: 15px;min-width: 16px;padding: 4px 5px;font-size: 13px;font-weight: normal;line-height: 15px;text-align: center;text-shadow: 0 1px 0 #ffffff;background-color: #eeeeee;border: 1px solid #ccc;">format</span>
                                        <select onchange="checkForm('<?php echo JURI::root(); ?>','orgunits');" name="format"><option selected>raw</option><option>json</option></select>
                                        <div class="input-prepend">
                                                <span class="add-on">username</span>
                                                <input onchange="checkForm('<?php echo JURI::root(); ?>','orgunits');" class="input-small" type="text" name="username" value="kmu" />
                                        </div>
                                        <div class="input-prepend">
                                                <span class="add-on">password</span>
                                                <input onchange="checkForm('<?php echo JURI::root(); ?>','orgunits');" class="input-small" type="text" name="password" value="kmugoesmobile" />
                                        </div>
                                        <br/><code class="span9" class="span12" id="orgunitscode"></code>
                                        <div class="span9" ><pre id="orgunitsoutput">Output ...</pre></div>
                                </fieldset>
                        </form>
                </div>
		
		<div class="thumbnail" style="margin-bottom:5px;">
			<form class="form-inline" id="deviceinfobyuserid" method="post" target="_blank" action="<?php echo JURI::root(); ?>index.php?option=com_inventory">
				<fieldset>
					<legend><b>Get all</b> devices lent for user
					<div class="btn-group pull-right">
						<input class="btn  btn-primary" type="button" name="Self" value="_self" onclick="checkOutput('<?php echo JURI::root(); ?>','deviceinfobyuserid');"/>
						<input class="btn  btn-success" type="button" name="Clear" value="_clear" onclick="clearOutput('deviceinfobyuserid');"/>
						<input class="btn  btn-info" type="submit" name="Submit" value="_blank" />
					</div>
					</legend>
					<div class="input-prepend">
						<span class="add-on">controller</span>
						<input readonly type="text" name="controller" value="deviceinfobyuserid" />
					</div>
					<span style="display: inline-block;width: auto;height: 15px;min-width: 16px;padding: 4px 5px;font-size: 13px;font-weight: normal;line-height: 15px;text-align: center;text-shadow: 0 1px 0 #ffffff;background-color: #eeeeee;border: 1px solid #ccc;">format</span>
					<select onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfobyuserid');" name="format"><option selected>raw</option><option>json</option></select>
					<div class="input-prepend">
						<span class="add-on">username</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfobyuserid');" class="input-small" type="text" name="username" value="kmu" />
					</div>
					<div class="input-prepend">
						<span class="add-on">password</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfobyuserid');" class="input-small" type="text" name="password" value="kmugoesmobile" />
					</div>
					<br/><code class="span9" class="span12" id="deviceinfobyuseridcode"></code>
					<div class="span9" ><pre id="deviceinfobyuseridoutput">Output ...</pre></div>
				</fieldset>
			</form>
		</div>	
		
		<div class="thumbnail" style="margin-bottom:5px;">
			<form class="form-inline" id="deviceinfobyqrcode" method="post" target="_blank" action="<?php echo JURI::root(); ?>index.php?option=com_inventory">
				<fieldset>
					<legend><b>Get</b> a device by its QRcode
					<div class="btn-group pull-right">
						<input class="btn  btn-primary" type="button" name="Self" value="_self" onclick="checkOutput('<?php echo JURI::root(); ?>','deviceinfobyqrcode');"/>
						<input class="btn  btn-success" type="button" name="Clear" value="_clear" onclick="clearOutput('deviceinfobyqrcode');"/>
						<input class="btn  btn-info" type="submit" name="Submit" value="_blank" />
					</div>
					</legend>
					<div class="input-prepend">
						<span class="add-on">controller</span>
						<input readonly type="text" name="controller" value="deviceinfobyqrcode" />
					</div>
					<span style="display: inline-block;width: auto;height: 15px;min-width: 16px;padding: 4px 5px;font-size: 13px;font-weight: normal;line-height: 15px;text-align: center;text-shadow: 0 1px 0 #ffffff;background-color: #eeeeee;border: 1px solid #ccc;">format</span>
					<select onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfobyqrcode');" name="format"><option selected>raw</option><option>json</option></select>
					<div class="input-prepend">
						<span class="add-on">username</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfobyqrcode');" class="input-small" type="text" name="username" value="kmu" />
					</div>
					<div class="input-prepend">
						<span class="add-on">password</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfobyqrcode');" class="input-small" type="text" name="password" value="kmugoesmobile" />
					</div>
					<div class="input-prepend">
						<span class="add-on">qrcode</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','deviceinfobyqrcode');" class="input-small" type="text" name="qrcode" value="X1" />
					</div>
					<br/><code class="span9" class="span12" id="deviceinfobyqrcodecode"></code>
					<div class="span9" ><pre id="deviceinfobyqrcodeoutput">Output ...</pre></div>
				</fieldset>
			</form>
		</div>	
		
		<div class="thumbnail" style="margin-bottom:5px;">
			<form class="form-inline" id="lenddevicebyqrcode" method="post" target="_blank" action="<?php echo JURI::root(); ?>index.php?option=com_inventory">
				<fieldset>
					<legend><b>Lend</b> a device by its QRCode
					<div class="btn-group pull-right">
						<input class="btn  btn-primary" type="button" name="Self" value="_self" onclick="checkOutput('<?php echo JURI::root(); ?>','lenddevicebyqrcode');"/>
						<input class="btn  btn-success" type="button" name="Clear" value="_clear" onclick="clearOutput('lenddevicebyqrcode');"/>
						<input class="btn  btn-info" type="submit" name="Submit" value="_blank" />
					</div>
					</legend>
					<div class="input-prepend">
						<span class="add-on">controller</span>
						<input readonly type="text" name="controller" value="lenddevicebyqrcode" />
					</div>
					<span style="display: inline-block;width: auto;height: 15px;min-width: 16px;padding: 4px 5px;font-size: 13px;font-weight: normal;line-height: 15px;text-align: center;text-shadow: 0 1px 0 #ffffff;background-color: #eeeeee;border: 1px solid #ccc;">format</span>
					<select onchange="checkForm('<?php echo JURI::root(); ?>','lenddevicebyqrcode');" name="format"><option selected>raw</option><option>json</option></select>
					<div class="input-prepend">
						<span class="add-on">lent_description</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','lenddevicebyqrcode');" class="input-small" type="text" name="lent_description" value="unknown" />
					</div>
					<div class="input-prepend">
						<span class="add-on">username</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','lenddevicebyqrcode');" class="input-small" type="text" name="username" value="kmu" />
					</div>
					<div class="input-prepend">
						<span class="add-on">password</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','lenddevicebyqrcode');" class="input-small" type="text" name="password" value="kmugoesmobile" />
					</div>
					<div class="input-prepend">
						<span class="add-on">qrcode</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','lenddevicebyqrcode');" class="input-small" type="text" name="qrcode" value="X1" />
					</div>
					<br/><code class="span9" class="span12" id="lenddevicebyqrcodecode"></code>
					<div class="span9" ><pre id="lenddevicebyqrcodeoutput">Output ...</pre></div>
				</fieldset>
			</form>
		</div>	
		
		<div class="thumbnail" style="margin-bottom:5px;">
			<form class="form-inline" id="returndevicebyqrcode" method="post" target="_blank" action="<?php echo JURI::root(); ?>index.php?option=com_inventory">
				<fieldset>
					<legend><b>Return</b> a device by its QRCode
					<div class="btn-group pull-right">
						<input class="btn  btn-primary" type="button" name="Self" value="_self" onclick="checkOutput('<?php echo JURI::root(); ?>','returndevicebyqrcode');"/>
						<input class="btn  btn-success" type="button" name="Clear" value="_clear" onclick="clearOutput('returndevicebyqrcode');"/>
						<input class="btn  btn-info" type="submit" name="Submit" value="_blank" />
					</div>
					</legend>
					<div class="input-prepend">
						<span class="add-on">controller</span>
						<input readonly type="text" name="controller" value="returndevicebyqrcode" />
					</div>
					<span style="display: inline-block;width: auto;height: 15px;min-width: 16px;padding: 4px 5px;font-size: 13px;font-weight: normal;line-height: 15px;text-align: center;text-shadow: 0 1px 0 #ffffff;background-color: #eeeeee;border: 1px solid #ccc;">format</span>
					<select onchange="checkForm('<?php echo JURI::root(); ?>','returndevicebyqrcode');" name="format"><option selected>raw</option><option>json</option></select>
					<div class="input-prepend">
						<span class="add-on">username</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','returndevicebyqrcode');" class="input-small" type="text" name="username" value="kmu" />
					</div>
					<div class="input-prepend">
						<span class="add-on">password</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','returndevicebyqrcode');" class="input-small" type="text" name="password" value="kmugoesmobile" />
					</div>
					<div class="input-prepend">
						<span class="add-on">qrcode</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','returndevicebyqrcode');" class="input-small" type="text" name="qrcode" value="X1" />
					</div>
					<br/><code class="span9" class="span12" id="returndevicebyqrcodecode"></code>
					<div class="span9" ><pre id="returndevicebyqrcodeoutput">Output ...</pre></div>
				</fieldset>
			</form>
		</div>
				
		<div class="thumbnail" style="margin-bottom:5px;">
			<form class="form-inline" id="devicepictures" method="post" target="_blank" action="<?php echo JURI::root(); ?>index.php?option=com_inventory">
				<fieldset>
					<legend><b>Return</b> a device's pictures by its QRCode
					<div class="btn-group pull-right">
						<input class="btn  btn-primary" type="button" name="Self" value="_self" onclick="checkOutput('<?php echo JURI::root(); ?>','devicepictures');"/>
						<input class="btn  btn-success" type="button" name="Clear" value="_clear" onclick="clearOutput('devicepictures');"/>
						<input class="btn  btn-info" type="submit" name="Submit" value="_blank" />
					</div>
					</legend>
					<div class="input-prepend">
						<span class="add-on">controller</span>
						<input readonly type="text" name="controller" value="devicepictures" />
					</div>
					<span style="display: inline-block;width: auto;height: 15px;min-width: 16px;padding: 4px 5px;font-size: 13px;font-weight: normal;line-height: 15px;text-align: center;text-shadow: 0 1px 0 #ffffff;background-color: #eeeeee;border: 1px solid #ccc;">format</span>
					<select onchange="checkForm('<?php echo JURI::root(); ?>','devicepictures');" name="format"><option selected>raw</option><option>json</option></select>
					<div class="input-prepend">
						<span class="add-on">username</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','devicepictures');" class="input-small" type="text" name="username" value="kmu" />
					</div>
					<div class="input-prepend">
						<span class="add-on">password</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','devicepictures');" class="input-small" type="text" name="password" value="kmugoesmobile" />
					</div>
					<div class="input-prepend">
						<span class="add-on">qrcode</span>
						<input onchange="checkForm('<?php echo JURI::root(); ?>','devicepictures');" class="input-small" type="text" name="qrcode" value="X1" />
					</div>
					<br/><code class="span9" class="span12" id="devicepicturescode"></code>
					<div class="span9" ><pre id="devicepicturesoutput">Output ...</pre></div>
				</fieldset>
			</form>
		</div>
	</div>

	<script  type="text/javascript">
		checkForm('<?php echo JURI::root(); ?>','deviceinfobyid');
		checkForm('<?php echo JURI::root(); ?>','deviceinfoall');
		checkForm('<?php echo JURI::root(); ?>','deviceinfobyuserid');
		checkForm('<?php echo JURI::root(); ?>','deviceinfobyqrcode');
		checkForm('<?php echo JURI::root(); ?>','lenddevicebyqrcode');
		checkForm('<?php echo JURI::root(); ?>','returndevicebyqrcode');
		checkForm('<?php echo JURI::root(); ?>','devicepictures');
	</script>
