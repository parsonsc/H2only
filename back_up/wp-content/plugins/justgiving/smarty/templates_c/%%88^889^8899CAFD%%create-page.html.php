<?php /* Smarty version 2.6.28, created on 2015-02-27 11:56:06
         compiled from create-page.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'create-page.html', 23, false),)), $this); ?>
    <p>You're logged in to JustGiving as <?php echo $this->_tpl_vars['Session']['email']; ?>
. Now create your page</p>
    <p>Not <?php echo $this->_tpl_vars['Session']['email']; ?>
? Click <a href="<?php  echo get_permalink(200); ?>">here</a> to logout.</p>

    <form enctype="multipart/form-data" method="post"
          id="createpage" class="user-forms" action="<?php echo $this->_tpl_vars['formurl']; ?>
">

        <div class="container water-bg water-line-top createpage">
            <div class="col-xs-12">
                <!--div class="form-item input-row">
                    <label for="selectUni">Select Your Uni <span class="hint" data-title="This is the title that will appear at the top of your JustGiving fundraising page"></span></label>
                    <div class="selectStyle">
                        <select type="text" name="jointeam" id="team" class="input-text border styled2 <?php if ($this->_tpl_vars['Errors']['jointeam']['message'] != ''): ?>error<?php endif; ?>" validate="required:true" >
                        <?php $_from = $this->_tpl_vars['teams']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                           <option value="<?php echo $this->_tpl_vars['k']; ?>
" <?php if ($this->_tpl_vars['Post']['jointeam'] == $this->_tpl_vars['k'] && $this->_tpl_vars['Post']['jointeam'] != ''): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['v']['label']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>                        
                        </select>                  
                    </div>
                </div -->
                <div class="form-item input-row">
                    <label for="pageshortname" class="jg-placeholder-title">Pick an unforgettable URL <span class="hint" data-title="This is the address of your JustGiving fundraising page ie www.justgiving.com/johnsmith"></span></label>
                    <label class="jg-placeholder" for="pageshortname">www.justgiving.com/</label>

                    <input <?php if (count($this->_tpl_vars['suggestions']) > 0 && $this->_tpl_vars['errorshortname'] != ''): ?>readonly="readonly" name="rpageshortname"<?php else: ?>name="pageshortname"<?php endif; ?> type="text"  id="pageshortname" value="<?php echo $this->_tpl_vars['Post']['pageshortname']; ?>
" class="input-text jg-placeholder-input" validate="required:true"/>
                </div>
                <?php if (count($this->_tpl_vars['suggestions']) > 0 && $this->_tpl_vars['errorshortname'] != ''): ?>
                <div class="form-item input-row url-suggest">
                    <label for="rpageshortname" class="pageSuggestionTitle">Suggested alternative names:</label>
                    <div style="clear: both;"></div>  
                    <div class="url-alternatives">          
                        <select id="rpageshortname" name="pageshortname" size="4" class="pageSuggestgion border <?php if ($this->_tpl_vars['Errors']['pageshortname']['message'] != '' || $this->_tpl_vars['Errors']['shortname']['message'] != ''): ?>error<?php endif; ?>" validate="required:true">
                            <option class="show_mobile" value="" data-teamstory="" disabled selected>Suggested alternative names</option>
                            <?php $_from = $this->_tpl_vars['suggestions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
                            <option  value="<?php echo $this->_tpl_vars['v']['label']; ?>
" <?php if ($this->_tpl_vars['Post']['pageshortname'] == $this->_tpl_vars['v']['label'] && $this->_tpl_vars['Post']['pageshortname'] != ''): ?> selected="selected"<?php endif; ?> ><?php echo $this->_tpl_vars['v']['label']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </div>
                    <!-- <span class="error"><?php echo $this->_tpl_vars['errorshortname']; ?>
</span> -->
                </div>
                <?php endif; ?>
                
                <div class="form-item input-row">
                    <label for="pagetitle">Give your page an awesome title <span class="hint" data-title="This is the title that will appear at the top of your JustGiving fundraising page"></span></label>
                    <input type="text" name="pagetitle" id="pagetitle" value="<?php echo $this->_tpl_vars['Post']['pagetitle']; ?>
" class="input-text <?php if ($this->_tpl_vars['Errors']['pagetitle']['message'] != ''): ?>error<?php endif; ?>" validate="required:true" />
                </div>

                <div class="form-item input-row pick-amount">
                    <label for="targetAmount">Pick a fundraising target <span class="hint" data-title="This is the target amount that will appear on your JustGiving fundraising page"></span></label>

                    <input type="radio" class="radio" id="targetch35" name="targetch" value="35" <?php if ($this->_tpl_vars['Post']['targetch'] == 35 || ! isset ( $this->_tpl_vars['Post']['targetch'] )): ?>checked="checked"<?php endif; ?>/><label for="targetch35" class="first_amount"><p>&pound;35</p></label>

                    <input type="radio" class="radio" id="targetchvar" name="targetch" value="var" <?php if ($this->_tpl_vars['Post']['targetch'] == 'var' || ( $this->_tpl_vars['Post']['target'] != '' && isset ( $this->_tpl_vars['Post']['target'] ) )): ?>checked="checked"<?php endif; ?> placeholder="£"/><label for="targetchvar"><p>or enter amount</p></label>
                    <div class="enterAmount">
                        <input type="number" step="any" name="target" id="targetAmount" value="<?php if ($this->_tpl_vars['Post']['target'] != '' && isset ( $this->_tpl_vars['Post']['target'] )): ?><?php echo $this->_tpl_vars['Post']['target']; ?>
<?php else: ?>35<?php endif; ?>" class="quantity input-text input-amount <?php if ($this->_tpl_vars['Errors']['target']['message'] != ''): ?>error<?php endif; ?>" min="0" max="99999" maxlength="5" validate="required:true" />
                        <span class="unit">&pound;</span>
                    </div>
                </div>  

                <input type="hidden" name="jgoptin" id="jgoptinno" value="0" />   
                <div class="form-item customCheckbox">
                    <input type="checkbox" name="charityoptin" class="checkboxLabel main_street_input" id="choptinyes" value="1"  <?php if ($this->_tpl_vars['Post']['charityoptin'] == 1 || ! isset ( $this->_tpl_vars['Post']['charityoptin'] )): ?>checked="checked"<?php endif; ?>  />
                    <label for="choptinyes"></label> <!-- 1 added at the end for test -->
                    <div class="label">I&rsquo;ll keep Standing Up To Cancer. I&rsquo;d love to hear more about Cancer Research UK's lifesaving work. <span class="hint" data-title="Stay up to date with your charity's news about how your support is helping"></span></div>          
                </div>
                <div class="form-item customCheckbox">
                    <input type="checkbox" name="packbypost" class="checkboxLabel main_street_input" id="packbypostyes" value="1"  <?php if ($this->_tpl_vars['Post']['packbypost'] == 1 || ! isset ( $this->_tpl_vars['Post']['packbypost'] )): ?>checked="checked"<?php endif; ?>  />
                    <label for="packbypostyes"></label> <!-- 1 added at the end for test -->
                    <div class="label">I&rsquo;d like a fundraising pack sent by post please</div>          
                </div>
                
                <div class="form-item customCheckbox">
                    <input type="checkbox" name="advocate" class="checkboxLabel main_street_input" id="advocateyes" value="1"  <?php if ($this->_tpl_vars['Post']['advocate'] == 1): ?>checked="checked"<?php endif; ?>  />
                    <label for="advocateyes"></label> <!-- 1 added at the end for test -->
                    <div class="label">I&rsquo;d like to be an advocate</div>          
                </div>     
                <div class="form-item input-row">
                    <label for="heardAbout">How did you hear about H2Only</label>
                    <div class="selectStyle">
                        <select type="text" name="heardabout" id="heardAbout" class="input-text border styled2 <?php if ($this->_tpl_vars['Errors']['heardabout']['message'] != ''): ?>error<?php endif; ?>" >

                           <option value="blah" <?php if ($this->_tpl_vars['Post']['heardabout'] == 'blah' && $this->_tpl_vars['Post']['heardabout'] != ''): ?> selected="selected"<?php endif; ?>>Blah</option>
                           <option value="blee" <?php if ($this->_tpl_vars['Post']['heardabout'] == 'blee' && $this->_tpl_vars['Post']['heardabout'] != ''): ?> selected="selected"<?php endif; ?>>Blee</option>
                      
                        </select>                  
                    </div>
                </div>  
                <div class="form-item input-row">
                    <label for="work">Where do you work</label>
                    <div class="selectStyle">
                        <select type="text" name="work" id="work" class="input-text border styled2 <?php if ($this->_tpl_vars['Errors']['work']['message'] != ''): ?>error<?php endif; ?>"  >

                           <option value="blah" <?php if ($this->_tpl_vars['Post']['work'] == 'blah' && $this->_tpl_vars['Post']['work'] != ''): ?> selected="selected"<?php endif; ?>>Blah</option>
                           <option value="blee" <?php if ($this->_tpl_vars['Post']['work'] == 'blee' && $this->_tpl_vars['Post']['work'] != ''): ?> selected="selected"<?php endif; ?>>Blee</option>
                      
                        </select>                  
                    </div>
                </div>                    
                <div class="form-item terms customCheckbox">
                    <input type="checkbox" name="tsandcs" class="checkboxLabel main_street_input <?php if ($this->_tpl_vars['Errors']['tsandcs']['message'] != ''): ?>error<?php endif; ?>" id="jgoptinyes2" value="1" <?php if ($this->_tpl_vars['Post']['tsandcs'] == 1): ?>checked="checked"<?php endif; ?> validate="required:true" />
                    
                    <div class="label <?php if ($this->_tpl_vars['Errors']['tsandcs']['message'] != ''): ?>error<?php endif; ?>">I&rsquo;ve read and accept the <a href="<?php  echo get_permalink(61); ?>">Terms &amp; Conditions</a><span class="hint" data-title=""></span></div>                    
                </div>               
            </div>
        </div>

        <div class="col-xs-12 fieldset-submit water-line-bottom createpage">
	        <div class="form-item input-row centered">
                <button class="button submit siteCTA" title="Next" type="submit">
                    Register me!
                </button>          
                <p class="form-submit">
                    <input name="action" type="hidden" id="action" value="createpage" />
                    <input type="hidden" name="formName" value="createpage" />
                </p>
                <?php echo $this->_tpl_vars['nonce']; ?>

                <?php if ($this->_tpl_vars['Errors']['tsandcs']['message'] != '' || $this->_tpl_vars['Errors']['shortname']['message'] != '' || $this->_tpl_vars['Errors']['pagetitle']['message'] != '' || $this->_tpl_vars['Errors']['pageshortname']['message'] != '' || $this->_tpl_vars['Errors']['jointeam']['message'] != ''): ?>
                <div class="error-list"><p>Some fields are invalid: </p>
                <ul>
                    <?php if ($this->_tpl_vars['Errors']['jointeam']['message'] != ''): ?>
                        <li>Team: Please choose your team.</li>
                    <?php endif; ?>                
                    <?php if ($this->_tpl_vars['Errors']['pagetitle']['message'] != ''): ?>
                        <li>Page title: Please enter your page title</li>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['Errors']['pageshortname']['message'] != ''): ?>
                        <li>Unforgettable URL: <?php echo $this->_tpl_vars['Errors']['pageshortname']['message']; ?>
</li>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['Errors']['shortname']['message'] != ''): ?>
                        <li>Unforgettable URL: <?php echo $this->_tpl_vars['Errors']['shortname']['message']; ?>
</li>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['Errors']['tsandcs']['message'] != ''): ?>
                        <li>Terms and conditions: You must agree to the Terms and Conditions to proceed</li>
                    <?php endif; ?>
                </ul></div>                     
                <?php else: ?>
                <p class="required_text"></p>
                <?php endif; ?>                
	        </div>
        </div>

    </form>