<?php /* Smarty version 2.6.26, created on 2024-09-15 04:38:54
         compiled from simplesearch.tpl */ ?>
<form action="<?php echo $this->_tpl_vars['data']['searchurl']; ?>
" method="GET" enctype="multipart/form-data" class="flex flex-gap-5">
    <input type="hidden" name="m" value="<?php echo $this->_tpl_vars['data']['m']; ?>
">
<div class="frmSearch filter-customer-name">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" id="search-box" class="form-control" name="search" value="<?php echo $this->_tpl_vars['data']['search']; ?>
" placeholder="Search" />
    <div id="suggesstion-box"></div>
</div>
<?php if ($this->_tpl_vars['data']['search'] != ""): ?>
    <a href="<?php echo $this->_tpl_vars['data']['clearfilterurl']; ?>
" class="clear-organizations-filter">Clear Filters</a>
<?php endif; ?>
</form>