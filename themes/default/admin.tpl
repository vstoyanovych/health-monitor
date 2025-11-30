{if $m.mode eq 'settings'}
{include file="block_begin.tpl"}
{$lang.common.profile}: 
	{if $m.mode_settings neq "default"}<a href="index.php?m=admin&d=settings">{else}<b>{/if}{$lang.common.general}{if $m.mode_settings neq "default"}</a>{else}</b>{/if}
	{section name=tmpextctrls loop=$m.list_modes}
		  | 
		{if $m.mode_settings neq $m.list_modes[tmpextctrls].mode}<a href="index.php?m=admin&d=settings&viewmode={$m.list_modes[tmpextctrls].mode}">{else}<b>{/if}{$m.list_modes[tmpextctrls].profile}{if $m.mode_settings neq $m.list_modes[tmpextctrls].mode}</a>{else}</b>{/if}
	{/section}
<br /><br />
<form action="index.php?m=admin&d=postsettings&viewmode={$m.mode_settings}" method="post">
<table width="100%" border="0">
<tr>
	<td colspan="4" class="admin-settings-separator">{$lang.common_settings}</td>
</tr>
	{if $m.show_settings.resource_title eq 1}
		<tr>
		    <td width="50%">{$lang.settings_resource_title}:</td>
			<td><input type="text" name="p_title" value="{$m.edit_settings.resource_title|htmlescape}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='resource_title'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_resource_title&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.resource_url eq 1}
		<tr>
			<td>{$lang.settings_resource_url}:</td>
			<td>http://<input type="text" name="p_url" value="{$m.edit_settings.resource_url}"></td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_resource_url&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.resource_url_mobile eq 1}
		<tr>
			<td>{$lang.settings_resource_url_mobile}:</td>
			<td>http://<input type="text" name="resource_url_mobile" value="{$m.edit_settings.resource_url_mobile}"></td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_resource_url_mobile&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.resource_url_tablet eq 1}
		<tr>
			<td>{$lang.settings_resource_url_tablet}:</td>
			<td>http://<input type="text" name="resource_url_tablet" value="{$m.edit_settings.resource_url_tablet}"></td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=resource_url_tablet&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.resource_url_rewrite eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="resource_url_rewrite" value="1" {if $m.edit_settings.resource_url_rewrite eq "1"}checked{/if}> {$lang.settings_resource_url_rewrite}</td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=resource_url_rewrite&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.logo_text eq 1}
		<tr>
			<td>{$lang.settings_logo_text}:</td>
			<td><input type="text" name="p_logo" value="{$m.edit_settings.logo_text|htmlescape}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='logo_text'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_logo_text&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.copyright_text eq 1}
		<tr>
			<td>{$lang.settings_copyright_text}:</td>
			<td><input type="text" name="p_copyright" value="{$m.edit_settings.copyright_text|htmlescape}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='copyright_text'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_copyright_text&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.meta_keywords eq 1}
		<tr>
			<td>{$lang.settings_meta_keywords}:</td>
			<td><input type="text" name="p_keywords" value="{$m.edit_settings.meta_keywords|htmlescape}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='meta_keywords'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_meta_keywords&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.meta_description eq 1}
		<tr>
			<td>{$lang.settings_meta_description}:</td>
			<td><input type="text" name="p_description" value="{$m.edit_settings.meta_description|htmlescape}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='meta_description'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_meta_description&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.default_language eq 1}
		<tr>
			<td>{$lang.settings_default_language}: </td>
			<td><select name="p_lang" size="1">
			  {section name=i loop=$m.lang}
			  <option value="{$m.lang[i]}"{if $m.lang[i] eq $m.edit_settings.default_language} SELECTED{/if}>{$m.lang[i]}</option>
			  {/section}
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='default_language'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_default_language&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.default_theme eq 1}
		<tr>
			<td>{$lang.settings_default_theme}:</td>
			<td><select name="p_theme" size="1">
			  {section name=i loop=$m.themes}
			  <option value="{$m.themes[i]}"{if $m.themes[i] eq $m.edit_settings.default_theme} SELECTED{/if}>{$m.themes[i]}</option>
			  {/section}
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='default_theme'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_default_theme&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.sidepanel_count eq 1}
		<tr>
			<td>{$lang.settings_sidepanel_count}:</td>
			<td><select name="p_sidepanel_count" size="1">
			  {section name=i loop=16 start=1}
			  <option value="{$smarty.section.i.index}"{if $smarty.section.i.index eq $m.edit_settings.sidepanel_count} SELECTED{/if}>{$smarty.section.i.index}</option>
			  {/section}
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='sidepanel_count'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_sidepanel_count&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.default_module eq 1}
		<tr>
			<td>{$lang.settings_default_module}:</td>
			<td><select name="p_module" size="1">
			  {section name=i loop=$m.modules}
			  <option value="{$m.modules[i].name}"{if $m.modules[i].name eq $m.edit_settings.default_module} SELECTED{/if}>{$m.modules[i].title}</option>
			  {/section}
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='default_module'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_default_module&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.cookprefix eq 1}
		<tr>
			<td>{$lang.settings_cookprefix}:</td>
			<td><input type="text" name="p_cook" value="{$m.edit_settings.cookprefix}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='cookprefix'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_cookprefix&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.max_upload_filesize eq 1}
		<tr>
			<td>{$lang.settings_max_upload_filesize}:</td>
			<td><input type="text" name="p_maxfsize" value="{$m.edit_settings.max_upload_filesize}"> ({$lang.bytes})</td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='max_upload_filesize'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_max_upload_filesize&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.admin_items_by_page eq 1}
		<tr>
			<td>{$lang.settings_admin_items_by_page}:</td>
			<td><select name="p_adminitems_per_page" size="1">
			  <option value="5"{if $m.edit_settings.admin_items_by_page eq 5} SELECTED{/if}>5</option>
			  <option value="10"{if $m.edit_settings.admin_items_by_page eq 10} SELECTED{/if}>10</option>
			  <option value="15"{if $m.edit_settings.admin_items_by_page eq 15} SELECTED{/if}>15</option>
			  <option value="20"{if $m.edit_settings.admin_items_by_page eq 20} SELECTED{/if}>20</option>
			  <option value="30"{if $m.edit_settings.admin_items_by_page eq 30} SELECTED{/if}>30</option>
			  <option value="40"{if $m.edit_settings.admin_items_by_page eq 40} SELECTED{/if}>40</option>
			  <option value="50"{if $m.edit_settings.admin_items_by_page eq 50} SELECTED{/if}>50</option>
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='admin_items_by_page'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_admin_items_by_page&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.search_items_by_page eq 1}
		<tr>
			<td>{$lang.settings_search_items_by_page}:</td>
			<td><select name="p_searchitems_per_page" size="1">
			  <option value="5"{if $m.edit_settings.search_items_by_page eq 5} SELECTED{/if}>5</option>
			  <option value="10"{if $m.edit_settings.search_items_by_page eq 10} SELECTED{/if}>10</option>
			  <option value="15"{if $m.edit_settings.search_items_by_page eq 15} SELECTED{/if}>15</option>
			  <option value="20"{if $m.edit_settings.search_items_by_page eq 20} SELECTED{/if}>20</option>
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='search_items_by_page'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_search_items_by_page&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.ext_editor eq 1}
		<tr>
			<td>{$lang.settings_extern_editor}:</td>
			<td><select name="p_exteditor" size="1">
			  <option value=""{if $m.edit_settings.ext_editor eq ""} SELECTED{/if}>[---------]</option>
			  {section name=i loop=$m.exteditors}
			  <option value="{$m.exteditors[i]}"{if $m.exteditors[i] eq $m.edit_settings.ext_editor} SELECTED{/if}>{$m.exteditors[i]}</option>
			  {/section}
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='ext_editor'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_extern_editor&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.noflood_time eq 1}
		<tr>
			<td>{$lang.settings_noflood_time}:</td>
			<td><input type="text" name="p_floodtime" value="{$m.edit_settings.noflood_time}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='noflood_time'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_noflood_time&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.blocks_use_image eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_blocks_use_image" value="1" {if $m.edit_settings.blocks_use_image eq "1"}checked{/if}> {$lang.settings_blocks_use_image}</td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='blocks_use_image'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_blocks_use_image&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.rewrite_index_title eq 1}
		<tr>
		    <td width="50%">{$lang.settings_rewrite_index_title}:</td>
			<td><input type="text" name="p_rewrite_index_title" value="{$m.edit_settings.rewrite_index_title}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='rewrite_index_title'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_rewrite_index_title&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.log_type eq 1}
		<tr>
			<td>{$lang.settings_log_type}:</td>
			<td><select name="p_log_type" size="1">
			  <option value="0"{if $m.edit_settings.log_type eq 0} SELECTED{/if}>{$lang.module_admin.log_types[0]}</option>
			  <option value="1"{if $m.edit_settings.log_type eq 1} SELECTED{/if}>{$lang.module_admin.log_types[1]}</option>
			  <option value="10"{if $m.edit_settings.log_type eq 10} SELECTED{/if}>{$lang.module_admin.log_types[10]}</option>
			  <option value="20"{if $m.edit_settings.log_type eq 20} SELECTED{/if}>{$lang.module_admin.log_types[20]}</option>
			  <option value="30"{if $m.edit_settings.log_type eq 30} SELECTED{/if}>{$lang.module_admin.log_types[30]}</option>
			  <option value="100"{if $m.edit_settings.log_type eq 100} SELECTED{/if}>{$lang.module_admin.log_types[100]}</option>
			  <option value="120"{if $m.edit_settings.log_type eq 120} SELECTED{/if}>{$lang.module_admin.log_types[120]}</option>
			</select></td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_log_type&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.log_store_days eq 1}
		<tr>
			<td>{$lang.settings_log_store_days}:</td>
			<td><input type="text" name="p_log_store_days" value="{$m.edit_settings.log_store_days}"></td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_log_store_days&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.image_generation_type eq 1}
		<tr>
			<td>{$lang.settings_image_generation_type}:</td>
			<td><select name="p_image_generation_type" size="1">
			  <option value="dynamic"{if $m.edit_settings.image_generation_type neq "static"} SELECTED{/if}>{$lang.common.dynamic}</option>
			  <option value="static"{if $m.edit_settings.image_generation_type eq "static"} SELECTED{/if}>{$lang.common.static}</option>
			</select></td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_image_generation_type&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.title_delimiter eq 1}
		<tr>
			<td>{$lang.settings_title_delimiter}:</td>
			<td><input type="text" name="p_title_delimiter" value="{$m.edit_settings.title_delimiter}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='title_delimiter'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_title_delimiter&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.meta_resource_title_position eq 1}
		<tr>
			<td>{$lang.settings_meta_resource_title_position}:</td>
			<td><select name="p_meta_resource_title_position" size="1">
			  <option value="0"{if $m.edit_settings.meta_resource_title_position eq "0"} SELECTED{/if}>{$lang.module_admin.meta_resource_title_position[0]}</option>
			  <option value="1"{if $m.edit_settings.meta_resource_title_position eq "1"} SELECTED{/if}>{$lang.module_admin.meta_resource_title_position[1]}</option>
			  <option value="2"{if $m.edit_settings.meta_resource_title_position eq "2"} SELECTED{/if}>{$lang.module_admin.meta_resource_title_position[2]}</option>
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='meta_resource_title_position'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_meta_resource_title_position&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.hide_generator_meta eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="hide_generator_meta" value="1" {if $m.edit_settings.hide_generator_meta eq "1"}checked{/if}> {$lang.settings_hide_generator_meta}</td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_hide_generator_meta&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
<tr>
	<td colspan="4" class="admin-settings-separator">{$lang.module_admin.menu_settings}</td>
