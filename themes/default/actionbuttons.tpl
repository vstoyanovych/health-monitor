<div class="dropdown action-buttons">
    <button class="btn ab-button dropdown-toggle btn-focus-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        <span>{if $data.button_title neq ""}{$data.button_title}{else}Actions{/if} <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.5 6.75L9 11.25L13.5 6.75" stroke="#4B5563" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
    </button>
    <div class="dropdown-menu dropdown-menu-compaign dropdown-menu-cont">
        {section name=i loop=$data.actionbuttons}
            <a href="{$data.actionbuttons[i].url}" onclick="{$data.actionbuttons[i].onclick}" class="dropdown-item {if $data.actionbuttons[i].active}active{/if}">{$data.actionbuttons[i].icon}<span>{$data.actionbuttons[i].title}</span></a>
        {/section}
    </div>
</div>
