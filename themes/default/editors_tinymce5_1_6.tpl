{if $noninit neq "1"}
{$special.editor.exthtml}
<script type="text/javascript" src="ext/editors/{$_settings.ext_editor}/tinymce.min.js"></script>
{/if}

{if $editor_doing eq "common"}
<textarea name="{$var}" id="{$var}" class="tinymce5_1_6" style="{if $style eq ""}width: 98%; height:400px;{else}{$style}{/if}">{$value}</textarea>
<script type="text/javascript">
	tinymce.init({ldelim}selector: '.tinymce5_1_6'{if $_settings.tinymce5_1_6_customization neq ""}{$_settings.tinymce5_1_6_customization}{else}{$sm.tinymce5_1_6_default_params}{/if}{rdelim});
</script>
{/if}

{if $editor_doing eq "editor"}
	<textarea name="{$var}" id="{$var}" class="tinymce5_1_6" style="{if $style eq ""}width: 98%; height:400px;{else}{$style}{/if}">{$value}</textarea>

	<script type="text/javascript">
		tinymce.init({ldelim}selector: '.tinymce5_1_6'{if $_settings.tinymce5_1_6_customization neq ""}{$_settings.tinymce5_1_6_customization}{else}{$sm.tinymce5_1_6_default_params}{/if}{rdelim});
	</script>

{/if}