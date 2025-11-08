{strip}{if $postfix eq ""}
	{assign var=postfix value=$form.postfix}
{/if}
{$form.html_begin}

{if $form.dont_use_form_tag neq 1}
<form{foreach name=form_attr_index from=$form.attrs item=attrval key=attrname} {$attrname}="{$attrval}"{/foreach}>
{/if}
<div id="adminform_table{$postfix}-{$smarty.section.tabsectionindex.index}" class="adminform_table">
	{foreach name=form_field_index from=$form.fields item=field key=field_name}
	{if $field.tab eq $smarty.section.tabsectionindex.index}
		{if $field.hidedefinition neq 1 and  $field.type neq "hidden"}
			<div{foreach name=form_field_attr_index from=$field.rowattrs item=attrval key=attrname} {$attrname}="{$attrval}"{/foreach}>{/if}

				{if $field.type neq "hidden" and $field.type neq "checkbox" and $field.type neq "separator" and $field.mergecolumns neq 1 and $field.hidedefinition neq 1}
					<div><label class="form-label">{$field.caption}{$field.column[0]}{if $field.required}<sup class="adminform-required">*</sup>{/if}</label></div>
					<div>
				{elseif $field.type eq "checkbox"}
					<div class="flex-container">
				{elseif $field.mergecolumns eq 1}
					<div><label class="form-label">{$field.caption}</label></div>
					<div>
				{elseif $field.type eq "separator"}
					<div class="card-title text-slate-900">{$field.caption}</div>
					<div>
				{/if}


				{assign var=field_db value=$field.name}
				{if $field.toptext neq ""}{$field.toptext}<br />{/if}
				{$field.begintext}
				{if $field.type eq "label"}
					{$field.labeltext}
				{elseif $field.type eq "html"}
					{$field.html}
				{elseif $field.type eq "bar"}
					{include file="common_adminbuttons.tpl" bar=$field.data}
				{elseif $field.type eq "table"}
					{include file="common_admintable.tpl" table=$field.data}
				{elseif $field.type eq "tpl"}
					{include file=$field.tpl data=$field.data action=$field.action}
				{elseif $field.type eq "statictext"}
					<input type="hidden" name="{$form.prefix}{$field.name}" value="{$form.data.$field_db}" id="{$field.id}"{foreach name=form_field_attr_index from=$field.attrs item=attrval key=attrname} {$attrname}="{$attrval}"{/foreach} /> {$form.data.$field_db}
				{elseif $field.type eq "text" or $field.type eq "password" or $field.type eq "hidden"}
					<input type="{$field.type}" class="form-control" name="{$form.prefix}{$field.name}" value="{$form.data.$field_db}" id="{$field.id}"{foreach name=form_field_attr_index from=$field.attrs item=attrval key=attrname} {$attrname}="{$attrval}"{/foreach} />
				{elseif $field.type eq "file"}
					<input type="hidden" name="MAX_FILE_SIZE" value="{$_settings.max_upload_filesize}" />
					<input type="file" name="{$form.prefix}{$field.name}" id="{$field.id}"{foreach name=form_field_attr_index from=$field.attrs item=attrval key=attrname} {$attrname}="{$attrval}"{/foreach} />
				{elseif $field.type eq "textarea"}
					<textarea class="form-control" name="{$form.prefix}{$field.name}" cols="30" rows="5" id="{$field.id}"{foreach name=form_field_attr_index from=$field.attrs item=attrval key=attrname} {$attrname}="{$attrval}"{/foreach}>{$form.data.$field_db}</textarea>
				{elseif $field.type eq "select"}
					<select class="form-control wide" name="{$form.prefix}{$field.name}" size="1" id="{$field.id}"{foreach name=form_field_attr_index from=$field.attrs item=attrval key=attrname} {$attrname}="{$attrval}"{/foreach}>
						{section name=form_option_index loop=$field.options}
							<option{foreach name=form_field_attr_index from=$field.options[form_option_index].attrs item=attrval key=attrname} {$attrname}="{$attrval}"{/foreach}>{$field.options[form_option_index].label}</option>
						{/section}
					</select>
				{elseif $field.type eq "radiogroup"}
					<div id="{$field.id}"{foreach name=form_field_attr_index from=$field.attrs item=attrval key=attrname} {$attrname}="{$attrval}"{/foreach}>
					{section name=form_option_index loop=$field.options}
						<div{foreach name=form_field_attr_index from=$field.options_item[form_option_index].attrs item=attrval key=attrname} {$attrname}="{$attrval}"{/foreach}>
							<input type="radio" name="{$form.prefix}{$field.name}"{foreach name=form_field_attr_index from=$field.options[form_option_index].attrs item=attrval key=attrname} {$attrname}="{$attrval}"{/foreach}> <span{foreach name=form_field_attr_index from=$field.options_label[form_option_index].attrs item=attrval key=attrname} {$attrname}="{$attrval}"{/foreach}>{$field.options[form_option_index].label}</span>
						</div>
					{/section}
					</div>
				{elseif $field.type eq "editor"}
					{include file="editors_`$_settings.ext_editor`.tpl" editor_doing="common" var=`$form.prefix``$field.name` value=$form.data.$field_db noninit=$field.noinit style=$field.attrs.style}
				{elseif $field.type eq "checkbox"}
					<label class="form-label checkbox-container" for="{$field.id}">{$field.caption}</label><input type="checkbox" name="{$form.prefix}{$field.name}" value="{$field.checkedvalue}" id="{$field.id}"{if $form.data.$field_db eq $field.checkedvalue} checked{/if} />
				{/if}
				{$field.endtext}
				{if $field.image.href neq ""}<a href="{$field.image.href}" target="_blank">{/if}{if $field.image.src neq ""}<img src="{$field.image.src}" border="0" align="middle" />{/if}{if $field.image.href neq ""}</a>{/if}
				{if $field.bottomtext neq ""}{$field.bottomtext}{/if}
				{if $field.type neq "hidden" and $field.hideencloser neq 1}
				{$field.column[1]}
			</div>
			

			{if $form.tooltip_present}
				<div>
					{if $field.tooltip neq ""}<div class="adminform-tooltip" title="{$field.tooltip}"><img src="{$field.tooltipimg}" /></div>{/if}
					{$field.column[2]}
				</div>
			{/if}
			</div>
		{/if}
	{/if}
	{/foreach}
</div>
{if $form.dont_use_form_tag neq 1 and not $form.nosubmitbutton}
<div class="adminform_savebutton adminform_savebutton_{$form.postfix}">{if $form.savebutton_helper.text neq ""}<span class="adminform_savebutton_helper adminform_savebutton_helper_{$form.postfix} {$form.savebutton_helper.class}">{$form.savebutton_helper.text}</span>{/if}<input type="submit" value="{if $form.savetitle neq ""}{$form.savetitle}{else}{$lang.save}{/if}"></div>
</form>
{/if}

{$form.html_end}{/strip}