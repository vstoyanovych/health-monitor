<?php /* Smarty version 2.6.26, created on 2024-10-14 19:35:20
         compiled from editors_tinymce5_1_6.tpl */ ?>
<?php if ($this->_tpl_vars['noninit'] != '1'): ?>
<?php echo $this->_tpl_vars['special']['editor']['exthtml']; ?>

<script type="text/javascript" src="ext/editors/<?php echo $this->_tpl_vars['_settings']['ext_editor']; ?>
/tinymce.min.js"></script>
<?php endif; ?>

<?php if ($this->_tpl_vars['editor_doing'] == 'common'): ?>
<textarea name="<?php echo $this->_tpl_vars['var']; ?>
" id="<?php echo $this->_tpl_vars['var']; ?>
" class="tinymce5_1_6" style="<?php if ($this->_tpl_vars['style'] == ""): ?>width: 98%; height:400px;<?php else: ?><?php echo $this->_tpl_vars['style']; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['value']; ?>
</textarea>
<script type="text/javascript">
	tinymce.init({selector: '.tinymce5_1_6'<?php if ($this->_tpl_vars['_settings']['tinymce5_1_6_customization'] != ""): ?><?php echo $this->_tpl_vars['_settings']['tinymce5_1_6_customization']; ?>
<?php else: ?><?php echo $this->_tpl_vars['sm']['tinymce5_1_6_default_params']; ?>
<?php endif; ?>});
</script>
<?php endif; ?>

<?php if ($this->_tpl_vars['editor_doing'] == 'editor'): ?>
	<textarea name="<?php echo $this->_tpl_vars['var']; ?>
" id="<?php echo $this->_tpl_vars['var']; ?>
" class="tinymce5_1_6" style="<?php if ($this->_tpl_vars['style'] == ""): ?>width: 98%; height:400px;<?php else: ?><?php echo $this->_tpl_vars['style']; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['value']; ?>
</textarea>

	<script type="text/javascript">
		tinymce.init({selector: '.tinymce5_1_6'<?php if ($this->_tpl_vars['_settings']['tinymce5_1_6_customization'] != ""): ?><?php echo $this->_tpl_vars['_settings']['tinymce5_1_6_customization']; ?>
<?php else: ?><?php echo $this->_tpl_vars['sm']['tinymce5_1_6_default_params']; ?>
<?php endif; ?>});
	</script>

<?php endif; ?>