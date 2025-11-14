{include file="page_header.tpl"}

<!-- Wrapper-->
<div class="wrapper flex align-items-start">
    {if $userinfo.level neq 0 }
    <!-- Navigation-->
    <aside class="navigation">
        <nav>
            <div class="tog-button-left">
                <div class="flex align-items-center w-100">
                <a href="{if $special.page.scheme neq ""}{$special.page.scheme}{else}http{/if}://{$special.resource_url}" class="navbar-brand">{$_settings.logo_text}</a>
                    {if $sm.g.m eq "account" OR $userinfo.level gt 0 }
                        <div id="navbar" class="navbar-collapse collapse flex-1">
                            <div class="left-nav-toggle">
                                <a href="javascript:;" class="toggle-hd">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="25" height="25">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                                    </svg>

                                </a>
                            </div>
                        </div>
                    {/if}
                </div>
            </div>
            <div class="flex flex-column h-100-100">
                <ul class="nav luna-nav flex-1 w-100">
                    {section name=i loop=$sm.mainmenu}
                        <li {if $sm.mainmenu[i].selected}class=" active"{/if}>
                            {if $sm.mainmenu[i].url neq ""}
                                <a href="{$sm.mainmenu[i].url}"{if $sm.mainmenu[i].target neq ""} target="{$sm.mainmenu[i].target}"{/if}>
                                    <div class="w-100">
                                        <span class="main-menu-icon {if $sm.mainmenu[i].icon_class neq ""} fa-fas {$sm.mainmenu[i].icon_class}{/if}">
                                            {if $sm.mainmenu[i].icon neq ""}
                                                <img src="{$sm.mainmenu[i].icon}"/>
                                            {/if}
                                        </span>
                                        <span class="flex">
                                            <span class="main-menu-text flex-1">{$sm.mainmenu[i].title}</span>
                                            {if $sm.mainmenu[i].count gt 0}
                                                <span class="items_count show-alert">{$sm.mainmenu[i].count}</span>
                                            {/if}
                                        </span>
                                    </div>
                                    {* <span class="left-menu-right-arrow"><i class="fas fa-angle-right"></i></span> *}
                                </a>
                            {else}
                                <span class="main-menu-label">
                                {$sm.mainmenu[i].title}
                            </span>
                            {/if}
                            {if $sm.mainmenu[i].has_subitems}
                                <ul class="secondary-nav active">
                                    {section name=j loop=$sm.mainmenu[i].items}
                                        <li><a href="{$sm.mainmenu[i].items[j].url}">{$sm.mainmenu[i].items[j].title}</a></li>
                                    {/section}
                                </ul>
                            {/if}
                        </li>
                    {/section}
                </ul>
            </div>
        </nav>
    </aside>
    <!-- End navigation-->

    {/if}
    <!-- Main content-->
    <section class="content" {if $userinfo.level eq 0}style="margin-left: 0px; margin-top:0px;"{/if}>
        {if $userinfo.level neq 0 }
        <!-- Header-->
        <nav class="navbar navbar-default">
                <div class="navbar-header">
                    <div id="mobile-menu">
                        <div class="toogle-button-wrapper">
                            <div class="left-nav-toggle-mobile" onclick="$('.navigation').removeClass('show-on-mobile');$('.tog-button-left .left-nav-toggle-mobile').remove();">
                                <a href="javascript:;">
                                    <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.4998 12.5V14.1667H1.49984V12.5H16.4998ZM4.4965 0.753357L5.67484 1.93169L3.02317 4.58336L5.67484 7.23502L4.4965 8.41336L0.666504 4.58336L4.4965 0.753357ZM16.4998 6.66669V8.33336H8.99984V6.66669H16.4998ZM16.4998 0.833357V2.50002H8.99984V0.833357H16.4998Z" fill="CurrentColor"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="flex-1">
                            <a href="{if $special.page.scheme neq ""}{$special.page.scheme}{else}http{/if}://{$special.resource_url}" class="navbar-brand">{$_settings.logo_text}</a>
                        </div>
                        <div class="header-menu-section-mobile"></div>
                    </div>
                </div>
                <div class="flex header-wrapper">
                    <div id="section_header"></div>
                    <div class="flex-1"></div>

                    <ul class="nav luna-nav header-settings-section">

                        <li class="profil-link">
                            <a href="#" class="top dropdown-toggle adminmenu" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <div>
                                        <span class="main-menu-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="35px" height="35px"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                        </span>
                                </div>
                            </a>
                            <ul class="dropdown-menu adminmenu" aria-labelledby="dropdownMenu1">
                                {section name=i loop=$sm.accountmenuactions}
                                    <li>
                                        <a href="{$sm.accountmenuactions[i].url}" {if $sm.accountmenuactions[i].selected} class="active"{/if}>
                                            {$sm.accountmenuactions[i].icon}
                                            <span class="main-text">{$sm.accountmenuactions[i].title}</span>
                                        </a>
                                    </li>
                                {/section}
                                <li>
                                    <a href="index.php?m=account&d=logout">
                                        <span class="main-text">Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </div>

        </nav>
        <!-- End header-->
        {/if}
        <div class="container-fluid">



            {include file="path.tpl"}


            {$special.document.panel[0].beforepanel}
            {assign var=loop_center_panel value=1}
            {assign var=show_center_panel value=1}
            {section name=mod_index loop=$modules step=1 start=1}
                {if $_settings.main_block_position lt $loop_center_panel and $show_center_panel eq 1}
                    {assign var=show_center_panel value=0}
                    {assign var=index value=0}
                    {assign var=mod_name value=$modules[0].module}
                    {$special.document.block[0].beforeblock}
                    {include file="$mod_name.tpl"}
                    {$special.document.block[0].afterblock}
                {/if}
                {if $modules[mod_index].panel eq "center"}
                    {assign var=index value=$smarty.section.mod_index.index}
                    {assign var=mod_name value=$modules[mod_index].module}
                    {$special.document.block[mod_index].beforeblock}
                    {include file="$mod_name.tpl"}
                    {$special.document.block[mod_index].afterblock}
                    {assign var=loop_center_panel value=$loop_center_panel+1}
                {/if}
            {/section}
            {if $show_center_panel eq 1}
                {assign var=show_center_panel value=0}
                {assign var=index value=0}
                {assign var=mod_name value=$modules[0].module}
                {$special.document.block[0].beforeblock}
                {include file="$mod_name.tpl"}
                {$special.document.block[0].afterblock}
            {/if}
            {$special.document.panel[0].afterpanel}


            {$special.document.panel[1].beforepanel}
            {section name=mod_index loop=$modules step=1}
                {if $modules[mod_index].panel eq "1"}
                    {assign var=index value=$smarty.section.mod_index.index}
                    {assign var=mod_name value=$modules[mod_index].module}
                    {$special.document.block[mod_index].beforeblock}
                    {include file="$mod_name.tpl"}
                    {$special.document.block[mod_index].afterblock}
                {/if}
            {/section}
            {$special.document.panel[1].afterpanel}


            {$special.document.panel[2].beforepanel}
            {section name=mod_index loop=$modules step=1}
                {if $modules[mod_index].panel eq "2"}
                    {assign var=index value=$smarty.section.mod_index.index}
                    {assign var=mod_name value=$modules[mod_index].module}
                    {$special.document.block[mod_index].beforeblock}
                    {include file="$mod_name.tpl"}
                    {$special.document.block[mod_index].afterblock}
                {/if}
            {/section}
            {$special.document.panel[2].afterpanel}

        </div>
    </section>
    <!-- End main content-->