</tr>
	{if $m.show_settings.upper_menu_id eq 1}
		<tr>
			<td>{$lang.settings_upper_menu_id}:</td>
			<td><select name="p_uppermenu" size="1">
			  <option value=""{if $m.edit_settings.upper_menu_id eq ""} SELECTED{/if}>[---------]</option>
			  {section name=i loop=$m.menus}
			  <option value="{$m.menus[i].id}"{if $m.menus[i].id eq $m.edit_settings.upper_menu_id} SELECTED{/if}>{$m.menus[i].title}</option>
			  {/section}
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='upper_menu_id'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_upper_menu_id&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.bottom_menu_id eq 1}
		<tr>
			<td>{$lang.settings_bottom_menu_id}:</td>
			<td><select name="p_bottommenu" size="1">
			  <option value=""{if $m.edit_settings.bottom_menu_id eq ""} SELECTED{/if}>[---------]</option>
			  {section name=i loop=$m.menus}
			  <option value="{$m.menus[i].id}"{if $m.menus[i].id eq $m.edit_settings.bottom_menu_id} SELECTED{/if}>{$m.menus[i].title}</option>
			  {/section}
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='bottom_menu_id'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_bottom_menu_id&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.users_menu_id eq 1}
		<tr>
			<td>{$lang.settings_users_menu_id}:</td>
			<td><select name="p_usersmenu" size="1">
			  <option value=""{if $m.edit_settings.users_menu_id eq ""} SELECTED{/if}>[---------]</option>
			  {section name=i loop=$m.menus}
			  <option value="{$m.menus[i].id}"{if $m.menus[i].id eq $m.edit_settings.users_menu_id} SELECTED{/if}>{$m.menus[i].title}</option>
			  {/section}
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='users_menu_id'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_users_menu_id&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.menus_use_image eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_menus_use_image" value="1" {if $m.edit_settings.menus_use_image eq "1"}checked{/if}> {$lang.settings_menus_use_image}</td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='menus_use_image'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_menus_use_image&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.menuitems_use_image eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_menuitems_use_image" value="1" {if $m.edit_settings.menuitems_use_image eq "1"}checked{/if}> {$lang.settings_menuitems_use_image}</td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='menuitems_use_image'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_menuitems_use_image&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
<tr>
	<td colspan="4" class="admin-settings-separator">{$lang.module_admin.content_settings}</td>
