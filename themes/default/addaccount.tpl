
<form action="{$data.action}" method="post" enctype="multipart/form-data" class="add_ent_account_form">
    <input type="hidden" name="id_error" value="{$data.id_error}">
    <input type="hidden" name="account_id" id="account_id" value="{$data.id}">
    <input type="hidden" name="category" id="category" value="{$data.category}">

    <div class="row">
        <div class="col-md-12">
            <h1><span id="action">Add</span> Account</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div><label>Name<sup class="adminform-required">*</sup></label></div>
            <input class="form-control" type="text" name="name" value="{$data.name}" id="image_search_text">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div id="main_image">
                <div class="flex">
                    <div>
                        <INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="{$_settings.max_upload_filesize}">
                        <input type="file" name="userfile" id="userfile">
                    </div>
                    <div class="flex-1"></div>
                    <div class="btn-group" role="group"><button type="button" class="ad-btn mb-10 pull-right" id="search_images">Search Image</button></div>
                </div>
                <label class="selected-image-l" style="display:none" >Search Result</label><div id="image_search_results"></div>

                <div class="imagepreview">
                    <div class="image" id="imagepreview" style="text-align: left">
                        {if $data.image neq ""}
                            <img src="{$data.image}" />
                            <a href="javascript:;" class="edit-article-buttons" onclick="removeImage({$data.id})">Remove Image</a>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div><label>Birth Sign</label></div>
            <input class="form-control" type="text" name="birth_sign" value="{$data.birth_sign}" id="birth_sign">
        </div>
        <div class="col-md-6">
            <div><label>Date Of Birth</label></div>
            <input class="form-control" type="text" name="date_of_birth" value="{$data.date_of_birth}" id="date_of_birth">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div><label>Height</label></div>
            <input class="form-control" type="text" name="height" value="{$data.height}" id="birth_sign">
        </div>
        <div class="col-md-6">
            <div><label>Instagram</label></div>
            <input class="form-control" type="text" name="instagram" value="{$data.instagram}" id="instagram">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div><label>Facebook</label></div>
            <input class="form-control" type="text" name="facebook" value="{$data.facebook}" id="facebook">
        </div>
        <div class="col-md-6">
            <div><label>Twitter</label></div>
            <input class="form-control" type="text" name="twitter" value="{$data.twitter}" id="twitter">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div><label>Description</label></div>
            <textarea class="form-control" name="description" id="description" rows="10">{$data.description}</textarea>
        </div>
    </div>
    <div class="ai-generation">
        <a href="javascript:;" class="flex gap-10 pull-right" onclick="GenerateAccountDescriptionWithAI({$data.id})">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg> GenerateWith AI
        </a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="add_ent_account_form_savebutton">
                <input type="submit" value="Save">
                <div id="form-messages"></div>
            </div>
        </div>
    </div>
</form>


<script>

    $(function() {ldelim}
        var form = $('.add_ent_account_form');

        $(form).submit(function(event) {ldelim}
            event.preventDefault();

            var formMessages = $('#form-messages');
            var formData = new FormData(form[0]);
            $('.add_ent_account_form_savebutton').prop('disabled', true);
            $.ajax({ldelim}
                type: 'POST',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                url: $(form).attr('action'),
                data: formData
                {rdelim})

                .done(function(response) {ldelim}
                    var response = JSON.parse(decodeURIComponent(response));
                    if(response.status === "success")
                    {ldelim}
                        $(formMessages).removeClass('error');
                        $(formMessages).html('');
                        closemodal();
                    {rdelim}
                    else if(response.status === 'error')
                    {ldelim}
                        $(formMessages).removeClass('success');
                        $(formMessages).addClass('error');
                        $(formMessages).text(response.message);
                        $(formMessages).show();
                        $('label').removeClass('error');
                        $('.form-control').removeClass('error');
                        $('#' + response.field_id).parent().find('label').addClass('error');
                        $('.add_ent_account_form_savebutton').prop('disabled', false);
                        {rdelim}
                    {rdelim})
                .fail(function(data) {ldelim}
                    $(formMessages).removeClass('success');
                    $(formMessages).addClass('error');

                    // Set the message text.
                    if (data.responseText !== '')
                        $(formMessages).text(data.responseText);
                    else
                        $(formMessages).text('Oops! An error occurred and your request could not be sent.');
                    {rdelim});
            {rdelim});
        {rdelim});


    $(document).ready(function() {ldelim}
        {if $data.mode eq "edit"}
            $('#action').html('Edit ');
        {/if}

    {rdelim});



</script>

<style>
    sup{ldelim}
        top:-4px
    {rdelim}
</style>