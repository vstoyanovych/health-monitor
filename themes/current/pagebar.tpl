{if $modules[$index].pages.pages gt "1"}
	<ul class="pagination">
		{if $modules[$index].pages.selected neq 1}
			<li>
				<a href="{$modules[$index].pages.url}&from={math equation="x*y" x=$modules[$index].pages.interval y=$modules[$index].pages.selected-2}">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M9.78033 12.7803C9.48744 13.0732 9.01256 13.0732 8.71967 12.7803L4.46967 8.53033C4.17678 8.23744 4.17678 7.76256 4.46967 7.46967L8.71967 3.21967C9.01256 2.92678 9.48744 2.92678 9.78033 3.21967C10.0732 3.51256 10.0732 3.98744 9.78033 4.28033L6.06066 8L9.78033 11.7197C10.0732 12.0126 10.0732 12.4874 9.78033 12.7803Z" fill="CurrentColor"/>
					</svg><span>Previous</span>
				</a>
			</li>
		{/if}
		{if $modules[$index].pages.pages lte 20}
			{section name="i" loop=5000 max=$modules[$index].pages.pages start="1"}
				<li{if $smarty.section.i.index eq $modules[$index].pages.selected} class="active"{/if}>
					<a href="{$modules[$index].pages.url}&from={math equation="x*y" x=$modules[$index].pages.interval y=$smarty.section.i.index-1}">{$smarty.section.i.index}</a>
				</li>
			{/section}
		{elseif $modules[$index].pages.selected lt 9 or $modules[$index].pages.selected gt $modules[$index].pages.pages-9}
			{section name="i" loop=10 max=$modules[$index].pages.pages start="1"}
				<li{if $smarty.section.i.index eq $modules[$index].pages.selected} class="active"{/if}>
					<a href="{$modules[$index].pages.url}&from={math equation="x*y" x=$modules[$index].pages.interval y=$smarty.section.i.index-1}">{$smarty.section.i.index}</a>
				</li>
			{/section}
			<li class="disabled"><a>...</a></li>
			{section name="i" loop=$modules[$index].pages.pages+1 start=$modules[$index].pages.pages-9}
				<li{if $smarty.section.i.index eq $modules[$index].pages.selected} class="active"{/if}>
					<a href="{$modules[$index].pages.url}&from={math equation="x*y" x=$modules[$index].pages.interval y=$smarty.section.i.index-1}">{$smarty.section.i.index}</a>
				</li>
			{/section}
		{else}
			{section name="i" loop=4 max=$modules[$index].pages.pages start="1"}
				<li{if $smarty.section.i.index eq $modules[$index].pages.selected} class="active"{/if}>
					<a href="{$modules[$index].pages.url}&from={math equation="x*y" x=$modules[$index].pages.interval y=$smarty.section.i.index-1}">{$smarty.section.i.index}</a>
				</li>
			{/section}
			<li class="disabled"><a>...</a></li>
			{section name="i" loop=$modules[$index].pages.selected+4  start=$modules[$index].pages.selected-4}
				<li{if $smarty.section.i.index eq $modules[$index].pages.selected} class="active"{/if}>
					<a href="{$modules[$index].pages.url}&from={math equation="x*y" x=$modules[$index].pages.interval y=$smarty.section.i.index-1}">{$smarty.section.i.index}</a>
				</li>
			{/section}
			<li class="disabled"><a>...</a></li>
			{section name="i" loop=$modules[$index].pages.pages+1 start=$modules[$index].pages.pages-4}
				<li{if $smarty.section.i.index eq $modules[$index].pages.selected} class="active"{/if}>
					<a href="{$modules[$index].pages.url}&from={math equation="x*y" x=$modules[$index].pages.interval y=$smarty.section.i.index-1}">{$smarty.section.i.index}</a>
				</li>
			{/section}
		{/if}
		{if $modules[$index].pages.selected neq $modules[$index].pages.pages}
			<li>
				<a href="{$modules[$index].pages.url}&from={math equation="x*y" x=$modules[$index].pages.interval y=$modules[$index].pages.selected}">
					<span>Next</span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M6.21967 3.21967C6.51256 2.92678 6.98744 2.92678 7.28033 3.21967L11.5303 7.46967C11.8232 7.76256 11.8232 8.23744 11.5303 8.53033L7.28033 12.7803C6.98744 13.0732 6.51256 13.0732 6.21967 12.7803C5.92678 12.4874 5.92678 12.0126 6.21967 11.7197L9.93934 8L6.21967 4.28033C5.92678 3.98744 5.92678 3.51256 6.21967 3.21967Z" fill="CurrentColor"/>
					</svg>
				</a>
			</li>
		{/if}
	</ul>
{/if}