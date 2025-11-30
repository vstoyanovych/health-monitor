<form action="{$data.searchurl}" method="GET" enctype="multipart/form-data" class="flex flex-gap-5">
    <input type="hidden" name="m" value="{$data.m}">
<div class="frmSearch filter-customer-name">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" id="search-box" class="form-control" name="search" value="{$data.search}" placeholder="Search" />
    <div id="suggesstion-box"></div>
</div>
{if $data.search neq ""}
    <a href="{$data.clearfilterurl}" class="clear-organizations-filter">Clear Filters</a>
{/if}
</form>
