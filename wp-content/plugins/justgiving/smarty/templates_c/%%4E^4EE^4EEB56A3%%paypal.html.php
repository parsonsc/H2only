<?php /* Smarty version 2.6.28, created on 2014-07-25 15:21:56
         compiled from paypal.html */ ?>
   <form action="" method="post">
        <input type="hidden" name="action" value="process" />
        <input type="hidden" name="cmd" value="_cart" />
        <input type="hidden" name="currency_code" value="GBP" />
        <input type="hidden" name="invoice" value="<?php echo $this->_tpl_vars['Invoice']['invoiceid']; ?>
" />
        <input type="hidden" name="product_quantity" value="1" />
        <input type="hidden" name="product_id" value="<?php echo $this->_tpl_vars['Invoice']['productid']; ?>
" />
        <input type="hidden" name="product_name" value="Membership fee" />
        <input type="hidden" name="product_quantity" value="1" />
        
        <input type="hidden" name="payer_email" value="<?php echo $this->_tpl_vars['User']['email']; ?>
" />
        <input type="hidden" name="payer_country" value="UK" />
        
        <input type="hidden" name="sandbox" value="1" />
 
        <div class="form-item">
            <label>Product Amount</label>
            <input type="number" step="any" name="product_amount" value="<?php echo $this->_tpl_vars['Settings']['payamount']; ?>
" disabled="disabled"/>
        </div>
        <div class="form-item">
            <label>Payer First Name</label>
            <input type="text" name="payer_fname" value="" />
        </div>
        <div class="form-item">
            <label>Payer Last Name</label>
            <input type="text" name="payer_lname" value="" />
        </div>
        <div class="form-item">
            <label>Payer Address</label>
            <input type="text" name="payer_address" value="" />
        </div>
        <div class="form-item">
            <label>Payer City</label>
            <input type="text" name="payer_city" value="" />
        </div>
        <div class="form-item">
            <label>Payer State</label>
            <input type="text" name="payer_state" value="" />
        </div>
        <div class="form-item">
            <label>Payer Postcode</label>
            <input type="text" name="payer_zip" value="" />
        </div>
        <div class="form-item">
            <input type="submit" name="submit" value="Submit" />
        </div>
    </form>