</tr>
	{if $m.show_settings.content_use_preview eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_content_use_preview" value="1" {if $m.edit_settings.content_use_preview eq "1"}checked{/if}> {$lang.settings_content_use_preview}</td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_content_use_preview&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.content_per_page_multiview eq 1}
		<tr>
			<td>{$lang.settings_content_per_page_multiview}:</td>
			<td><select name="p_multiviewperpage" size="1">
			  <option value="5"{if $m.edit_settings.content_per_page_multiview eq 5} SELECTED{/if}>5</option>
			  <option value="10"{if $m.edit_settings.content_per_page_multiview eq 10} SELECTED{/if}>10</option>
			  <option value="15"{if $m.edit_settings.content_per_page_multiview eq 15} SELECTED{/if}>15</option>
			  <option value="20"{if $m.edit_settings.content_per_page_multiview eq 20} SELECTED{/if}>20</option>
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='content_per_page_multiview'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_content_per_page_multiview&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.allow_alike_content eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_allow_alike_content" value="1" {if $m.edit_settings.allow_alike_content eq "1"}checked{/if}> {$lang.settings_allow_alike_content}</td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_allow_alike_content&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.alike_content_count eq 1}
		<tr>
			<td>{$lang.settings_alike_content_count}:</td>
			<td><input type="text" name="p_alike_content_count" value="{$m.edit_settings.alike_content_count}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='alike_content_count'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_alike_content_count&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.content_use_path eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_content_use_path" value="1" {if $m.edit_settings.content_use_path eq "1"}checked{/if}> {$lang.settings_content_use_path}</td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='content_use_path'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_content_use_path&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.content_attachments_count eq 1}
		<tr>
			<td>{$lang.settings_content_attachments_count}:</td>
			<td><select name="p_content_attachments_count" size="1">
			  <option value="0"{if $m.edit_settings.content_content_attachments_count eq 0} SELECTED{/if}>-</option>
			  {section name=i loop=16 start=1}
			  <option value="{$smarty.section.i.index}"{if $m.edit_settings.content_attachments_count eq $smarty.section.i.index} SELECTED{/if}>{$smarty.section.i.index}</option>
			  {/section}
			</select></td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_content_attachments_count&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.content_use_image eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_content_use_image" value="1" {if $m.edit_settings.content_use_image eq "1"}checked{/if}> {$lang.settings_content_use_image}</td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='content_use_image'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_content_use_image&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.content_image_preview_width eq 1}
		<tr>
			<td>{$lang.common.image_width} ({$lang.common.preview|lower}):</td>
			<td><input type="text" name="p_content_image_preview_width" value="{$m.edit_settings.content_image_preview_width}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='content_image_preview_width'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=content_image_preview_width&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.content_image_preview_height eq 1}
		<tr>
			<td>{$lang.common.image_height} ({$lang.common.preview|lower}):</td>
			<td><input type="text" name="p_content_image_preview_height" value="{$m.edit_settings.content_image_preview_height}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='content_image_preview_height'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=content_image_preview_height&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.content_image_fulltext_width eq 1}
		<tr>
			<td>{$lang.common.image_width} ({$lang.common.full_text|lower}):</td>
			<td><input type="text" name="p_content_image_fulltext_width" value="{$m.edit_settings.content_image_fulltext_width}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='content_image_fulltext_width'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=content_image_fulltext_width&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.content_image_fulltext_height eq 1}
		<tr>
			<td>{$lang.common.image_height} ({$lang.common.full_text|lower}):</td>
			<td><input type="text" name="p_content_image_fulltext_height" value="{$m.edit_settings.content_image_fulltext_height}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='content_image_fulltext_height'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=content_image_fulltext_height&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.content_editor_level eq 1}
		<tr>
			<td>{$lang.settings_editor_level}: </td>
			<td><select name="content_editor_level" size="1">
				<option value="3"{if 3 eq $m.edit_settings.content_editor_level} SELECTED{/if}>{$lang.administrators}</option>
				<option value="2"{if 2 eq $m.edit_settings.content_editor_level} SELECTED{/if}>{$lang.power_users}</option>
				<option value="1"{if 1 eq $m.edit_settings.content_editor_level} SELECTED{/if}>{$lang.logged_users}</option>
			</select></td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_content_editor_level&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.autogenerate_content_filesystem eq 1}
		<tr>
			<td>{$lang.common.autogeneration} - {$lang.common.url}: </td>
			<td><select name="autogenerate_content_filesystem" size="1">
				<option value=""{if "" eq $m.edit_settings.autogenerate_content_filesystem} SELECTED{/if}>{$lang.common.none}</option>
				<option value="1"{if 1 eq $m.edit_settings.autogenerate_content_filesystem} SELECTED{/if}>content-title.html</option>
			</select></td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_content_editor_level&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
