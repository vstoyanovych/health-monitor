<?php /* Smarty version 2.6.26, created on 2025-11-07 20:35:59
         compiled from newsfeed_filters.tpl */ ?>
<div class="dropdown dropdown-select-styled">
    <a data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="javascript:;">
        <?php if ($this->_tpl_vars['data']['active_tab'] != ""): ?><?php echo $this->_tpl_vars['data']['active_tab']; ?>
<?php else: ?>All<?php endif; ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683416 -0.097631 1.31658 -0.097631 1.7071 0.292893L4.99999 3.58579L8.29288 0.292893C8.6834 -0.0976311 9.31657 -0.0976311 9.70709 0.292893C10.0976 0.683417 10.0976 1.31658 9.70709 1.70711L5.7071 5.70711C5.31657 6.09763 4.68341 6.09763 4.29289 5.70711L0.292893 1.70711C-0.0976309 1.31658 -0.0976309 0.683417 0.292893 0.292893Z" fill="#374151"/>
        </svg>
    </a>
    <ul class="dropdown-menu min-w-max absolute text-sm text-slate-700 dark:text-white bg-white dark:bg-slate-700 shadow z-[2] float-left overflow list-none text-left rounded-lg mt-2 left-0 m-0 bg-clip-padding border-none">
        <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['data']['options']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <li <?php if ($this->_tpl_vars['data']['options'][$this->_sections['i']['index']]['selected']): ?> class="active"<?php endif; ?>>
                <a href="<?php echo $this->_tpl_vars['data']['options'][$this->_sections['i']['index']]['url']; ?>
" title="<?php echo $this->_tpl_vars['data']['options'][$this->_sections['i']['index']]['title']; ?>
">
                    <?php echo $this->_tpl_vars['data']['options'][$this->_sections['i']['index']]['title']; ?>

                </a>
            </li>
        <?php endfor; endif; ?>
    </ul>
</div>