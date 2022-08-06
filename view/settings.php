<div class="wrap">
   <h2 class="wp-admin-change-title"><?php echo esc_html($this->plugin->displayName); ?> &raquo; <?php esc_html_e( 'Settings','admin-login-url-change'); ?> </h2>
  <?php
    if ( isset( $this->message ) ) {
  ?>
   <div class="updated fade">
      <p><?php echo esc_html($this->message); ?></p>
   </div>
  <?php
  }
  if ( isset( $this->errorMessage ) ) {
  ?>
  <div class="error fade"><p><?php echo esc_html($this->errorMessage); ?></p></div>
  <?php
  }
  ?>
   <?php
      $hfcm_form_action = admin_url('options-general.php?page=admin-login-url-change');
      
      ?>
   <div class="html_tag_replace_notes">
      <ul>
         <li><code><?php esc_html_e("No need to add your domain url. You just add your new login slug. Example: newadmin/adminlogin .... etc","admin-login-url-change"); ?></code></li>
         
      </ul>
   </div>
   <div class="wp-admin-change-box">
      <form method='post' action='<?php echo esc_html($hfcm_form_action); ?>'>
         <p>
            <label for="jh-new-login-url"><?php esc_html_e("Add New Login Slug","admin-login-url-change"); ?></label>
            <input type="text" name="jh_new_login_url" id="jh-new-login-url" placeholder="Example: newadmin/adminlogin .... etc" value="<?php if(!empty($this->admin_login_url_info['jh_new_login_url'])){ echo esc_html($this->admin_login_url_info['jh_new_login_url']); } ?>" <?php echo ( ! current_user_can( 'unfiltered_html' ) ) ? ' disabled="disabled" ' : ''; ?> />
         </p>
         
          <?php if ( current_user_can( 'unfiltered_html' ) ) { ?>
         <?php wp_nonce_field( $this->plugin->name, $this->plugin->name . '_nonce' ); ?>
         <p>
            <input type='submit' name='but_submit' value='<?php esc_attr_e("Submit","admin-login-url-change"); ?>'>
         </p>
        <?php } ?>
      </form>
   </div>
</div>
