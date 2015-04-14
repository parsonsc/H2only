<?php
if (!defined('CRONEXPORT_VERSION'))
	exit('No direct script access allowed');
?>
<div id="framework_wrap" class="wrap">
    <div id="header">
        <h1>Cron Export</h1>
        <span class="icon">&nbsp;</span>
        <div class="version">
          <?php echo 'Version ' . CRONEXPORT_VERSION; ?>
        </div>
    </div>
    <div id="content_wrap">
        <div id="general-settings" class="block">
            <form method="post" action="options.php#general-settings">
            <?php $wppb_generalSettings = get_option('cr_general_settings'); ?>
            <?php settings_fields('cr_general_settings'); ?>
            <h2><?php _e('General Settings', 'cronexport');?></h2>

            <div class="form-item">
            <label for="Server"><?php _e('Server:', 'cronexport');?></label>
            <input type="text" id="Server" name="cr_general_settings[Server]" class="cr_general_settings" value="<?php echo $wppb_generalSettings['Server']; ?>" />
            </div>
            <div class="form-item">
            <label for="TestUsername"><?php _e('Username:', 'cronexport');?></label>
            <input type="text" id="TestUsername" name="cr_general_settings[Username]" class="cr_general_settings" value="<?php echo $wppb_generalSettings['Username']; ?>" />
            </div>
            <div class="form-item">
            <label for="ValidPassword"><?php _e('ValidPassword:', 'cronexport');?></label>
            <input type="text" id="ValidPassword" name="cr_general_settings[ValidPassword]" class="cr_general_settings" value="<?php echo $wppb_generalSettings['ValidPassword']; ?>" />
            </div>
            <div class="form-item">
            <label for="RemotePath"><?php _e('Remote Path:', 'cronexport');?></label>
            <input type="text" id="RemotePath" name="cr_general_settings[RemotePath]" class="cr_general_settings" value="<?php echo $wppb_generalSettings['RemotePath']; ?>" />
            </div>
            <div align="right">
		<input type="hidden" name="action" value="update" />
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /> 
		</p>
            </div>
            </form>
    	</div>
        <div class="info bottom"></div> 
    </div>
</div>    