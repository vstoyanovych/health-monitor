{if $m.mode eq 'editmenu'}
{include file="block_begin.tpl"}
<form action="index.php?m=menu&d=postedit&mid={$m.id}" method="post" enctype="multipart/form-data">
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
    <td width="50%">{$lang.caption}</td>
    <td width="50%"><input type="text" name="p_caption" size="30" value="{$m.caption}"></td>
</tr>
{if $_settings.menus_use_image eq "1"}
<tr>
    <td width="50%">{$lang.common.image}</td>
    <td width="50%">{include file="upload_image.tpl" no_use_foto_lang="1"}</td>
</tr>
{/if}
{$m.formadditionalhtml}
<tr>
    <td colspan="2" align="center"><input type="submit" value="{$lang.submit}"></td>
</tr>
</table>
</form>
<p align="right"><a href="http://{$_settings.help_resource}/index.php?m=help&q=admin_menu_addeditmenu&lang={$_settings.default_language}" target="_blank">[? {$lang.help}]</a></p>
{include file="block_end.tpl"}
{/if}


{if $m.mode eq 'addline'}
{include file="block_begin.tpl"}
<form name="post" action="index.php?m=menu&d=prepareaddline" method="post">
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
    <td width="33%">{$lang.caption}</td>
    <td width="33%">{$lang.url}</td>
    <td width="34%">{$lang.module_menu.add_to_menu}</td>
</tr>
<tr>
    <td><input type="text" name="p_caption" id="caption" size="20" style="width: 100%;"></td>
    <td>
	  <input type="text" name="p_url" size="20" style="width: 100%;">
	</td>
    <td>
	<select name="p_mainmenu" style="width: 100%;">
	 <option value="{$m.idmenu}|0" SELECTED>[{$lang.module_menu.menu_root}]</option>
	 {section name=i loop=$m.menu}
	 <option value="{$m.menu[i].add_param}">{section name=j loop=$m.menu[i].level} - {/section}{$m.menu[i].caption}</option>
	 {/section}
	</select>
	</td>
</tr>
{$m.formadditionalhtml}
<tr>
    <td colspan="2" align="center"><input type="submit" value="{$lang.submit}"></td>
</tr>
</table>
</form>
<p align="right"><a href="http://{$_settings.help_resource}/index.php?m=help&q=admin_menu_addeditmenuline&lang={$_settings.default_language}" target="_blank">[? {$lang.help}]</a></p>
{include file="block_end.tpl"}
{/if}

{if $m.mode eq 'prepareaddline'}
{include file="block_begin.tpl"}
<form name="post" action="{$m.menuline.form_url}" method="post" enctype="multipart/form-data">
<input type="hidden" name="p_caption" value="{$m.menuline.caption}">
<input type="hidden" name="p_url" value="{$m.menuline.url}">
<input type="hidden" name="p_sub" value="{$m.menuline.sub_id}">
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
    <td width="50%">{$lang.caption}</td>
    <td>{$m.menuline.caption}</td>
</tr>
<tr>
    <td width="50%">{$lang.url}</td>
    <td>{$m.menuline.url}</td>
</tr>
<tr>
    <td width="50%">{$lang.common.alt_text}</td>
    <td><input type="text" name="p_alt" id="alt" value="" /></td>
</tr>
<tr>
    <td width="50%">{$lang.module_menu.open_in_new_page}</td>
    <td><input type="checkbox" name="p_newpage" value="1" /></td>
</tr>
<tr>
    <td width="50%">{$lang.module_menu.position}</td>
    <td>
		<select name="p_position">
		 {section name=i loop=$m.menu}
		 <option value="{$m.menu[i].pos}">{$lang.before} "{$m.menu[i].caption}"</option>
		 {/section}
		 <option value="0" SELECTED>{$lang.last}</option>
		</select>
	</td>
</tr>
{if $_settings.menuitems_use_image eq "1"}
<tr>
    <td width="50%">{$lang.common.image}</td>
    <td width="50%">{include file="upload_image.tpl" no_use_foto_lang="1"}</td>
</tr>
{/if}
{$m.formadditionalhtml}
<tr>
    <td colspan="2" align="center"><input type="submit" value="{$lang.submit}"></td>
</tr>
</table>
</form>
<p align="right"><a href="http://{$_settings.help_resource}/index.php?m=help&q=admin_menu_addeditmenuline&lang={$_settings.default_language}" target="_blank">[? {$lang.help}]</a></p>
{include file="block_end.tpl"}
{/if}


{if $m.mode eq 'editline'}
{include file="block_begin.tpl"}
<form name="post" action="index.php?m=menu&d=posteditline&mid={$m.idmenu}&lid={$m.idline}" method="post" enctype="multipart/form-data">
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
    <td width="50%">{$lang.caption}</td>
    <td><input type="text" name="p_caption" size="20" value="{$m.captionline}"></td>
</tr>
<tr>
    <td width="50%">{$lang.url}</td>
    <td>
	  <input type="text" name="p_url" size="20" value="{$m.urlline}">
	</td>
</tr>
<tr>
    <td width="50%">{$lang.common.alt_text}</td>
    <td><input type="text" name="p_alt" value="{$m.alt_ml}" /></td>
</tr>
<tr>
    <td width="50%">{$lang.module_menu.open_in_new_page}</td>
    <td><input type="checkbox" name="p_newpage" value="1"{if $m.newpage_ml eq 1} checked{/if} /></td>
</tr>
<tr>
    <td width="50%">{$lang.position}</td>
    <td>
	<select name="p_position">
	 <option value="" SELECTED>{$lang.do_not_change}</option>
	 {section name=i loop=$m.menu}
	 <option value="{$m.menu[i].pos}">{$lang.before} "{$m.menu[i].caption}"</option>
	 {/section}
	 <option value="-1">{$lang.last}</option>
	</select>
	</td>
</tr>
<tr>
    <td width="50%">{$lang.module_menu.tag_a_attr}</td>
    <td>
		<textarea name="attr_ml" style="width:100%;" cols="15" rows="2" wrap="off">{$m.attr_ml}</textarea>
	</td>
</tr>
{if $_settings.menuitems_use_image eq "1"}
<tr>
    <td width="50%">{$lang.common.image}</td>
    <td width="50%">{include file="upload_image.tpl" no_use_foto_lang="1"}</td>
</tr>
{/if}
<tr>
    <td colspan="2"><input type="checkbox" name="p_partial_select" value="1"{if $m.partial_select eq "1"} checked{/if}> {$lang.module_menu.select_on_partial_match}</td>
</tr>
{$m.formadditionalhtml}
<tr>
    <td colspan="2" align="center"><input type="submit" value="{$lang.submit}"></td>
</tr>
</table>
</form>
<p align="right"><a href="http://{$_settings.help_resource}/index.php?m=help&q=admin_menu_addeditmenuline&lang={$_settings.default_language}" target="_blank">[? {$lang.help}]</a></p>
{include file="block_end.tpl"}
{/if}
