<?php /* Smarty version 2.6.26, created on 2025-08-03 23:08:24
         compiled from system_settings_tabs.tpl */ ?>
<?php $this->assign('m', $this->_tpl_vars['modules'][$this->_tpl_vars['index']]); ?>

<div class="profilesidebarright campaignsheader compaign-tabs-count">
    <ul class="nav nav-tabs child-li-tab">
        <li <?php if ($this->_tpl_vars['data']['current_action'] == 'logo'): ?> class="active"<?php endif; ?>><a href="index.php?m=settings&d=logo">Logo</a></li>
        <li <?php if ($this->_tpl_vars['data']['current_action'] == 'emailsettings'): ?> class="active"<?php endif; ?>><a href="index.php?m=settings&d=emailsettings">Email Settings</a></li>
        <li <?php if ($this->_tpl_vars['data']['current_action'] == 'grabbersettings'): ?> class="active"<?php endif; ?>><a href="index.php?m=settings&d=grabbersettings">Grabbers</a></li>
        <li <?php if ($this->_tpl_vars['data']['current_action'] == 'facebooksettings'): ?> class="active"<?php endif; ?>><a href="index.php?m=settings&d=facebooksettings">Facebook</a></li>
        <li <?php if ($this->_tpl_vars['data']['current_action'] == 'twittersettings'): ?> class="active"<?php endif; ?>><a href="index.php?m=settings&d=twittersettings">Twitter</a></li>
        <li <?php if ($this->_tpl_vars['data']['current_action'] == 'redditsettings'): ?> class="active"<?php endif; ?>><a href="index.php?m=settings&d=redditsettings">Reddit</a></li>
    </ul>
</div>

<script>
    function  admintable_msgbox(question, url)
    {
        Confirm('Confirmation', question, 'Yes', 'Cancel',url);
        }
</script>