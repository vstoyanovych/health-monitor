<?php /* Smarty version 2.6.26, created on 2024-09-15 04:47:45
         compiled from stats_header.tpl */ ?>
<?php $this->assign('m', $this->_tpl_vars['modules'][$this->_tpl_vars['index']]); ?>

<div class="profilesidebarright campaignsheader compaign-tabs-count">
    <ul class="nav nav-tabs child-li-tab">
        <li <?php if ($this->_tpl_vars['data']['current_action'] == 'ips'): ?> class="active"<?php endif; ?>><a href="index.php?m=ips">Visitors</a></li>
        <li <?php if ($this->_tpl_vars['data']['current_action'] == 'pages'): ?> class="active"<?php endif; ?>><a href="index.php?m=visitors">Pages</a></li>
        <li <?php if ($this->_tpl_vars['data']['current_action'] == 'channels'): ?> class="active"<?php endif; ?>><a href="index.php?m=visitors&d=channelstats">Channels</a></li>
        <li <?php if ($this->_tpl_vars['data']['current_action'] == 'playliststats'): ?> class="active"<?php endif; ?>><a href="index.php?m=visitors&d=playliststats">Playlists</a></li>
        <li <?php if ($this->_tpl_vars['data']['current_action'] == 'accountstats'): ?> class="active"<?php endif; ?>><a href="index.php?m=visitors&d=accountstats">Accounts</a></li>
    </ul>
</div>

<script>
    function  admintable_msgbox(question, url)
    {
        Confirm('Confirmation', question, 'Yes', 'Cancel',url);
        }
</script>