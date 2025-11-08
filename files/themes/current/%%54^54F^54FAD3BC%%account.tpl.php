<?php /* Smarty version 2.6.26, created on 2025-11-07 20:32:49
         compiled from account.tpl */ ?>
<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'show' || $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'wronglogin'): ?>
    <?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['panel'] == 'center'): ?>
        

    <div class="container-center">
        <div class="view-header view-choose-account-block"  style="<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'wronglogin'): ?>display:none<?php endif; ?>">
            <div class="header-title registration-headline">
                <span><?php echo $this->_tpl_vars['_settings']['logo_text']; ?>
</span>
                <p>Confirm it's you</p>
            </div>
        </div>


        <div class="panel panel-filled view-login-block">
            <div class="panel-body">

            <?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'show' || $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'wronglogin'): ?>
                <?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'wronglogin'): ?><div align="center" style="color:#ff0000;"><?php echo $this->_tpl_vars['lang']['message_wrong_login']; ?>
</div><?php endif; ?>

                <form action="index.php?m=account&d=login" id="loginForm" method="post" class="login-form" role="form" novalidate="novalidate">
                    <button type="submit" class="bv-hidden-submit" style="display: none; width: 0px; height: 0px;"></button>
                    <div class="form-group has-feedback">
                        <label class="control-label" for="inputEmail"><?php if ($this->_tpl_vars['_settings']['use_email_as_login'] != '1'): ?><?php echo $this->_tpl_vars['lang']['login_str']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lang']['common']['email']; ?>
<?php endif; ?></label>
                        <input type="email" name="login_d" placeholder="<?php if ($this->_tpl_vars['_settings']['use_email_as_login'] != '1'): ?><?php echo $this->_tpl_vars['lang']['login_str']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lang']['common']['email']; ?>
<?php endif; ?>" id="login_d" class="form-control" data-bv-field="email"><i style="display: none;" class="form-control-feedback" data-bv-icon-for="email"></i>
                    </div>


                    <div class="form-group has-feedback">
                        <label class="control-label" for="inputPassword"><?php echo $this->_tpl_vars['lang']['password']; ?>
</label>
                        <input type="password" name="passwd_d" placeholder="<?php echo $this->_tpl_vars['lang']['password']; ?>
" id="inputPassword" class="form-control" autocomplete="off" data-bv-field="password"><i style="display: none;" class="form-control-feedback" data-bv-icon-for="password"></i>
                    </div>
                    <div class="form-group">
                        <div class="flex w-100">
                            <div class="checkbox flex-1">
                                <label>
                                    <input type="checkbox" name="autologin_d" value="1"> <?php echo $this->_tpl_vars['lang']['common']['auto_login']; ?>

                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div>
                            <button class="btn btn-accent" type="submit"><?php echo $this->_tpl_vars['lang']['login']; ?>
</button>
                            <a href="index.php?m=googlelogin" class="google-login-button pull-right">
                                <div>
                                    <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" class="google-logo">
                                    <span class="button-text">Sign in with Google</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </form>
                <?php if ($this->_tpl_vars['_settings']['allow_register'] == '1' || $this->_tpl_vars['userinfo']['id'] != ""): ?>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="change-section">
                                <h3 class="heading">Not Registered?</h3>
                                <a class="btn btn-default btn-block" href="index.php?m=account&d=register"><?php echo $this->_tpl_vars['lang']['register']; ?>
</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

        <?php endif; ?>
    <?php else: ?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_begin.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php if ($this->_tpl_vars['userinfo']['id'] == ""): ?>
            <form action="index.php?m=account&d=login" method="POST" class="loginForm">

                <table width="100%" cellspacing="0">
                    <tr>
                        <td>
                            <?php if ($this->_tpl_vars['_settings']['use_email_as_login'] != '1'): ?><?php echo $this->_tpl_vars['lang']['login_str']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lang']['common']['email']; ?>
<?php endif; ?>:
                        </td>
                        <td><input name="login_d" type="text" size="10" style="width:100%;"></td>
                    </tr>
                    <tr>
                        <td><?php echo $this->_tpl_vars['lang']['password']; ?>
:</td>
                        <td><input type="password" name="passwd_d" size="10" style="width:100%;"></td>
                    <tr>
                        <td colspan="2">
                            <input type="checkbox" name="autologin_d" value="1"> <?php echo $this->_tpl_vars['lang']['common']['auto_login']; ?>

                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <?php if ($this->_tpl_vars['_settings']['allow_register'] == '1' || $this->_tpl_vars['userinfo']['id'] != ""): ?>
                                <div align="center"><a href="index.php?m=account&d=register"><?php echo $this->_tpl_vars['lang']['register']; ?>
</a></div>
                            <?php endif; ?>
                        </td>
                        <td align="center"><input class="loginbutton" type="submit" value="<?php echo $this->_tpl_vars['lang']['login']; ?>
"></td>
                    </tr>
                </table>
                <input type="hidden" name="p_goto_url" value="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['goto_url']; ?>
">
            </form>
        <?php else: ?>
            <strong><?php echo $this->_tpl_vars['userinfo']['login']; ?>
</strong>
            <br />
            <?php if ($this->_tpl_vars['_settings']['allow_private_messages'] == '1'): ?>
                <a href="index.php?m=account&d=viewprivmsg&folder=inbox"><?php echo $this->_tpl_vars['lang']['module_account']['inbox']; ?>
</a><br />
            <?php endif; ?>
            <?php if ($this->_tpl_vars['userinfo']['level'] == 3): ?>
                <a href="index.php?m=admin"><?php echo $this->_tpl_vars['lang']['control_panel']; ?>
</a><br />
            <?php endif; ?>
            <a href="index.php?m=account&d=cabinet"><?php echo $this->_tpl_vars['lang']['my_cabinet']; ?>
</a><br />
            <a href="index.php?m=account&d=logout"><?php echo $this->_tpl_vars['lang']['logout']; ?>
</a>
        <?php endif; ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_end.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
<?php endif; ?>



<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "account_additional.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "account_adminpart.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>