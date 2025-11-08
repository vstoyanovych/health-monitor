{assign var=m value=$modules[$index]}

<div class="profilesidebarright campaignsheader compaign-tabs-count">
    <ul class="nav nav-tabs child-li-tab">
        <li {if $data.show eq "all"} class="active"{/if}><a href="{$data.allUrl}">All</a></li>
        <li {if $data.show eq "videos"} class="active"{/if}><a href="{$data.videosUrl}">Videos</a></li>
        <li {if $data.show eq "articles"} class="active"{/if}><a href="{$data.articlesUrl}">Articles</a></li>
    </ul>
</div>

<script>
    function  admintable_msgbox(question, url)
    {ldelim}
        Confirm('Confirmation', question, 'Yes', 'Cancel',url);
        {rdelim}
</script>