<tr>
	<td colspan="4" class="admin-settings-separator">{$lang.news_settings}</td>
</tr>
	{if $m.show_settings.news_use_time eq 1}
	<tr>
		<td colspan="2"><input type="checkbox" name="p_news_use_time" value="1" {if $m.edit_settings.news_use_time eq "1"}checked{/if}> {$lang.settings_news_use_time}</td>
		<td></td>
		<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=news_use_time&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
	</tr>
	{/if}
	{if $m.show_settings.news_use_image eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_news_use_image" value="1" {if $m.edit_settings.news_use_image eq "1"}checked{/if}> {$lang.settings_news_use_image}</td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='news_use_image'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_news_use_image&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.news_image_preview_width eq 1}
		<tr>
			<td>{$lang.common.image_width} ({$lang.common.preview|lower}):</td>
			<td><input type="text" name="p_news_image_preview_width" value="{$m.edit_settings.news_image_preview_width}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='news_image_preview_width'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=news_image_preview_width&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.news_image_preview_height eq 1}
		<tr>
			<td>{$lang.common.image_height} ({$lang.common.preview|lower}):</td>
			<td><input type="text" name="p_news_image_preview_height" value="{$m.edit_settings.news_image_preview_height}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='news_image_preview_height'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=news_image_preview_height&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.news_image_fulltext_width eq 1}
		<tr>
			<td>{$lang.common.image_width} ({$lang.common.full_text|lower}):</td>
			<td><input type="text" name="p_news_image_fulltext_width" value="{$m.edit_settings.news_image_fulltext_width}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='news_image_fulltext_width'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=news_image_fulltext_width&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.news_image_fulltext_height eq 1}
		<tr>
			<td>{$lang.common.image_height} ({$lang.common.full_text|lower}):</td>
			<td><input type="text" name="p_news_image_fulltext_height" value="{$m.edit_settings.news_image_fulltext_height}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='news_image_fulltext_height'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=news_image_fulltext_height&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.news_by_page eq 1}
		<tr>
			<td>{$lang.settings_news_per_page}:</td>
			<td><select name="p_news_per_page" size="1">
			  <option value="5"{if $m.edit_settings.news_by_page eq 5} SELECTED{/if}>5</option>
			  <option value="10"{if $m.edit_settings.news_by_page eq 10} SELECTED{/if}>10</option>
			  <option value="15"{if $m.edit_settings.news_by_page eq 15} SELECTED{/if}>15</option>
			  <option value="20"{if $m.edit_settings.news_by_page eq 20} SELECTED{/if}>20</option>
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='news_by_page'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_news_per_page&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.news_use_preview eq 1}
	<tr>
		<td colspan="2"><input type="checkbox" name="p_news_use_preview" value="1" {if $m.edit_settings.news_use_preview eq "1"}checked{/if}> {$lang.settings_news_use_preview}</td>
		<td></td>
		<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_news_use_preview&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
	</tr>
	{/if}
	{if $m.show_settings.news_anounce_cut eq 1}
		<tr>
			<td>{$lang.settings_news_anounce_cut}:</td>
			<td><select name="p_news_cut" size="1">
			  <option value="50"{if $m.edit_settings.news_anounce_cut eq 50} SELECTED{/if}>50</option>
			  <option value="100"{if $m.edit_settings.news_anounce_cut eq 100} SELECTED{/if}>100</option>
			  <option value="150"{if $m.edit_settings.news_anounce_cut eq 150} SELECTED{/if}>150</option>
			  <option value="200"{if $m.edit_settings.news_anounce_cut eq 200} SELECTED{/if}>200</option>
			  <option value="300"{if $m.edit_settings.news_anounce_cut eq 300} SELECTED{/if}>300</option>
			  <option value="400"{if $m.edit_settings.news_anounce_cut eq 400} SELECTED{/if}>400</option>
			  <option value="500"{if $m.edit_settings.news_anounce_cut eq 500} SELECTED{/if}>500</option>
			  <option value="500"{if $m.edit_settings.news_anounce_cut eq 700} SELECTED{/if}>700</option>
			  <option value="1000"{if $m.edit_settings.news_anounce_cut eq 1000} SELECTED{/if}>1000</option>
			  <option value="1000"{if $m.edit_settings.news_anounce_cut eq 2000} SELECTED{/if}>2000</option>
			  <option value="1000"{if $m.edit_settings.news_anounce_cut eq 10000} SELECTED{/if}>10000</option>
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='news_anounce_cut'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_news_anounce_cut&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.short_news_count eq 1}
		<tr>
			<td>{$lang.settings_count_short_news}:</td>
			<td><select name="p_news_short" size="1">
			  {section name=i loop=20 start=1}
				  <option value="{$smarty.section.i.index}"{if $m.edit_settings.short_news_count eq $smarty.section.i.index} SELECTED{/if}>{$smarty.section.i.index}</option>
			  {/section}
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='short_news_count'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_count_short_news&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.short_news_cut eq 1}
		<tr>				 
			<td>{$lang.settings_short_news_cut}:</td>
			<td><select name="p_short_news_cut" size="1">
			  <option value="50"{if $m.edit_settings.short_news_cut eq 50} SELECTED{/if}>50</option>
			  <option value="100"{if $m.edit_settings.short_news_cut eq 100} SELECTED{/if}>100</option>
			  <option value="150"{if $m.edit_settings.short_news_cut eq 150} SELECTED{/if}>150</option>
			  <option value="200"{if $m.edit_settings.short_news_cut eq 200} SELECTED{/if}>200</option>
			  <option value="300"{if $m.edit_settings.short_news_cut eq 300} SELECTED{/if}>300</option>
			  <option value="400"{if $m.edit_settings.short_news_cut eq 400} SELECTED{/if}>400</option>
			  <option value="500"{if $m.edit_settings.short_news_cut eq 500} SELECTED{/if}>500</option>
			  <option value="700"{if $m.edit_settings.short_news_cut eq 600} SELECTED{/if}>700</option>
			  <option value="1000"{if $m.edit_settings.short_news_cut eq 1000} SELECTED{/if}>1000</option>
			  <option value="10000"{if $m.edit_settings.short_news_cut eq 10000} SELECTED{/if}>10000</option>
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='short_news_cut'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_short_news_cut&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.allow_alike_news eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_allow_alike_news" value="1" {if $m.edit_settings.allow_alike_news eq "1"}checked{/if}> {$lang.settings_allow_alike_news}</td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_allow_alike_news&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.alike_news_count eq 1}
		<tr>
			<td>{$lang.settings_alike_news_count}:</td>
			<td><input type="text" name="p_alike_news_count" value="{$m.edit_settings.alike_news_count}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='alike_news_count'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_alike_news_count&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.news_attachments_count eq 1}
		<tr>
			<td>{$lang.settings_news_attachments_count}:</td>
			<td><select name="p_news_attachments_count" size="1">
			  <option value="0"{if $m.edit_settings.news_news_attachments_count eq 0} SELECTED{/if}>-</option>
			  {section name=i loop=16 start=1}
			  <option value="{$smarty.section.i.index}"{if $m.edit_settings.news_attachments_count eq $smarty.section.i.index} SELECTED{/if}>{$smarty.section.i.index}</option>
			  {/section}
			</select></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='news_news_attachments_count'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_news_attachments_count&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.news_full_list_longformat eq 1}
		<tr>
			<td>{$lang.list_news}: </td>
			<td><select name="news_full_list_longformat" size="1">
				<option value="0"{if 0 eq $m.edit_settings.news_full_list_longformat} SELECTED{/if}>{$lang.common.preview}</option>
				<option value="1"{if 1 eq $m.edit_settings.news_full_list_longformat} SELECTED{/if}>{$lang.common.full_text}</option>
			</select></td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=news_full_list_longformat&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.news_editor_level eq 1}
		<tr>
			<td>{$lang.settings_editor_level}: </td>
			<td><select name="news_editor_level" size="1">
				<option value="3"{if 3 eq $m.edit_settings.news_editor_level} SELECTED{/if}>{$lang.administrators}</option>
				<option value="2"{if 2 eq $m.edit_settings.news_editor_level} SELECTED{/if}>{$lang.power_users}</option>
				<option value="1"{if 1 eq $m.edit_settings.news_editor_level} SELECTED{/if}>{$lang.logged_users}</option>
			</select></td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_news_editor_level&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.autogenerate_news_filesystem eq 1}
	<tr>
		<td>{$lang.common.autogeneration} - {$lang.common.url}: </td>
		<td><select name="autogenerate_news_filesystem" size="1">
			<option value=""{if "" eq $m.edit_settings.autogenerate_news_filesystem} SELECTED{/if}>{$lang.common.none}</option>
			<option value="1"{if 1 eq $m.edit_settings.autogenerate_news_filesystem} SELECTED{/if}>news-title.html</option>
			<option value="2"{if 2 eq $m.edit_settings.autogenerate_news_filesystem} SELECTED{/if}>news/news-title.html</option>
			<option value="4"{if 2 eq $m.edit_settings.autogenerate_news_filesystem} SELECTED{/if}>news/yyyy/mm/dd/news-title.html</option>
			<option value="3"{if 3 eq $m.edit_settings.autogenerate_news_filesystem} SELECTED{/if}>blog/news-title.html</option>
			<option value="5"{if 5 eq $m.edit_settings.autogenerate_news_filesystem} SELECTED{/if}>blog/yyyy/mm/dd/news-title.html</option>
		</select></td>
		<td></td>
		<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_content_editor_level&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
	</tr>
	{/if}
