<?php /* Smarty version 2.6.26, created on 2024-09-15 04:38:54
         compiled from content_header.tpl */ ?>
<?php $this->assign('m', $this->_tpl_vars['modules'][$this->_tpl_vars['index']]); ?>

<div class="profilesidebarright campaignsheader compaign-tabs-count">
    <ul class="nav nav-tabs child-li-tab">
        <li <?php if ($this->_tpl_vars['data']['show'] == 'all'): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['data']['allUrl']; ?>
">All</a></li>
        <li <?php if ($this->_tpl_vars['data']['show'] == 'videos'): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['data']['videosUrl']; ?>
">Videos</a></li>
        <li <?php if ($this->_tpl_vars['data']['show'] == 'articles'): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['data']['articlesUrl']; ?>
">Articles</a></li>
    </ul>
</div>

<script>
    function  admintable_msgbox(question, url)
    {
        Confirm('Confirmation', question, 'Yes', 'Cancel',url);
        }
</script>