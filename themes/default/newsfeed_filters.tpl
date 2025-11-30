<div class="dropdown dropdown-select-styled">
    <a data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="javascript:;">
        {if $data.active_tab neq ""}{$data.active_tab}{else}All{/if}
        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683416 -0.097631 1.31658 -0.097631 1.7071 0.292893L4.99999 3.58579L8.29288 0.292893C8.6834 -0.0976311 9.31657 -0.0976311 9.70709 0.292893C10.0976 0.683417 10.0976 1.31658 9.70709 1.70711L5.7071 5.70711C5.31657 6.09763 4.68341 6.09763 4.29289 5.70711L0.292893 1.70711C-0.0976309 1.31658 -0.0976309 0.683417 0.292893 0.292893Z" fill="#374151"/>
        </svg>
    </a>
    <ul class="dropdown-menu min-w-max absolute text-sm text-slate-700 dark:text-white bg-white dark:bg-slate-700 shadow z-[2] float-left overflow list-none text-left rounded-lg mt-2 left-0 m-0 bg-clip-padding border-none">
        {section name=i loop=$data.options}
            <li {if $data.options[i].selected} class="active"{/if}>
                <a href="{$data.options[i].url}" title="{$data.options[i].title}">
                    {$data.options[i].title}
                </a>
            </li>
        {/section}
    </ul>
</div>