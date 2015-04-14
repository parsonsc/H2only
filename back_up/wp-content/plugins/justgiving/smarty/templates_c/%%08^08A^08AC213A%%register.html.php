<?php /* Smarty version 2.6.28, created on 2015-03-03 14:41:49
         compiled from register.html */ ?>
<div class="registerSection">
    <div class="reg_title">
        <h2><strong>Register</strong></h2>
        <p>Need to create a JustGiving account? Just enter your details here</p>
    </div>
    <form enctype="multipart/form-data" method="post" 
        id="adduser" class="user-forms container" action="<?php echo $this->_tpl_vars['formurl']; ?>
">
       
    <div class="row water-bg water-line-top">    
    <div class="col-xs-* col-xs-12 fieldset">
        <div class="form-item input-row">
            <label for="title" class="inline">Title*</label>
            <div class="selectStyle">
                <select name="title" id="title" class="input-text styled2 border <?php if ($this->_tpl_vars['Errors']['title']['message'] != ''): ?>error<?php endif; ?>" >
                    <option value=""></option>
                    <option value="Mr" <?php if ($this->_tpl_vars['Post']['title'] == 'Mr'): ?> selected="selected"<?php endif; ?>>Mr</option>
                    <option value="Mrs" <?php if ($this->_tpl_vars['Post']['title'] == 'Mrs'): ?> selected="selected"<?php endif; ?>>Mrs</option>
                    <option value="Miss" <?php if ($this->_tpl_vars['Post']['title'] == 'Miss'): ?> selected="selected"<?php endif; ?>>Miss</option>
                    <option value="Ms" <?php if ($this->_tpl_vars['Post']['title'] == 'Ms'): ?> selected="selected"<?php endif; ?>>Ms</option>
                    <option value="Dr" <?php if ($this->_tpl_vars['Post']['title'] == 'Dr'): ?> selected="selected"<?php endif; ?>>Dr</option>
                    <option value="Other" <?php if ($this->_tpl_vars['Post']['title'] == 'Other'): ?> selected="selected"<?php endif; ?>>Other</option>
                </select>
                <span class="other"><input type="text" name="other_title" id="other_title"  value="<?php echo $this->_tpl_vars['Post']['other_title']; ?>
" class="input-text <?php if ($this->_tpl_vars['Errors']['other_title']['message'] != ''): ?>error<?php endif; ?>" /></span>
            </div>
        </div>
        <div class="form-item input-row">
            <label for="firstname" class="inline">First name*</label>
            <input type="text" name="firstname" id="firstname" value="<?php echo $this->_tpl_vars['Post']['firstname']; ?>
" class="input-text <?php if ($this->_tpl_vars['Errors']['firstname']['message'] != ''): ?>error<?php endif; ?>"  />
        </div>
        <div class="form-item input-row">
            <label for="lastname" class="inline">Last name*</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo $this->_tpl_vars['Post']['lastname']; ?>
" class="input-text <?php if ($this->_tpl_vars['Errors']['lastname']['message'] != ''): ?>error<?php endif; ?>"  />
        </div>
    </div> <!-- END Fieldset 1 -->

	<div class="col-xs-* col-xs-12 fieldset">
        <div class="form-item input-row">
            <label for="address" class="inline">Address line 1*</label>
            <input type="text" name="address" id="address" value="<?php echo $this->_tpl_vars['Post']['address']; ?>
" class="input-text <?php if ($this->_tpl_vars['Errors']['address']['message'] != ''): ?>error<?php endif; ?>"  />
        </div>
        <!--div class="form-item input-row">
            <label for="address2" class="inline">Address line 2*</label>
            <input type="text" name="address2" id="address2" value="<?php echo $this->_tpl_vars['Post']['address2']; ?>
" class="input-text <?php if ($this->_tpl_vars['Errors']['address2']['message'] != ''): ?>error<?php endif; ?>"  />
        </div -->
        <div class="form-item input-row">
            <label for="town" class="inline">Town or City*</label>
            <input type="text" name="town" id="town" value="<?php echo $this->_tpl_vars['Post']['town']; ?>
