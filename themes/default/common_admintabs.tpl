{strip}
{assign var="tabs_global" value=$data[0].globaldata}
<div{foreach from=$tabs_global.main_container.attrs key=attr_name item=attr_value} {$attr_name}="{$attr_value}"{/foreach}>
	<!-- Nav tabs -->
	<ul{foreach from=$tabs_global.tabs_container.attrs key=attr_name item=attr_value} {$attr_name}="{$attr_value}"{/foreach}>
	{section name=admintabsblockindex loop=$data}
		<li{foreach from=$data[admintabsblockindex].tab_header_container.attrs key=attr_name item=attr_value} {$attr_name}="{$attr_value}"{/foreach}>
			<a {foreach from=$data[admintabsblockindex].tab_header_item.attrs key=attr_name item=attr_value} {$attr_name}="{$attr_value}"{/foreach}>{$data[admintabsblockindex].title}</a>
		</li>
	{/section}
	</ul>
	<!-- Tab panes -->
	<div{foreach from=$tabs_global.main_content_container.attrs key=attr_name item=attr_value} {$attr_name}="{$attr_value}"{/foreach}>
	{section name=admintabsblockindex loop=$data}
		<div{foreach from=$data[admintabsblockindex].tab_content_container.attrs key=attr_name item=attr_value} {$attr_name}="{$attr_value}"{/foreach}>
		{section name=admintabsitemindex loop=$data[admintabsblockindex].items}
		{if $data[admintabsblockindex].items[admintabsitemindex].type eq "form"}
			{include file="common_adminform.tpl" form=$data[admintabsblockindex].items[admintabsitemindex].form}
		{elseif $data[admintabsblockindex].items[admintabsitemindex].type eq "table"}
			{include file="common_admintable.tpl" table=$data[admintabsblockindex].items[admintabsitemindex].table}
		{elseif $data[admintabsblockindex].items[admintabsitemindex].type eq "board"}
			{include file="common_boardmessages.tpl" board=$data[admintabsblockindex].items[admintabsitemindex].board}
		{elseif $data[admintabsblockindex].items[admintabsitemindex].type eq "bar"}
			{include file="common_adminbuttons.tpl" bar=$data[admintabsblockindex].items[admintabsitemindex].bar}
		{elseif $data[admintabsblockindex].items[admintabsitemindex].type eq "panel"}
			{include file="common_adminpanel.tpl" panelblocks=$data[admintabsblockindex].items[admintabsitemindex].panel}
		{elseif $data[admintabsblockindex].items[admintabsitemindex].type eq "pagebar"}
			{include file="pagebar.tpl"}
		{elseif $data[admintabsblockindex].items[admintabsitemindex].type eq "html"}
			{$data[admintabsblockindex].items[admintabsitemindex].html}
		{elseif $data[admintabsblockindex].items[admintabsitemindex].tpl neq ""}
			{include file=$data[admintabsblockindex].items[admintabsitemindex].tpl data=$data[admintabsblockindex].items[admintabsitemindex].data action=$data[admintabsblockindex].items[admintabsitemindex].action}
		{/if}
		{/section}
		</div>
	{/section}
	</div>
</div>
{/strip}