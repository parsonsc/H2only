<?php /* Smarty version 2.6.28, created on 2015-02-26 15:57:12
         compiled from login-page.html */ ?>
<div class="logIn-box"> 
    <h3>Already got a JustGiving Account?<br />Sweet! Log in here.</h3>
	<form action="<?php echo $this->_tpl_vars['formurl']; ?>
" method="post" class="user-forms" id="login_form" name="loginForm">
	<div class="container login water-bg water-line-top">
		<div class="col-xs-* col-xs-12">
            <div class="form-item input-row">
                <label for="user-name">Email address*</label>
                <input type="email" name="user-name" id="user-name" class="input-text" value="<?php echo $this->_tpl_vars['userName']; ?>
"  validate="required:true" />                
            </div>
            <div class="form-item input-row">
                <label for="password">Password*</label>
                <input type="password" name="password" id="password" class="input-text"  validate="required:true" />                
            </div>        
        </div>
        <div class="container login">
            <div class="row">
                <div class="col-xs-* col-xs-12 fieldset-submit water-line-bottom"> 
                    <div class="form-item input-row centered">        
                        <button title="Login" class="button submit siteCTA" type="submit">Login</button>
                        <input type="hidden" name="action" value="log-in" />
                        <input type="hidden" name="button" value="<?php echo $this->_tpl_vars['submit']; ?>
" />
                        <input type="hidden" name="formName" value="login" />
                        <?php echo $this->_tpl_vars['nonce']; ?>

                    </div>
                </div>
            </div>
        </div>                <?php if ($this->_tpl_vars['passworderror'] != '' || $this->_tpl_vars['usernameerror'] != ''): ?>                <p class="required_text error-text">Some fields are invalid</p>                <?php endif; ?>        
        <?php if ($this->_tpl_vars['forgotURL'] != ''): ?>
        <div class="forgot-pwd"><a href="<?php echo $this->_tpl_vars['forgotURL']; ?>
">Oops! I forgot my password</a></div>
        <?php endif; ?>
        
        <?php if ($this->_tpl_vars['chooseURL'] != ''): ?>

        <div class="choose-account"><a href="<?php echo $this->_tpl_vars['chooseURL']; ?>
">go back</a></div>

        <?php endif; ?>        
    </div>    
	</form>
</div> 