<tr>
	<td colspan="4" class="admin-settings-separator">{$lang.user_settings}</td>
</tr>
	{if $m.show_settings.allow_register eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_allowregister" value="1" {if $m.edit_settings.allow_register eq "1"}checked{/if}> {$lang.settings_allow_register}</td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_allow_register&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.allow_forgot_password eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_allowforgotpass" value="1" {if $m.edit_settings.allow_forgot_password eq "1"}checked{/if}> {$lang.settings_allow_forgot_password}</td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_allow_forgot_password&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.user_activating_by_admin eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_adminactivating" value="1" {if $m.edit_settings.user_activating_by_admin eq "1"}checked{/if}> {$lang.settings_user_activating_by_admin}</td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_user_activating_by_admin&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.return_after_login eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_return_after_login" value="1" {if $m.edit_settings.return_after_login eq "1"}checked{/if}> {$lang.settings_return_after_login}</td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='return_after_login'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_return_after_login&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.allow_private_messages eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_allow_private_messages" value="1" {if $m.edit_settings.allow_private_messages eq "1"}checked{/if}> {$lang.settings_allow_private_messages}</td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_allow_private_messages&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.use_email_as_login eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="p_use_email_as_login" value="1" {if $m.edit_settings.use_email_as_login eq "1"}checked{/if}> {$lang.settings_use_email_as_login}</td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_use_email_as_login&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.signinwithloginandemail eq 1}
		<tr>
			<td colspan="2"><input type="checkbox" name="signinwithloginandemail" value="1" {if $m.edit_settings.signinwithloginandemail eq "1"}checked{/if}> {$lang.settings_signinwithloginandemail}</td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=signinwithloginandemail&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.redirect_after_login_1 eq 1}
		<tr>
			<td>{$lang.settings_redirect_after_login} ({$lang.logged_users}):</td>
			<td><input type="text" name="p_redirect_after_login_1" value="{$m.edit_settings.redirect_after_login_1}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='redirect_after_login_1'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=redirect_after_login_1&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.redirect_after_login_2 eq 1}
		<tr>
			<td>{$lang.settings_redirect_after_login} ({$lang.power_users}):</td>
			<td><input type="text" name="p_redirect_after_login_2" value="{$m.edit_settings.redirect_after_login_2}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='redirect_after_login_2'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=redirect_after_login_2&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.redirect_after_login_3 eq 1}
		<tr>
			<td>{$lang.settings_redirect_after_login} ({$lang.administrators}):</td>
			<td><input type="text" name="p_redirect_after_login_3" value="{$m.edit_settings.redirect_after_login_3}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='redirect_after_login_3'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=redirect_after_login_3&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.redirect_after_register eq 1}
		<tr>
			<td>{$lang.settings_redirect_after_register}:</td>
			<td><input type="text" name="p_redirect_after_register" value="{$m.edit_settings.redirect_after_register}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='redirect_after_register'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=redirect_after_register&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.redirect_after_logout eq 1}
		<tr>
			<td>{$lang.settings_redirect_after_logout}:</td>
			<td><input type="text" name="p_redirect_after_logout" value="{$m.edit_settings.redirect_after_logout}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='redirect_after_logout'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=redirect_after_logout&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.redirect_on_success_change_usrdata eq 1}
		<tr>
			<td>{$lang.settings_redirect_on_success_change_usrdata}:</td>
			<td><input type="text" name="redirect_on_success_change_usrdata" value="{$m.edit_settings.redirect_on_success_change_usrdata}"></td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='redirect_on_success_change_usrdata'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=redirect_on_success_change_usrdata&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
