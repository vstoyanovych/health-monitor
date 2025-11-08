{assign var=m value=$modules[$index]}

<div class="profilesidebarright campaignsheader compaign-tabs-count">
    <ul class="nav nav-tabs child-li-tab">
        <li {if $data.current_action eq "logo"} class="active"{/if}><a href="index.php?m=settings&d=logo">Logo</a></li>
        <li {if $data.current_action eq "emailsettings"} class="active"{/if}><a href="index.php?m=settings&d=emailsettings">Email Settings</a></li>
        <li {if $data.current_action eq "grabbersettings"} class="active"{/if}><a href="index.php?m=settings&d=grabbersettings">Grabbers</a></li>
        <li {if $data.current_action eq "facebooksettings"} class="active"{/if}><a href="index.php?m=settings&d=facebooksettings">Facebook</a></li>
        <li {if $data.current_action eq "twittersettings"} class="active"{/if}><a href="index.php?m=settings&d=twittersettings">Twitter</a></li>
        <li {if $data.current_action eq "redditsettings"} class="active"{/if}><a href="index.php?m=settings&d=redditsettings">Reddit</a></li>
    </ul>
</div>

<script>
    function  admintable_msgbox(question, url)
    {ldelim}
        Confirm('Confirmation', question, 'Yes', 'Cancel',url);
        {rdelim}
</script>