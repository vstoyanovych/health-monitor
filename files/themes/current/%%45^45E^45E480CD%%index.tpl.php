<?php /* Smarty version 2.6.26, created on 2025-11-14 18:21:22
         compiled from index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "page_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<!-- Wrapper-->
<div class="wrapper flex align-items-start">
    <?php if ($this->_tpl_vars['userinfo']['level'] != 0): ?>
    <!-- Navigation-->
    <aside class="navigation">
        <nav>
            <div class="tog-button-left">
                <div class="flex align-items-center w-100">
                <a href="<?php if ($this->_tpl_vars['special']['page']['scheme'] != ""): ?><?php echo $this->_tpl_vars['special']['page']['scheme']; ?>
<?php else: ?>http<?php endif; ?>://<?php echo $this->_tpl_vars['special']['resource_url']; ?>
" class="navbar-brand"><?php echo $this->_tpl_vars['_settings']['logo_text']; ?>
</a>
                    <?php if ($this->_tpl_vars['sm']['g']['m'] == 'account' || $this->_tpl_vars['userinfo']['level'] > 0): ?>
                        <div id="navbar" class="navbar-collapse collapse flex-1">
                            <div class="left-nav-toggle">
                                <a href="javascript:;" class="toggle-hd">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="25" height="25">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                                    </svg>

                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex flex-column h-100-100">
                <ul class="nav luna-nav flex-1 w-100">
                    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['mainmenu']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                        <li <?php if ($this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['selected']): ?>class=" active"<?php endif; ?>>
                            <?php if ($this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['url'] != ""): ?>
                                <a href="<?php echo $this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['url']; ?>
"<?php if ($this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['target'] != ""): ?> target="<?php echo $this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['target']; ?>
"<?php endif; ?>>
                                    <div class="w-100">
                                        <span class="main-menu-icon <?php if ($this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['icon_class'] != ""): ?> fa-fas <?php echo $this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['icon_class']; ?>
<?php endif; ?>">
                                            <?php if ($this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['icon'] != ""): ?>
                                                <img src="<?php echo $this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['icon']; ?>
"/>
                                            <?php endif; ?>
                                        </span>
                                        <span class="flex">
                                            <span class="main-menu-text flex-1"><?php echo $this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['title']; ?>
</span>
                                            <?php if ($this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['count'] > 0): ?>
                                                <span class="items_count show-alert"><?php echo $this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['count']; ?>
</span>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                                                    </a>
                            <?php else: ?>
                                <span class="main-menu-label">
                                <?php echo $this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['title']; ?>

                            </span>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['has_subitems']): ?>
                                <ul class="secondary-nav active">
                                    <?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['items']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
                                        <li><a href="<?php echo $this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['items'][$this->_sections['j']['index']]['url']; ?>
"><?php echo $this->_tpl_vars['sm']['mainmenu'][$this->_sections['i']['index']]['items'][$this->_sections['j']['index']]['title']; ?>
</a></li>
                                    <?php endfor; endif; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endfor; endif; ?>
                </ul>
            </div>
        </nav>
    </aside>
    <!-- End navigation-->

    <?php endif; ?>
    <!-- Main content-->
    <section class="content" <?php if ($this->_tpl_vars['userinfo']['level'] == 0): ?>style="margin-left: 0px; margin-top:0px;"<?php endif; ?>>
        <?php if ($this->_tpl_vars['userinfo']['level'] != 0): ?>
        <!-- Header-->
        <nav class="navbar navbar-default">
                <div class="navbar-header">
                    <div id="mobile-menu">
                        <div class="toogle-button-wrapper">
                            <div class="left-nav-toggle-mobile" onclick="$('.navigation').removeClass('show-on-mobile');$('.tog-button-left .left-nav-toggle-mobile').remove();">
                                <a href="javascript:;">
                                    <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.4998 12.5V14.1667H1.49984V12.5H16.4998ZM4.4965 0.753357L5.67484 1.93169L3.02317 4.58336L5.67484 7.23502L4.4965 8.41336L0.666504 4.58336L4.4965 0.753357ZM16.4998 6.66669V8.33336H8.99984V6.66669H16.4998ZM16.4998 0.833357V2.50002H8.99984V0.833357H16.4998Z" fill="CurrentColor"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="flex-1">
                            <a href="<?php if ($this->_tpl_vars['special']['page']['scheme'] != ""): ?><?php echo $this->_tpl_vars['special']['page']['scheme']; ?>
<?php else: ?>http<?php endif; ?>://<?php echo $this->_tpl_vars['special']['resource_url']; ?>
" class="navbar-brand"><?php echo $this->_tpl_vars['_settings']['logo_text']; ?>
</a>
                        </div>
                        <div class="header-menu-section-mobile"></div>
                    </div>
                </div>
                <div class="flex header-wrapper">
                    <div id="section_header"></div>
                    <div class="flex-1"></div>

                    <ul class="nav luna-nav header-settings-section">

                        <li class="profil-link">
                            <a href="#" class="top dropdown-toggle adminmenu" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <div>
                                        <span class="main-menu-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="35px" height="35px"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                        </span>
                                </div>
                            </a>
                            <ul class="dropdown-menu adminmenu" aria-labelledby="dropdownMenu1">
                                <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['accountmenuactions']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                                    <li>
                                        <a href="<?php echo $this->_tpl_vars['sm']['accountmenuactions'][$this->_sections['i']['index']]['url']; ?>
" <?php if ($this->_tpl_vars['sm']['accountmenuactions'][$this->_sections['i']['index']]['selected']): ?> class="active"<?php endif; ?>>
                                            <?php echo $this->_tpl_vars['sm']['accountmenuactions'][$this->_sections['i']['index']]['icon']; ?>

                                            <span class="main-text"><?php echo $this->_tpl_vars['sm']['accountmenuactions'][$this->_sections['i']['index']]['title']; ?>
</span>
                                        </a>
                                    </li>
                                <?php endfor; endif; ?>
                                <li>
                                    <a href="index.php?m=account&d=logout">
                                        <span class="main-text">Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </div>

        </nav>
        <!-- End header-->
        <?php endif; ?>
        <div class="container-fluid">



            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "path.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


            <?php echo $this->_tpl_vars['special']['document']['panel'][0]['beforepanel']; ?>

            <?php $this->assign('loop_center_panel', 1); ?>
            <?php $this->assign('show_center_panel', 1); ?>
            <?php unset($this->_sections['mod_index']);
$this->_sections['mod_index']['name'] = 'mod_index';
$this->_sections['mod_index']['loop'] = is_array($_loop=$this->_tpl_vars['modules']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mod_index']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['mod_index']['start'] = (int)1;
$this->_sections['mod_index']['show'] = true;
$this->_sections['mod_index']['max'] = $this->_sections['mod_index']['loop'];
if ($this->_sections['mod_index']['start'] < 0)
    $this->_sections['mod_index']['start'] = max($this->_sections['mod_index']['step'] > 0 ? 0 : -1, $this->_sections['mod_index']['loop'] + $this->_sections['mod_index']['start']);
else
    $this->_sections['mod_index']['start'] = min($this->_sections['mod_index']['start'], $this->_sections['mod_index']['step'] > 0 ? $this->_sections['mod_index']['loop'] : $this->_sections['mod_index']['loop']-1);
if ($this->_sections['mod_index']['show']) {
    $this->_sections['mod_index']['total'] = min(ceil(($this->_sections['mod_index']['step'] > 0 ? $this->_sections['mod_index']['loop'] - $this->_sections['mod_index']['start'] : $this->_sections['mod_index']['start']+1)/abs($this->_sections['mod_index']['step'])), $this->_sections['mod_index']['max']);
    if ($this->_sections['mod_index']['total'] == 0)
        $this->_sections['mod_index']['show'] = false;
} else
    $this->_sections['mod_index']['total'] = 0;
if ($this->_sections['mod_index']['show']):

            for ($this->_sections['mod_index']['index'] = $this->_sections['mod_index']['start'], $this->_sections['mod_index']['iteration'] = 1;
                 $this->_sections['mod_index']['iteration'] <= $this->_sections['mod_index']['total'];
                 $this->_sections['mod_index']['index'] += $this->_sections['mod_index']['step'], $this->_sections['mod_index']['iteration']++):
$this->_sections['mod_index']['rownum'] = $this->_sections['mod_index']['iteration'];
$this->_sections['mod_index']['index_prev'] = $this->_sections['mod_index']['index'] - $this->_sections['mod_index']['step'];
$this->_sections['mod_index']['index_next'] = $this->_sections['mod_index']['index'] + $this->_sections['mod_index']['step'];
$this->_sections['mod_index']['first']      = ($this->_sections['mod_index']['iteration'] == 1);
$this->_sections['mod_index']['last']       = ($this->_sections['mod_index']['iteration'] == $this->_sections['mod_index']['total']);
?>
                <?php if ($this->_tpl_vars['_settings']['main_block_position'] < $this->_tpl_vars['loop_center_panel'] && $this->_tpl_vars['show_center_panel'] == 1): ?>
                    <?php $this->assign('show_center_panel', 0); ?>
                    <?php $this->assign('index', 0); ?>
                    <?php $this->assign('mod_name', $this->_tpl_vars['modules'][0]['module']); ?>
                    <?php echo $this->_tpl_vars['special']['document']['block'][0]['beforeblock']; ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod_name']).".tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php echo $this->_tpl_vars['special']['document']['block'][0]['afterblock']; ?>

                <?php endif; ?>
                <?php if ($this->_tpl_vars['modules'][$this->_sections['mod_index']['index']]['panel'] == 'center'): ?>
                    <?php $this->assign('index', $this->_sections['mod_index']['index']); ?>
                    <?php $this->assign('mod_name', $this->_tpl_vars['modules'][$this->_sections['mod_index']['index']]['module']); ?>
                    <?php echo $this->_tpl_vars['special']['document']['block'][$this->_sections['mod_index']['index']]['beforeblock']; ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod_name']).".tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php echo $this->_tpl_vars['special']['document']['block'][$this->_sections['mod_index']['index']]['afterblock']; ?>

                    <?php $this->assign('loop_center_panel', $this->_tpl_vars['loop_center_panel']+1); ?>
                <?php endif; ?>
            <?php endfor; endif; ?>
            <?php if ($this->_tpl_vars['show_center_panel'] == 1): ?>
                <?php $this->assign('show_center_panel', 0); ?>
                <?php $this->assign('index', 0); ?>
                <?php $this->assign('mod_name', $this->_tpl_vars['modules'][0]['module']); ?>
                <?php echo $this->_tpl_vars['special']['document']['block'][0]['beforeblock']; ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod_name']).".tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php echo $this->_tpl_vars['special']['document']['block'][0]['afterblock']; ?>

            <?php endif; ?>
            <?php echo $this->_tpl_vars['special']['document']['panel'][0]['afterpanel']; ?>



            <?php echo $this->_tpl_vars['special']['document']['panel'][1]['beforepanel']; ?>

            <?php unset($this->_sections['mod_index']);
$this->_sections['mod_index']['name'] = 'mod_index';
$this->_sections['mod_index']['loop'] = is_array($_loop=$this->_tpl_vars['modules']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mod_index']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['mod_index']['show'] = true;
$this->_sections['mod_index']['max'] = $this->_sections['mod_index']['loop'];
$this->_sections['mod_index']['start'] = $this->_sections['mod_index']['step'] > 0 ? 0 : $this->_sections['mod_index']['loop']-1;
if ($this->_sections['mod_index']['show']) {
    $this->_sections['mod_index']['total'] = min(ceil(($this->_sections['mod_index']['step'] > 0 ? $this->_sections['mod_index']['loop'] - $this->_sections['mod_index']['start'] : $this->_sections['mod_index']['start']+1)/abs($this->_sections['mod_index']['step'])), $this->_sections['mod_index']['max']);
    if ($this->_sections['mod_index']['total'] == 0)
        $this->_sections['mod_index']['show'] = false;
} else
    $this->_sections['mod_index']['total'] = 0;
if ($this->_sections['mod_index']['show']):

            for ($this->_sections['mod_index']['index'] = $this->_sections['mod_index']['start'], $this->_sections['mod_index']['iteration'] = 1;
                 $this->_sections['mod_index']['iteration'] <= $this->_sections['mod_index']['total'];
                 $this->_sections['mod_index']['index'] += $this->_sections['mod_index']['step'], $this->_sections['mod_index']['iteration']++):
$this->_sections['mod_index']['rownum'] = $this->_sections['mod_index']['iteration'];
$this->_sections['mod_index']['index_prev'] = $this->_sections['mod_index']['index'] - $this->_sections['mod_index']['step'];
$this->_sections['mod_index']['index_next'] = $this->_sections['mod_index']['index'] + $this->_sections['mod_index']['step'];
$this->_sections['mod_index']['first']      = ($this->_sections['mod_index']['iteration'] == 1);
$this->_sections['mod_index']['last']       = ($this->_sections['mod_index']['iteration'] == $this->_sections['mod_index']['total']);
?>
                <?php if ($this->_tpl_vars['modules'][$this->_sections['mod_index']['index']]['panel'] == '1'): ?>
                    <?php $this->assign('index', $this->_sections['mod_index']['index']); ?>
                    <?php $this->assign('mod_name', $this->_tpl_vars['modules'][$this->_sections['mod_index']['index']]['module']); ?>
                    <?php echo $this->_tpl_vars['special']['document']['block'][$this->_sections['mod_index']['index']]['beforeblock']; ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod_name']).".tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php echo $this->_tpl_vars['special']['document']['block'][$this->_sections['mod_index']['index']]['afterblock']; ?>

                <?php endif; ?>
            <?php endfor; endif; ?>
            <?php echo $this->_tpl_vars['special']['document']['panel'][1]['afterpanel']; ?>



            <?php echo $this->_tpl_vars['special']['document']['panel'][2]['beforepanel']; ?>

            <?php unset($this->_sections['mod_index']);
$this->_sections['mod_index']['name'] = 'mod_index';
$this->_sections['mod_index']['loop'] = is_array($_loop=$this->_tpl_vars['modules']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mod_index']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['mod_index']['show'] = true;
$this->_sections['mod_index']['max'] = $this->_sections['mod_index']['loop'];
$this->_sections['mod_index']['start'] = $this->_sections['mod_index']['step'] > 0 ? 0 : $this->_sections['mod_index']['loop']-1;
if ($this->_sections['mod_index']['show']) {
    $this->_sections['mod_index']['total'] = min(ceil(($this->_sections['mod_index']['step'] > 0 ? $this->_sections['mod_index']['loop'] - $this->_sections['mod_index']['start'] : $this->_sections['mod_index']['start']+1)/abs($this->_sections['mod_index']['step'])), $this->_sections['mod_index']['max']);
    if ($this->_sections['mod_index']['total'] == 0)
        $this->_sections['mod_index']['show'] = false;
} else
    $this->_sections['mod_index']['total'] = 0;
if ($this->_sections['mod_index']['show']):

            for ($this->_sections['mod_index']['index'] = $this->_sections['mod_index']['start'], $this->_sections['mod_index']['iteration'] = 1;
                 $this->_sections['mod_index']['iteration'] <= $this->_sections['mod_index']['total'];
                 $this->_sections['mod_index']['index'] += $this->_sections['mod_index']['step'], $this->_sections['mod_index']['iteration']++):
$this->_sections['mod_index']['rownum'] = $this->_sections['mod_index']['iteration'];
$this->_sections['mod_index']['index_prev'] = $this->_sections['mod_index']['index'] - $this->_sections['mod_index']['step'];
$this->_sections['mod_index']['index_next'] = $this->_sections['mod_index']['index'] + $this->_sections['mod_index']['step'];
$this->_sections['mod_index']['first']      = ($this->_sections['mod_index']['iteration'] == 1);
$this->_sections['mod_index']['last']       = ($this->_sections['mod_index']['iteration'] == $this->_sections['mod_index']['total']);
?>
                <?php if ($this->_tpl_vars['modules'][$this->_sections['mod_index']['index']]['panel'] == '2'): ?>
                    <?php $this->assign('index', $this->_sections['mod_index']['index']); ?>
                    <?php $this->assign('mod_name', $this->_tpl_vars['modules'][$this->_sections['mod_index']['index']]['module']); ?>
                    <?php echo $this->_tpl_vars['special']['document']['block'][$this->_sections['mod_index']['index']]['beforeblock']; ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['mod_name']).".tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php echo $this->_tpl_vars['special']['document']['block'][$this->_sections['mod_index']['index']]['afterblock']; ?>

                <?php endif; ?>
            <?php endfor; endif; ?>
            <?php echo $this->_tpl_vars['special']['document']['panel'][2]['afterpanel']; ?>


        </div>
    </section>
    <!-- End main content-->

</div>
<!-- End wrapper-->

<div id="tinymce_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="close-modal">
                <a href="javascript:;" onclick="closetinymcemodal()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></a>
            </div>
            <div class="tinymce_modal_content">
            </div>
        </div>
    </div>
</div>


<div id="openai_assistant_history_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="close-modal">
                <a href="javascript:;" onclick="closeopenaihistorymodal()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></a>
            </div>
            <div class="openai_assistant_history_modal_content">
            </div>
        </div>
    </div>
</div>

<div id="openai_assistant_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="close-modal">
                <a href="javascript:;" onclick="closeopenaimodal()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></a>
            </div>
            <div class="openai_assistant_modal_content">
            </div>
        </div>
    </div>
</div>

<!-- Vendor scripts -->

<script src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/vendor/toastr/toastr.min.js"></script>
<script src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/vendor/sparkline/index.js"></script>
<script src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/vendor/flot/jquery.flot.min.js"></script>
<script src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/vendor/flot/jquery.flot.resize.min.js"></script>
<script src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/vendor/flot/jquery.flot.spline.js"></script>
<script type="text/javascript" src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/assets/js/required/jquery-ui-1.11.0.custom/jquery-ui.min.js"></script>

<script src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/vendor/niceselect/jquery.nice-select.js"></script>

<script>
    $(document).ready(function() {
        
    });
</script>


<!-- App scripts -->
<script src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/scripts/luna.js"></script>
<script src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/scripts/selectize.js"></script>

<script>
    $(document).ready(function() {
        $('#tag_filter').niceSelect('destroy');
        $('#js-tags-selector').niceSelect('destroy');
        $('#js-tags-selector').selectize({
            plugins: ['remove_button'],
            create: true
        });
    });
</script>

<script>
    function alertSuccessMessage(message) {
        alertify.success(message);
    }

    $(function() {
        headermenu = $('.header-wrapper').html();
        togglebutton = $('.toogle-button-wrapper').html();
        $('.header-menu-section-mobile').html(headermenu);
        $('.header-menu-section-mobile #navbar').remove();
        $('.header-menu-section-mobile .account-limits-section').remove();
        $('.left-nav-toggle-mobile').click(function() {
            $('.navigation').addClass('show-on-mobile');
            $('.tog-button-left').append(togglebutton);
        });
    });
</script>

<?php if ($this->_tpl_vars['userinfo']['level'] != 0): ?>
<script type="text/javascript" src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/aiassistant.js"></script>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "page_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>