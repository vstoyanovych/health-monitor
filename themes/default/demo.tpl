{*start-regular*}
{if $m.mode eq "regular"}
	{include file="block_begin.tpl"}
		<p>Regular Smarty template body. Sample <strong>{$m.test_var}</strong> value.</p>
		<div>Sample loop:
			<ul>
				{foreach from=$m.lines item=line_text}
					<li>{$line_text}</li>
				{/foreach}
			</ul>
		</div>
		<p>You can use the same var several times: <strong>{$m.test_var}</strong>.</p>
	{include file="block_end.tpl"}
{/if}
{*end-regular*}