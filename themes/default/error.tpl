{if $errorname eq "banerror"}
<center>
<b>Error</b><br>
You are disallowed to view this site.
</center>
{/if}

{if $errorname eq "noterasedinstall"}
<center>
<b>Error</b><br>
Please erase directories <b>install</b>, <b>upgrade</b> and file <b>includes/update.php</b> from the CMS directory.
{/if}