" class="input-text <?php if ($this->_tpl_vars['Errors']['town']['message'] != ''): ?>error<?php endif; ?>"  />
        </div>
        <div class="form-item input-row">
            <label for="country" class="inline">Country*</label>  
            <div class="selectStyle">      
                <select id="country" name="country" class="input-text styled2 border <?php if ($this->_tpl_vars['Errors']['country']['message'] != ''): ?>error<?php endif; ?>">
            <?php $_from = $this->_tpl_vars['countries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['country']):
?>
                <option value="<?php echo $this->_tpl_vars['country']->name; ?>
" 
                    <?php if ($this->_tpl_vars['country']->name == $this->_tpl_vars['Post']['country']): ?> selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['country']->name; ?>
</option>
            <?php endforeach; endif; unset($_from); ?> 
                </select>
            </div>
        </div>         
        <div class="form-item input-row">
            <label for="postcode" class="inline">Postcode*</label>
            <input type="text" name="postcode" id="postcode" value="<?php echo $this->_tpl_vars['Post']['postcode']; ?>
" class="input-text <?php if ($this->_tpl_vars['Errors']['postcode']['message'] != ''): ?>error<?php endif; ?>"  />
        </div>       
    </div> 

    <div class="col-xs-* col-xs-12 fieldset email">
        <div class="form-item input-row">
            <label for="email" class="inline">Email*</label>
            <input type="email" name="email" id="email" value="<?php echo $this->_tpl_vars['Post']['email']; ?>
" class="input-text <?php if ($this->_tpl_vars['Errors']['email']['message'] != ''): ?>error<?php endif; ?>"  />
        </div>
    </div> <!-- END Fieldset -->
    <div class="form-item input-row ">
        <label for="password" class="inline label">Password*</label>
        <input type="password" name="password" id="password" value="<?php echo $this->_tpl_vars['Post']['password']; ?>
" class="input-text password <?php if ($this->_tpl_vars['Errors']['password']['message'] != ''): ?>error<?php endif; ?>"  />
    </div>
    <!--div class="form-item input-row ">
        <label for="cpassword" class="inline label">Confirm password*</label>
        <input type="password" name="cpassword" id="cpassword" equalTo="#adduser #password" value="<?php echo $this->_tpl_vars['Post']['cpassword']; ?>
" class="input-text password <?php if ($this->_tpl_vars['Errors']['cpassword']['message'] != ''): ?>error<?php endif; ?>"  />
    </div -->
    <div class="form-item terms customCheckbox">
        <input type="checkbox" name="tsandcs" class="checkboxLabel main_street_input <?php if ($this->_tpl_vars['Errors']['tsandcs']['message'] != ''): ?>error<?php endif; ?>" id="jgoptinyes2" value="1" <?php if ($this->_tpl_vars['Post']['tsandcs'] == 1): ?>checked="checked"<?php endif; ?> validate="required:true" />
        <div class="label <?php if ($this->_tpl_vars['Errors']['tsandcs']['message'] != ''): ?>error<?php endif; ?>">I&rsquo;ve read and accept the <a href="<?php  echo get_permalink(61); ?>">Terms &amp; Conditions</a><span class="hint" data-title=""></span></div>                    
    </div>
    <input type="hidden" name="createpage" id="createpageyes" value="1" />
    <input type="hidden" name="haveaccount" id="haveaccountno" value="0" /> 

  	<div class="water-line-bottom"></div>


     <div class="row">
     <div class="col-xs-* col-xs-12 fieldset-submit water-line-top">  
        <div class="form-item input-row centered">
            <button class="button submit siteCTA" title="Complete sign up" type="submit">
                Register Me!
            </button>
        </div>
        <p class="form-submit">
            <input name="action" type="hidden" id="action" value="adduser" />
            <input type="hidden" name="formName" value="register" />
        </p><!-- .form-submit -->

		<?php echo $this->_tpl_vars['nonce']; ?>

        
        <?php if ($this->_tpl_vars['Errors']['title']['message'] != '' || $this->_tpl_vars['Errors']['firstname']['message'] != '' || $this->_tpl_vars['Errors']['lastname']['message'] != '' || $this->_tpl_vars['Errors']['dob']['message'] != '' || $this->_tpl_vars['Errors']['address']['message'] != '' || $this->_tpl_vars['Errors']['address2']['message'] != '' || $this->_tpl_vars['Errors']['town']['message'] != '' || $this->_tpl_vars['Errors']['county']['message'] != '' || $this->_tpl_vars['Errors']['postcode']['message'] != '' || $this->_tpl_vars['Errors']['country']['message'] != '' || $this->_tpl_vars['Errors']['email']['message'] != '' || $this->_tpl_vars['Errors']['password']['message'] != '' || $this->_tpl_vars['Errors']['cpassword']['message'] != ''): ?>
            <div class="error-list"><p>Some fields are invalid: </p>
            <ul>
                <?php if ($this->_tpl_vars['Errors']['title']['message'] != ''): ?>  
                    <li>Title: Sorry! You need to fill in this field.</li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['Errors']['firstname']['message'] != ''): ?>            
                    <li>First name: Sorry! You need to fill in this field.</li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['Errors']['lastname']['message'] != ''): ?>            
                    <li>Last name: Sorry! You need to fill in this field.</li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['Errors']['dob']['message'] != ''): ?>
                    <li>Date of birth: We need this date as dd/mm/yyyy. Thanks!</li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['Errors']['address']['message'] != ''): ?>
                    <li>Address line 1: Sorry! You need to fill in this field.</li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['Errors']['address2']['message'] != ''): ?>
                    <li>Address line 2: Sorry! You need to fill in this field.</li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['Errors']['town']['message'] != ''): ?>
                    <li>Town or City: Sorry! You need to fill in this field.</li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['Errors']['country']['message'] != ''): ?>
                    <li>Country: Sorry! You must be in the UK to register.</li>
                <?php endif; ?>                
                <?php if ($this->_tpl_vars['Errors']['postcode']['message'] != ''): ?>
                    <li>Postcode: Sorry! You need to fill in this field.</li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['Errors']['email']['message'] != ''): ?>
                    <li>Email: <?php echo $this->_tpl_vars['Errors']['email']['message']; ?>
</li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['Errors']['password']['message'] != ''): ?>
                    <li>Password: Just letters and numbers please. 6-20 characters long.</li>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['Errors']['cpassword']['message'] != ''): ?>
                    <li>Confirm password: Oops! Those passwords don't match.</li>
                <?php endif; ?>
            </ul></div> 
        <?php else: ?>
		<p class="required_text">*All fields are mandatory</p>
        <?php endif; ?>
	</div>
	</div>
    </div>  
    </form><!-- #adduser -->
</div>            

  