<tr>
	<td colspan="4" class="admin-settings-separator">{$lang.security_settings}</td>
</tr>
	{if $m.show_settings.banned_ip eq 1}
		<tr>
			<td colspan="2">{$lang.settings_banned_ip}<br /><div align="center">
				<textarea cols="40" rows="3" name="p_banned_ip">{$m.edit_settings.banned_ip}</textarea>
				</div>
			</td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_banned_ip&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
<tr>
	<td colspan="4" class="admin-settings-separator">{$lang.static_text_settings}</td>
</tr>
	{if $m.show_settings.meta_header_text eq 1}
		<tr>
			<td colspan="2">{$lang.settings_meta_header_text}<br /><div align="center">
				<textarea cols="40" rows="3" name="p_meta_header_text" wrap="off">{$m.edit_settings.meta_header_text}</textarea>
				</div>
			</td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='meta_header_text'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_meta_header_text&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.header_static_text eq 1}
		<tr>
			<td colspan="2">{$lang.settings_header_static_text}<br /><div align="center">
				<textarea cols="40" rows="3" name="p_htext" wrap="off">{$m.edit_settings.header_static_text}</textarea>
				</div>
			</td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='header_static_text'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_header_static_text&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.footer_static_text eq 1}
		<tr>
			<td colspan="2">{$lang.settings_footer_static_text}<br /><div align="center">
				<textarea cols="40" rows="3" name="p_ftext" wrap="off">{$m.edit_settings.footer_static_text}</textarea>
				</div>
			</td>
			<td>{include file='admin_settings_extctrls.tpl' name_settings='footer_static_text'}</td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_footer_static_text&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
<tr>
	<td colspan="4" class="admin-settings-separator">{$lang.module_admin.mass_email_settings}</td>
</tr>
	{if $m.show_settings.administrators_email eq 1}
		<tr>
			<td>{$lang.settings_administrators_email}</td>
			<td><input type="text" name="p_admemail" value="{$m.edit_settings.administrators_email}"></td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_administrators_email&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
	{if $m.show_settings.email_signature eq 1}
		<tr>
			<td colspan="2">{$lang.settings_email_signature}<br /><div align="center">
				<textarea cols="40" rows="3" name="p_esignature">{$m.edit_settings.email_signature}</textarea>
				</div>
			</td>
			<td></td>
			<td>{if $_settings.show_help eq "on"}<a target="_blank" href="http://{$m.edit_settings.help_resource}/index.php?m=help&q=settings_email_signature&lang={$m.edit_settings.default_language}">[?]</a>{/if}</td>
		</tr>
	{/if}
{$m.formadditionalhtml}
<tr>
	<td colspan="4" style="text-align: center"><input type="submit" value="{$lang.save}"></td>
</tr>
</table>
</form>
{include file="block_end.tpl"}
{/if}
