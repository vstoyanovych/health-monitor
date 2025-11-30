{assign var=m value=$modules[$index]}

<div class="profilesidebarright campaignsheader compaign-tabs-count">
    <ul class="nav nav-tabs child-li-tab">
        <li {if $data.current_action eq "ips"} class="active"{/if}><a href="index.php?m=ips">Visitors</a></li>
        <li {if $data.current_action eq "pages"} class="active"{/if}><a href="index.php?m=visitors">Pages</a></li>
        <li {if $data.current_action eq "channels"} class="active"{/if}><a href="index.php?m=visitors&d=channelstats">Channels</a></li>
        <li {if $data.current_action eq "playliststats"} class="active"{/if}><a href="index.php?m=visitors&d=playliststats">Playlists</a></li>
        <li {if $data.current_action eq "accountstats"} class="active"{/if}><a href="index.php?m=visitors&d=accountstats">Accounts</a></li>
    </ul>
</div>

<script>
    function  admintable_msgbox(question, url)
    {ldelim}
        Confirm('Confirmation', question, 'Yes', 'Cancel',url);
        {rdelim}
</script>