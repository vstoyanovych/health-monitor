{strip}<ul class="anav-container{if $data.class neq ""} {$data.class}{/if}">
{foreach name=admindash_index from=$data.items item=item key=item_index}
    {$item.htmlstart}<li {foreach from=$item.container.attrs item=attr key=attr_name}{if $attr neq ""} {$attr_name}="{$attr}"{/if}{/foreach}>
		<a {foreach name=admindashitemattrs_index from=$item.attrs item=attr key=attr_name}{if $attr neq ""} {$attr_name}="{$attr}"{/if}{/foreach}>
			{section name=j loop=$item.level start=1}<span class="anav-level-marker">-</span>{/section}
			{$item.html}
		</a>
	</li>{$item.htmlend}
{/foreach}
</ul>{/strip}