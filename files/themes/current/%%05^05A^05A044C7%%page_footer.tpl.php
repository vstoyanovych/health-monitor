<?php /* Smarty version 2.6.26, created on 2024-09-15 04:38:54
         compiled from page_footer.tpl */ ?>
<?php if ($this->_tpl_vars['_settings']['footer_static_text'] != ""): ?><?php echo $this->_tpl_vars['_settings']['footer_static_text']; ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['_settings']['show_script_info'] == 'on'): ?><br><br>
<center>
<table width="80%" bgcolor="#ffffff">
	<tr>
		<td>
			<?php echo $this->_tpl_vars['lang']['special']['page_generation_time']; ?>
: <?php echo $this->_tpl_vars['special']['time']['generation_time']; ?>

		</td>
		<td>
			<?php echo $this->_tpl_vars['lang']['special']['executed_queries_count']; ?>
: <?php echo $this->_tpl_vars['special']['sql']['count']; ?>

		</td>
		<td>
			ID: <?php echo $this->_tpl_vars['special']['page']['viewid']; ?>

		</td>
	</tr>
</table>
</center>
<?php endif; ?>
<?php echo $this->_tpl_vars['special']['document']['bodyend']; ?>
</body>
</html>