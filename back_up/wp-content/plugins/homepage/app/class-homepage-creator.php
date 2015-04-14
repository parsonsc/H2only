<?php

class Homepage_Creator {

	private $parent_view, $list_table;
	
	function __construct($parent) {
		
		$this->parent_view = $parent;
	}
	
	function render( $id, $config ) {
		
		?>
		
		<?php 
		$config = str_replace("<", "&lt;", $config);
		$config = str_replace(">", "&gt;", $config);
		?>
		
		<h3><?php _e( 'General Options', 'homepage_blocks' ); ?></h3>
		
		<div id="homepage-id" style="display:none;"><?php echo $id; ?></div>
		<div id="homepage-id-config" style="display:none;"><?php echo $config; ?></div>
		<div id="homepage-jsfolder" style="display:none;"><?php echo HOMEPAGE_URL . 'engine/'; ?></div>
		<div id="homepage-wp-history-media-uploader" style="display:none;"><?php echo ( function_exists("wp_enqueue_media") ? "0" : "1"); ?></div>
				
		<div style="margin:0 12px;">
		<table class="homepage-form-table">
			<tr>
				<th><?php _e( 'Name', 'homepage_blocks' ); ?></th>
				<td><input name="homepage-name" type="text" id="homepage-name" value="My Slider" class="regular-text" /></td>
			</tr>
		</table>
		</div>
		
		<h3><?php _e( 'Designing', 'homepage_blocks' ); ?></h3>
		
		<div style="margin:0 12px;">
		<ul class="homepage-tab-buttons" id="homepage-toolbar">
			<li class="homepage-tab-button step1 homepage-tab-buttons-selected"><?php _e( 'Images, Videos & Texts', 'homepage_blocks' ); ?></li>
			<li class="homepage-tab-button step2"><?php _e( 'Options', 'homepage_blocks' ); ?></li>
			<li class="homepage-tab-button step3"><?php _e( 'Preview', 'homepage_blocks' ); ?></li>
			<li class="laststep"><input class="button button-primary" type="button" value="<?php _e( 'Save & Publish', 'homepage_blocks' ); ?>"></input></li>
		</ul>
				
		<ul class="homepage-tabs" id="homepage-tabs">
			<li class="homepage-tab homepage-tab-selected">	
			
				<div class="homepage-toolbar">	
					<input type="button" class="button" id="homepage-add-image" value="<?php _e( 'Add Image', 'homepage_blocks' ); ?>" />
					<input type="button" class="button" id="homepage-add-video" value="<?php _e( 'Add Video', 'homepage_blocks' ); ?>" />
					<input type="button" class="button" id="homepage-add-youtube" value="<?php _e( 'Add YouTube', 'homepage_blocks' ); ?>" />
					<input type="button" class="button" id="homepage-add-vimeo" value="<?php _e( 'Add Vimeo', 'homepage_blocks' ); ?>" />
					<input type="button" class="button" id="homepage-add-text" value="<?php _e( 'Add Text', 'homepage_blocks' ); ?>" />
				</div>
        		
        		<ul class="homepage-table" id="homepage-media-table">
			    </ul>
			    <div style="clear:both;"></div>
      
			</li>
			<li class="homepage-tab">
			
				<div class="homepage-options">
					<div class="homepageoptions-menu" id="homepage-options-menu">
						<div class="homepage-options-menu-item homepage-options-menu-item-selected"><?php _e( 'Slider options', 'homepage_blocks' ); ?></div>
						<div class="homepage-options-menu-item"><?php _e( 'Transition effects', 'homepage_blocks' ); ?></div>
						<div class="homepage-options-menu-item"><?php _e( 'Skin options', 'homepage_blocks' ); ?></div>
						<div class="homepage-options-menu-item"><?php _e( 'Text effect', 'homepage_blocks' ); ?></div>
						<div class="homepage-options-menu-item"><?php _e( 'Lightbox options', 'homepage_blocks' ); ?></div>
						<div class="homepage-options-menu-item"><?php _e( 'Advanced options', 'homepage_blocks' ); ?></div>
					</div>
					
					<div class="homepage-options-tabs" id="homepage-options-tabs">
						<div class="homepage-options-tab homepage-options-tab-selected">
							<table class="homepage-form-table-noborder">
								<tr>
									<th>Slideshow</th>
									<td><label><input name='homepage-autoplay' type='checkbox' id='homepage-autoplay' value='' /> Auto play</label>
									<br /><label><input name='homepage-randomplay' type='checkbox' id='homepage-randomplay' value='' /> Random play</label>
									</td>
								</tr>
								<tr>
									<th>Video</th>
									<td><label><input name='homepage-autoplayvideo' type='checkbox' id='homepage-autoplayvideo' value='' /> Auto play video</label>
									</td>
								</tr>
								<tr>
									<th>Responsive</th>
									<td><label><input name='homepage-isresponsive' type='checkbox' id='homepage-isresponsive' value='' /> Create a responsive slider</label><br />
									<label><input name='homepage-fullwidth' type='checkbox' id='homepage-fullwidth' value='' /> Create a full width slider</label>
									</td>
								</tr>
								<tr>
									<th>Image resize mode</th>
									<td><label>
										<select name='homepage-scalemode' id='homepage-scalemode'>
										  <option value="fit">Resize to fit</option>
										  <option value="fill">Resize to fill</option>
										</select>
									</label></td>
								</tr>
								<tr>
									<th>Text</th>
									<td><label><input name='homepage-showtext' type='checkbox' id='homepage-showtext' value='' /> Show text</label></td>
								</tr>
								<tr>
									<th>Timer</th>
									<td><label><input name='homepage-showtimer' type='checkbox' id='homepage-showtimer' value='' /> Show a line timer at the bottom of the image when slideshow playing</label></td>
								</tr>
								<tr>
									<th>Loop times ( 0 will loop forever)</th>
									<td><label><input name='homepage-loop' type='text' size="10" id='homepage-loop' value='0' /></label></td>
								</tr>
								<tr>
									<th>Slideshow interval (ms)</th>
									<td><label><input name='homepage-slideinterval' type='text' size="10" id='homepage-slideinterval' value='8000' /></label></td>
								</tr>
							</table>
						</div>
						<div class="homepage-options-tab">
							<table class="homepage-form-table-noborder">
								<tr>
									<th><p>Select transition effect</p></th>
									<td>
										<p><label><input name='homepage-effect-fade' type='checkbox' id='homepage-effect-fade' value='fade' /> Fade</label></p>
										<p><label><input name='homepage-effect-crossfade' type='checkbox' id='homepage-effect-crossfade' value='crossfade' /> Crossfade</label></p>
										<p><label><input name='homepage-effect-slide' type='checkbox' id='homepage-effect-slide' value='slide' /> Slide</label></p>
										<p><label><input name='homepage-effect-elastic' type='checkbox' id='homepage-effect-elastic' value='slide' /> Elastic slide</label></p>
										<p><label><input name='homepage-effect-slice' type='checkbox' id='homepage-effect-slice' value='slice' /> Slice</label></p>
										<p><label><input name='homepage-effect-blinds' type='checkbox' id='homepage-effect-blinds' value='blinds' /> Blinds</label></p>
										<p><label><input name='homepage-effect-threed' type='checkbox' id='homepage-effect-threed' value='threed' /> 3D</label></p>
										<p><label><input name='homepage-effect-threedhorizontal' type='checkbox' id='homepage-effect-threedhorizontal' value='threedhorizontal' /> 3D horizontal</label></p>
										<p><label><input name='homepage-effect-blocks' type='checkbox' id='homepage-effect-blocks' value='blocks' /> Blocks</label></p>
										<p><label><input name='homepage-effect-shuffle' type='checkbox' id='homepage-effect-shuffle' value='shuffle' /> Shuffle</label></p>
									</td>
								</tr>
							</table>
						</div>
						<div class="homepage-options-tab">
							<p class="homepage-options-tab-title"><?php _e( 'Skin option will be restored to its default value if you switch to a new skin in the Skins tab.', 'homepage_gallery' ); ?></p>
							<table class="homepage-form-table-noborder">
								<tr>
									<th>Slideshow padding</th>
									<td>Padding left: <input name='homepage-paddingleft' type='text' size="10" id='homepage-paddingleft' value='0' />
									Padding right: <input name='homepage-paddingright' type='text' size="10" id='homepage-paddingright' value='0' />
									Padding top: <input name='homepage-paddingtop' type='text' size="10" id='homepage-paddingtop' value='0' />
									Padding bottom: <input name='homepage-paddingbottom' type='text' size="10" id='homepage-paddingbottom' value='0' />
									</td>
								</tr>
								<tr>
									<th>Show bottom shadow</th>
									<td><label><input name='homepage-showbottomshadow' type='checkbox' id='homepage-showbottomshadow'  /> Show bottom shadow</label>
									</td>
								</tr>
								<tr>
									<th>Show thumbnail preview</th>
									<td><label><input name='homepage-navshowpreview' type='checkbox' id='homepage-navshowpreview'  /> Show thumbnail preview</label>
									</td>
								</tr>
								<tr>
									<th>Border size</th>
									<td><label><input name='homepage-border' type='text' size="10" id='homepage-border' value='0' /></label></td>
								</tr>
								<tr>
									<th>Arrows</th>
									<td><label>
										<select name='homepage-arrowstyle' id='homepage-arrowstyle'>
										  <option value="mouseover">Show on mouseover</option>
										  <option value="always">Always show</option>
										  <option value="none">Hide</option>
										</select>
									</label></td>
								</tr>
								<tr>
									<th>Arrow image</th>
									<td>
										<img id="homepage-displayarrowimage" />
										<br />
										<label>
											<input type="radio" name="homepage-arrowimagemode" value="custom">
											<span style="display:inline-block;min-width:240px;">Use own image (absolute URL required):</span>
											<input name='homepage-customarrowimage' type='text' class="regular-text" id='homepage-customarrowimage' value='' />
										</label>
										<br />
										<label>
											<input type="radio" name="homepage-arrowimagemode" value="defined">
											<span style="display:inline-block;min-width:240px;">Select from pre-defined images:</span>
											<select name='homepage-arrowimage' id='homepage-arrowimage'>
											<?php 
												$arrowimage_list = array("arrows-32-32-0.png", "arrows-32-32-1.png", "arrows-32-32-2.png", "arrows-32-32-3.png", "arrows-32-32-4.png", 
														"arrows-36-36-0.png",
														"arrows-36-80-0.png",
														"arrows-48-48-0.png", "arrows-48-48-1.png", "arrows-48-48-2.png", "arrows-48-48-3.png", "arrows-48-48-4.png",
														"arrows-72-72-0.png");
												foreach ($arrowimage_list as $arrowimage)
													echo '<option value="' . $arrowimage . '">' . $arrowimage . '</option>';
											?>
											</select>
										</label><br />
										<script language="JavaScript">
										jQuery(document).ready(function(){
											jQuery("input:radio[name=homepage-arrowimagemode]").click(function(){
												if (jQuery(this).val() == 'custom')
													jQuery("#homepage-displayarrowimage").attr("src", jQuery('#homepage-customarrowimage').val());
												else
													jQuery("#homepage-displayarrowimage").attr("src", "<?php echo HOMEPAGE_URL . 'engine/'; ?>" + jQuery('#homepage-arrowimage').val());
											});

											jQuery("#homepage-arrowimage").change(function(){
												if (jQuery("input:radio[name=homepage-arrowimagemode]:checked").val() == 'defined')
													jQuery("#homepage-displayarrowimage").attr("src", "<?php echo HOMEPAGE_URL . 'engine/'; ?>" + jQuery(this).val());
												var arrowsize = jQuery(this).val().split("-");
												if (arrowsize.length > 2)
												{
													if (!isNaN(arrowsize[1]))
														jQuery("#homepage-arrowwidth").val(arrowsize[1]);
													if (!isNaN(arrowsize[2]))
														jQuery("#homepage-arrowheight").val(arrowsize[2]);
												}
													
											});
										});
										</script>
										<label><span style="display:inline-block;min-width:100px;">Width:</span> <input name='homepage-arrowwidth' type='text' size="10" id='homepage-arrowwidth' value='32' /></label>
										<label><span style="display:inline-block;min-width:100px;margin-left:36px;">Height:</span> <input name='homepage-arrowheight' type='text' size="10" id='homepage-arrowheight' value='32' /></label><br />
										<label><span style="display:inline-block;min-width:100px;">Left/right margin:</span> <input name='homepage-arrowmargin' type='text' size="10" id='homepage-arrowmargin' value='8' /></label>
										<label><span style="display:inline-block;min-width:100px;margin-left:36px;">Top (percent):</span> <input name='homepage-arrowtop' type='text' size="10" id='homepage-arrowtop' value='50' /></label>
										
									</td>
								</tr>
								<tr id="homepage-confignavimage">
									<th>Bullets image</th>
									<td>
										<img id="homepage-displaynavimage" />
										<br />
										<label>
											<input type="radio" name="homepage-navimagemode" value="custom">
											<span style="display:inline-block;min-width:240px;">Use own image (absolute URL required):</span>
											<input name='homepage-customnavimage' type='text' class="regular-text" id='homepage-customnavimage' value='' />
										</label>
										<br />
										<label>
											<input type="radio" name="homepage-navimagemode" value="defined">
											<span style="display:inline-block;min-width:240px;">Select from pre-defined images:</span>
											<select name='homepage-navimage' id='homepage-navimage'>
											<?php 
												$navimage_list = array("bullet-12-12-0.png",
														"bullet-16-16-0.png", "bullet-16-16-1.png", "bullet-16-16-2.png", "bullet-16-16-3.png", 
														"bullet-20-20-0.png", "bullet-20-20-1.png", 
														"bullet-24-24-0.png", "bullet-24-24-1.png", "bullet-24-24-2.png", "bullet-24-24-3.png", "bullet-24-24-4.png", "bullet-24-24-5.png", "bullet-24-24-6.png");
												foreach ($navimage_list as $navimage)
													echo '<option value="' . $navimage . '">' . $navimage . '</option>';
											?>
											</select>
										</label><br />
										<script language="JavaScript">
										jQuery(document).ready(function(){
											jQuery("input:radio[name=homepage-navimagemode]").click(function(){
												if (jQuery(this).val() == 'custom')
													jQuery("#homepage-displaynavimage").attr("src", jQuery('#homepage-customnavimage').val());
												else
													jQuery("#homepage-displaynavimage").attr("src", "<?php echo HOMEPAGE_URL . 'engine/'; ?>" + jQuery('#homepage-navimage').val());
											});

											jQuery("#homepage-navimage").change(function(){
												if (jQuery("input:radio[name=homepage-navimagemode]:checked").val() == 'defined')
													jQuery("#homepage-displaynavimage").attr("src", "<?php echo HOMEPAGE_URL . 'engine/'; ?>" + jQuery(this).val());
												var arrowsize = jQuery(this).val().split("-");
												if (arrowsize.length > 2)
												{
													if (!isNaN(arrowsize[1]))
														jQuery("#homepage-navwidth").val(arrowsize[1]);
													if (!isNaN(arrowsize[2]))
														jQuery("#homepage-navheight").val(arrowsize[2]);
												}
													
											});
										});
										</script>
										<label><span style="display:inline-block;min-width:100px;">Width:</span> <input name='homepage-navwidth' type='text' size="10" id='homepage-navwidth' value='32' /></label>
										<label><span style="display:inline-block;min-width:100px;margin-left:36px;">Height:</span> <input name='homepage-navheight' type='text' size="10" id='homepage-navheight' value='32' /></label><br />
										<label><span style="display:inline-block;min-width:100px;">Margin X:</span> <input name='homepage-arrowmarginx' type='text' size="10" id='homepage-arrowmarginx' value='8' /></label>
										<label><span style="display:inline-block;min-width:100px;margin-left:36px;">Margin Y:</span> <input name='homepage-arrowmarginy' type='text' size="10" id='homepage-arrowmarginy' value='8' /></label><br />
										<label><span style="display:inline-block;min-width:100px;">Spacing:</span> <input name='homepage-navspacing' type='text' size="10" id='homepage-navspacing' value='8' /></label>
										
									</td>
								</tr>
								
								<tr id="homepage-configplayvideoimage">
									<th>Play video button</th>
									<td>
										<img id="homepage-displayplayvideoimage" />
										<br />
										<label>
											<span style="display:inline-block;min-width:240px;">Select from pre-defined images:</span>
											<select name='homepage-playvideoimage' id='homepage-playvideoimage'>
											<?php 
												$playvideoimage_list = array("playvideo-64-64-0.png", "playvideo-64-64-1.png", "playvideo-64-64-2.png", "playvideo-64-64-3.png", "playvideo-64-64-4.png", "playvideo-64-64-5.png",
														"playvideo-72-72-0.png");
												foreach ($playvideoimage_list as $playvideoimage)
													echo '<option value="' . $playvideoimage . '">' . $playvideoimage . '</option>';
											?>
											</select>
										</label><br />
										<script language="JavaScript">
										jQuery(document).ready(function(){

											jQuery("#homepage-playvideoimage").change(function(){
												jQuery("#homepage-displayplayvideoimage").attr("src", "<?php echo HOMEPAGE_URL . 'engine/'; ?>" + jQuery(this).val());
												var arrowsize = jQuery(this).val().split("-");
												if (arrowsize.length > 2)
												{
													if (!isNaN(arrowsize[1]))
														jQuery("#homepage-playvideoimagewidth").val(arrowsize[1]);
													if (!isNaN(arrowsize[2]))
														jQuery("#homepage-playvideoimageheight").val(arrowsize[2]);
												}							
											});
										});
										</script>
										<label><span style="display:inline-block;min-width:100px;">Width:</span> <input name='homepage-playvideoimagewidth' type='text' size="10" id='homepage-playvideoimagewidth' value='32' /></label>
										<label><span style="display:inline-block;min-width:100px;margin-left:36px;">Height:</span> <input name='homepage-playvideoimageheight' type='text' size="10" id='homepage-playvideoimageheight' value='32' /></label><br />										
									</td>
								</tr>
							</table>
						</div>
						
						<div class="homepage-options-tab">
							<table class="homepage-form-table-noborder">
								<tr>
									<th>Select a pre-defined text effect</th>
									<td><label>
										<select name='homepage-textformat' id='homepage-textformat'>
										  <?php 
												$textformat_list = array('Bottom bar', 'Bottom left', 'Center text', 'Center box', 'Left text', 'Color box', 'Blue box', 'Red box', 'Navy box', 'Pink box', 'Light box', 'Grey box', 'Color box right align', 'Red title', 'White title', 'Yellow title', 'Underneath center', 'Underneath left', 'None');
												foreach ($textformat_list as $textformat)
													echo '<option value="' . $textformat . '">' . $textformat . '</option>';
											?>
										</select>
									</label></td>
								</tr>
								
								<tr>
									<th></th>
									<td>* The following options will be restored to the default value if you change text effect in the above drop-down list.
									</td>
								</tr>
								
								<tr>
									<th>Text CSS</th>
									<td><label><textarea name="homepage-textcss" id="homepage-textcss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								<tr>
									<th>Text background CSS</th>
									<td><label><textarea name="homepage-textbgcss" id="homepage-textbgcss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								<tr>
									<th>Title CSS</th>
									<td><label><textarea name="homepage-titlecss" id="homepage-titlecss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								<tr>
									<th>Description CSS</th>
									<td><label><textarea name="homepage-descriptioncss" id="homepage-descriptioncss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								
								<tr>
									<th>Position</th>
									<td>
									<div class='homepage-texteffect-static'>
										<select name='homepage-textpositionstatic' id='homepage-textpositionstatic'>
										  <option value="top">top</option>
										  <option value="bottom">bottom</option>
										  <option value="topoutside">topoutside</option>
										  <option value="bottomoutside">bottomoutside</option>
										</select>
									</div>
									<div  class='homepage-texteffect-dynamic'>
										<label><input name='homepage-textpositiondynamic-topleft' type='checkbox' id='homepage-textpositiondynamic-topleft' value='topleft' /> topleft</label> 
										<label><input name='homepage-textpositiondynamic-topright' type='checkbox' id='homepage-textpositiondynamic-topright' value='topright' /> topright</label> 
										<label><input name='homepage-textpositiondynamic-bottomleft' type='checkbox' id='homepage-textpositiondynamic-bottomleft' value='bottomleft' /> bottomleft</label> 
										<label><input name='homepage-textpositiondynamic-bottomright' type='checkbox' id='homepage-textpositiondynamic-bottomright' value='bottomright' /> bottomright</label>
										<label><input name='homepage-textpositiondynamic-topcenter' type='checkbox' id='homepage-textpositiondynamic-topcenter' value='topcenter' /> topcenter</label>
										<label><input name='homepage-textpositiondynamic-bottomcenter' type='checkbox' id='homepage-textpositiondynamic-bottomcenter' value='bottomcenter' /> bottomcenter</label>
										<label><input name='homepage-textpositiondynamic-centercenter' type='checkbox' id='homepage-textpositiondynamic-centercenter' value='centercenter' /> centercenter</label>
										</div>
									</td>
								</tr>
								
							</table>
						</div>
    
						<div class="homepage-options-tab">
							<table class="homepage-form-table-noborder">
								<tr>
									<th>Responsive</th>
									<td><label><input name='homepage-lightboxresponsive' type='checkbox' id='homepage-lightboxresponsive'  /> Responsive</label>
									</td>
								</tr>
								
								<tr>
									<th>Thumbnails</th>
									<td><label><input name='homepage-lightboxshownavigation' type='checkbox' id='homepage-lightboxshownavigation'  /> Show thumbnails</label>
									</td>
								</tr>
								<tr>
									<th></th>
									<td><label>Size: <input name="homepage-lightboxthumbwidth" type="text" id="homepage-lightboxthumbwidth" value="96" class="small-text" /> x <input name="homepage-lightboxthumbheight" type="text" id="homepage-lightboxthumbheight" value="72" class="small-text" /></label> 
									<label>Top margin: <input name="homepage-lightboxthumbtopmargin" type="text" id="homepage-lightboxthumbtopmargin" value="12" class="small-text" /> Bottom margin: <input name="homepage-lightboxthumbbottommargin" type="text" id="homepage-lightboxthumbbottommargin" value="12" class="small-text" /></label>
									</td>
								</tr>
								<tr>
									<th>Maximum text bar height</th>
									<td><label><input name="homepage-lightboxbarheight" type="text" id="homepage-lightboxbarheight" value="64" class="small-text" /></label>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Title</th>
									<td><label><input name="homepage-lightboxshowtitle" type="checkbox" id="homepage-lightboxshowtitle" /> Show title</label></td>
								</tr>
								
								<tr>
									<th>Title CSS</th>
									<td><label><textarea name="homepage-lightboxtitlebottomcss" id="homepage-lightboxtitlebottomcss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Description</th>
									<td><label><input name="homepage-lightboxshowdescription" type="checkbox" id="homepage-lightboxshowdescription" /> Show description</label></td>
								</tr>
								
								<tr>
									<th>Description CSS</th>
									<td><label><textarea name="homepage-lightboxdescriptionbottomcss" id="homepage-lightboxdescriptionbottomcss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								
							</table>
						</div>						

						<div class="homepage-options-tab">
							<table class="homepage-form-table-noborder">
								<tr>
									<th>Custom CSS</th>
									<td><textarea name='homepage-custom-css' id='homepage-custom-css' value='' class='large-text' rows="10"></textarea></td>
								</tr>
								<tr>
									<th>Advanced Options</th>
									<td><textarea name='homepage-data-options' id='homepage-data-options' value='' class='large-text' rows="10"></textarea></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				
			</li>
			<li class="homepage-tab">
				<div id="homepage-preview-tab">
					<div id="homepage-preview-container">
					</div>
				</div>
			</li>
			<li class="homepage-tab">
				<div id="homepage-publish-loading"></div>
				<div id="homepage-publish-information"></div>
			</li>
		</ul>
		</div>
		
		<?php
	}
	
	function get_list_data() {
		return array();
	}
}