<?php /* Smarty version 2.6.26, created on 2025-11-07 20:36:19
         compiled from bulkactiondropdown.tpl */ ?>
<div class="bulkactions">
    <a href="javascript:;"  id="bulkdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Bulk Actions
        <i class="fa fa-caret-down"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bulkdropdown">
        <a href="javascript:;" class="dropdown-item" onclick="Delete()">Delete</a>
    </div>
</div>

<script>
     function Delete()
        {
                if( $('#bulkactionsform input[type=checkbox]:checked').length )
                {
                        if (confirm("Are you sure?"))
                            $('#bulkactionsform').attr('action', 'index.php?m=newsfeed&d=bulkdelete&returnto=' + $('#returnto').val()).submit();
                        return false;
                    }
                else
                    alert ('Nothing Selected')
            }
</script>