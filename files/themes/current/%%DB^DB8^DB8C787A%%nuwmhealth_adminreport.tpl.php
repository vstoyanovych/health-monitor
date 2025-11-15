<?php /* Smarty version 2.6.26, created on 2025-11-15 18:48:27
         compiled from nuwmhealth_adminreport.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'nuwmhealth_adminreport.tpl', 11, false),array('modifier', 'count', 'nuwmhealth_adminreport.tpl', 16, false),array('modifier', 'escape', 'nuwmhealth_adminreport.tpl', 34, false),)), $this); ?>


<div class="nuwmhealth-admin-report">
    <div class="nuwmhealth-admin-report-header">
        <div>
            <strong>Admin readiness report</strong>
            <span>Reflects current filters</span>
        </div>
        <?php if ($this->_tpl_vars['data']['overall']['total'] > 0): ?>
            <div class="overall-pill">
                Overall readiness: <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['overall']['ready_percent'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 1) : number_format($_tmp, 1)); ?>
%
            </div>
        <?php endif; ?>
    </div>

    <?php if (count($this->_tpl_vars['data']['report']) == 0): ?>
        <div class="text-muted">No pages match the applied filters.</div>
    <?php else: ?>
        <table class="table table-striped table-condensed nuwmhealth-admin-report-table">
            <thead>
                <tr>
                    <th>Admin</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Ready</th>
                    <th class="text-center">Missing</th>
                    <th class="text-center">Ready %</th>
                </tr>
            </thead>
            <tbody>
                <?php $_from = $this->_tpl_vars['data']['report']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                    <tr>
                        <td>
                            <?php if ($this->_tpl_vars['row']['admin_email'] != ''): ?>
                                <a href="mailto:<?php echo ((is_array($_tmp=$this->_tpl_vars['row']['admin_email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="admin-link"><?php echo ((is_array($_tmp=$this->_tpl_vars['row']['admin_label'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
                            <?php else: ?>
                                <?php echo ((is_array($_tmp=$this->_tpl_vars['row']['admin_label'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['row']['url_total'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo $this->_tpl_vars['row']['total']; ?>
</a>
                        </td>
                        <td class="text-center text-success">
                            <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['row']['url_ready'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo $this->_tpl_vars['row']['ready']; ?>
</a>
                        </td>
                        <td class="text-center text-danger">
                            <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['row']['url_missing'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo $this->_tpl_vars['row']['missing']; ?>
</a>
                        </td>
                        <td class="text-center">
                            <?php if ($this->_tpl_vars['row']['total'] > 0): ?>
                                <?php echo ((is_array($_tmp=$this->_tpl_vars['row']['ready_percent'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 1) : number_format($_tmp, 1)); ?>
%
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>
            </tbody>
            <tfoot>
                <tr class="overall-row">
                    <th>All admins</th>
                    <th class="text-center"><?php echo $this->_tpl_vars['data']['overall']['total']; ?>
</th>
                    <th class="text-center text-success"><?php echo $this->_tpl_vars['data']['overall']['ready']; ?>
</th>
                    <th class="text-center text-danger"><?php echo $this->_tpl_vars['data']['overall']['missing']; ?>
</th>
                    <th class="text-center">
                        <?php if ($this->_tpl_vars['data']['overall']['total'] > 0): ?>
                            <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['overall']['ready_percent'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 1) : number_format($_tmp, 1)); ?>
%
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </th>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>
</div>
