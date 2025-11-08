<?php /* Smarty version 2.6.26, created on 2024-09-15 04:47:40
         compiled from ajaxsearch.tpl */ ?>
<div class="filter-customer-name flex gap-10">
    <div class="frmSearch">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="search-box" class="form-control" value="<?php echo $this->_tpl_vars['data']['search']; ?>
" placeholder="Name" />
        </div>
        <div id="suggesstion-box"></div>
    </div>
    <?php if ($this->_tpl_vars['data']['search'] != ""): ?>
        <a href="<?php echo $this->_tpl_vars['data']['clearfilterurl']; ?>
" class="clear-organizations-filter">Clear Filters</a>
    <?php endif; ?>
</div>
<script>
    $(document).ready(function(){
        $("#search-box").keyup(function(){
            $.ajax({
                type: "POST",
                url: "<?php echo $this->_tpl_vars['data']['searchurl']; ?>
",
                data:'title='+$(this).val(),
                beforeSend: function(){
                    $("#search-box").css("background","#FFF no-repeat 165px");
                },
                success: function(data){
                    $("#suggesstion-box").show();
                    $("#suggesstion-box").html(data);
                    $("#search-box").css("background","#FFF");
                }
            });
        });
    });
</script>