</div>
<!-- End wrapper-->

<div id="tinymce_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="close-modal">
                <a href="javascript:;" onclick="closetinymcemodal()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></a>
            </div>
            <div class="tinymce_modal_content">
            </div>
        </div>
    </div>
</div>


<div id="openai_assistant_history_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="close-modal">
                <a href="javascript:;" onclick="closeopenaihistorymodal()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></a>
            </div>
            <div class="openai_assistant_history_modal_content">
            </div>
        </div>
    </div>
</div>

<div id="openai_assistant_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="close-modal">
                <a href="javascript:;" onclick="closeopenaimodal()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></a>
            </div>
            <div class="openai_assistant_modal_content">
            </div>
        </div>
    </div>
</div>

<!-- Vendor scripts -->

<script src="themes/{$special.theme}/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="themes/{$special.theme}/vendor/toastr/toastr.min.js"></script>
<script src="themes/{$special.theme}/vendor/sparkline/index.js"></script>
<script src="themes/{$special.theme}/vendor/flot/jquery.flot.min.js"></script>
<script src="themes/{$special.theme}/vendor/flot/jquery.flot.resize.min.js"></script>
<script src="themes/{$special.theme}/vendor/flot/jquery.flot.spline.js"></script>
<script type="text/javascript" src="themes/{$special.theme}/assets/js/required/jquery-ui-1.11.0.custom/jquery-ui.min.js"></script>

<script src="themes/{$special.theme}/vendor/niceselect/jquery.nice-select.js"></script>

<script>
    $(document).ready(function() {ldelim}
        
    {rdelim});
</script>


<!-- App scripts -->
<script src="themes/{$special.theme}/scripts/luna.js"></script>
<script src="themes/{$special.theme}/scripts/selectize.js"></script>

<script>
    $(document).ready(function() {ldelim}
        $('#tag_filter').niceSelect('destroy');
        $('#js-tags-selector').niceSelect('destroy');
        $('#js-tags-selector').selectize({ldelim}
            plugins: ['remove_button'],
            create: true
        {rdelim});
    {rdelim});
</script>

<script>
    function alertSuccessMessage(message) {ldelim}
        alertify.success(message);
    {rdelim}

    $(function() {ldelim}
        headermenu = $('.header-wrapper').html();
        togglebutton = $('.toogle-button-wrapper').html();
        $('.header-menu-section-mobile').html(headermenu);
        $('.header-menu-section-mobile #navbar').remove();
        $('.header-menu-section-mobile .account-limits-section').remove();
        $('.left-nav-toggle-mobile').click(function() {ldelim}
            $('.navigation').addClass('show-on-mobile');
            $('.tog-button-left').append(togglebutton);
        {rdelim});
    {rdelim});
</script>

{* AI Assistant - JavaScript loaded at bottom after jQuery *}
{if $userinfo.level neq 0}
<script type="text/javascript" src="themes/{$special.theme}/aiassistant.js"></script>
{/if}

{include file="page_footer.tpl"}
