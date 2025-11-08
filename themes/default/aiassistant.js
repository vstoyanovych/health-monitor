function closeopenaimodal() {
    $('#openai_assistant_modal').removeClass('showWindow');
    $('.openai_assistant_modal_content').html('');
    $('#assign_company_shadow').remove();
    $('#openai_assistant_modal_shadow').remove();
    $('body').removeClass('modal-open');
}

function ArticleAIAssistant(id, id_block)
{
    $('.openai_assistant_modal_content').html('');
    $('.openai_assistant_modal_content').load('index.php?m=article&d=promptshistory&id=' + id + '&id_block=' + id_block + '&theonepage=1');
    $('#openai_assistant_modal').addClass('showWindow');
    $('#openai_assistant_modal').after('<div id="assign_company_shadow"></div>');
    $('#add_customer_modal').css('overflow-y', 'hidden');
}

function ExecuteCustomPrompt()
{
    var prompt = $('#image-prompt').val();
    var article = $('#article').val();
    var block = $('#block').val();
    var text = $('#text').val();

    if (prompt === '')
        $('.ai-form .input').html('<span class="error-message">Error: Prompt cannot be empty.</span>');
    else
    {
        $('#createButton').hide();
        $('.ai-form .input').html('<span class="loader"></span> Loading...');
        $.ajax({
            type: 'POST',
            url: 'index.php?m=ai&d=executecustomprompt&theonepage=1',
            data: {
                'message': prompt,
                'article': article,
                'text': text,
                'block': block
            },
        })
            .done(function(response) {
                if (isJSON(response))
                {
                    content = JSON.parse(response);

                    $('.ai-form .input').html('' +
                        '<div><div class="itme-wrapper  outgoing" id="item_'+ content.prompt.id +'"><span>'+ content.prompt.text +'</span></div></div>' +
                        '<div><div class="itme-wrapper incoming" id="item_'+ content.response.id +'"><span>'
                        + content.response.text +
                        '</span></div>' +
                        '<div class="content-management-buttons incoming"><div class="wrapper pull-right"><div class="flex">' +
                        '<a href="javascript:;" onclick="saveCustomPromptResults('+ content.response.id +',' + block + ')" title="Save Results"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="26" height="26" stroke-width="1" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9"></path></svg></a>' +
                        '</div></div></div></div>'
                    );
                    $('.ai-form .input').addClass('history');
                    $('.history').removeClass('input');
                    $('.ai-form').append('<div class="input"></div>');
                }
                else
                {
                    $('#loader').remove();
                    $('.ai_modal_content').html('<div className="error-message">Something Went Wrong</div>');
                }
                $('#createButton').show();
                $('#image-prompt').val('');
            });
    }
}

function saveCustomPromptResults(id_log, block)
{
    $.get('index.php?m=ai&d=useresultsmodal&id_log=' + id_log + '&theonepage=1', function (results) {
        var wrapperId = 'article_block_' + block;
        var editor = getEditorByWrapperId(wrapperId);

        if (editor)
            editor.execCommand('mceInsertContent', false, results);
    });

    closeopenaimodal();
}

function getEditorByWrapperId(wrapperId) {
    var wrapper = $('#' + wrapperId);
    var textarea = wrapper.find('textarea').attr('id');

    if (textarea) {
        return tinymce.get(textarea); // Get the editor instance by textarea ID
    }
    return null;
}











function SubmitToGPT()
{
    var id = $('#template_id').val();
    var id_sequence = $('#sequence_id').val();
    var id_temp = $('#temp_id').val();
    $('.adminform_form').hide();
    $('.generator-header-buttons').hide();
    $('.ai-form .input').html('<span class="loader"></span> Loading...');
    $('.adminform_savebutton input').prop('disabled', true);

    $.ajax({
        type: 'POST',
        url: 'index.php?m=ai&d=generatecontent&id=' + id + '&id_sequence=' + id_sequence + '&id_temp=' + id_temp + '&theonepage=1',
        data: $('.adminform_form').serialize(),
    })
    .done(function(response) {
        message = response.replace(/\n/g,"<br>");
        $('.ai-form .input').html(response.replace(/\n/g,"<br>"));
        $('.adminform_form').show();
        $('.generator-header-buttons').show();
        $('.adminform_savebutton input').prop('disabled', false);
        if (id_sequence == 0)
            $('.content-management-buttons').removeClass('hidden')
        else
            CheckSequenceProgress(id_sequence, id_temp);
    });
}
function GenerateImage()
{
    var id_tmp = $('#temp').val();
    var prompt = $('#image-prompt').val();
    var imageSize = $('#imageSize').val();

    if (prompt === '')
        $('.ai-form .input').html('<span class="error-message">Error: Prompt cannot be empty.</span>');
    else
        {
            $('#createButton').hide();
            $('.ai-form .input').html('<span class="loader"></span> Loading...');
            $.ajax({
                type: 'POST',
                url: 'index.php?m=ai&d=generateimage&theonepage=1',
                data: {
                    'message': prompt,
                    'size': imageSize,
                    'temp': id_tmp,
                },
            })
            .done(function(response) {
                if (isJSON(response))
                    {
                        content = JSON.parse(response);
                        if (content.image !== '')
                            {
                                $('.ai-form .input').html('' +
                                    '<div class="itme-wrapper incoming" id="item_'+ content.id +'"><div class="image-wrapper">' +
                                    '<img src="' + content.image + '">' +
                                    '</div>' +
                                    '<div class="content-management-buttons"><div class="wrapper pull-right"><div class="flex">' +
                                    '<a href="javascript:;" onclick="saveImageResults('+ content.id +')" title="Save Results"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="26" height="26" stroke-width="1" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9"></path></svg></a>' +
                                    '</div></div></div></div>' +
                                    '<div class="itme-wrapper  outgoing" id="item_'+ content.id +'"><span>'+ prompt +'</span></div>');
                                $('.ai-form .input').addClass('history');
                                $('.history').removeClass('ai-form input');
                                $('.help-info').after('<div class="ai-form input"></div>');
                            }
                    }
                else
                    {
                        $('#loader').remove();
                        $('.ai_modal_content').html('<div className="error-message">Something Went Wrong</div>');
                    }
                $('#createButton').show();
                $('#image-prompt').val('');
            });
        }
}

function CheckSequenceProgress(id_sequence, id_temp) {
    $('.ai-form .input').html('<span class="loader"></span> We are now processing your prompts. This process may take a few minutes as we ensure the highest quality of our results. We appreciate your patience. All generated content will be available in the Saved Content section.');
    $('.contentloader').html('');
    $('.generator-header-buttons').hide();
    var requestURL = 'index.php?m=ai&d=checksequence&id=' + id_sequence + '&id_temp=' + id_temp + '&theonepage=1';
    var interval = setInterval(function() {
        $.ajax({
            url: requestURL,
            type: 'GET',
            success: function(response) {
                if (response === "success") {
                    location.reload();
                    clearInterval(interval);
                }
            },
            error: function(xhr, status, error) {
                console.log("An error occurred: " + error);
            }
        });
    }, 10000);
}


function LoadBuyerPersonaData(id, id_template, id_sequence)
{
    closetinymcemodal();
    $('.contentloader').html('');
    $('.contentloader').load('index.php?m=marketingsettings&d=edit&id='+ id +'&id_template=' + id_template + '&id_sequence=' + id_sequence + '&theonepage=1', function (results) {
        $('#saveButton').addClass('hidden');
        $('#createButton').removeClass('hidden');
        $('#admintablerow-title').remove();
        $('.adminform_form').attr('action', '');
        $('.adminform_savebutton input').val('Generate Content');
        $('#id_product').niceSelect();
        $('.adminform_form').submit (function(event) {
            event.preventDefault();

            var isValid = true;

            $(".adminform_form input").each(function() {
                if ($(this).val() === "")
                    {
                        isValid = false;
                        $(this).css("border", "1px solid red");
                    }
                else
                    {
                        $(this).css("border", "");
                    }
            });

            if (isValid)
                SubmitToGPT();
        });
    });
}
function saveForm()
{
    $('.tinymce_modal_content').html('');
    $('.tinymce_modal_content').load('index.php?m=marketingsettings&d=addmodal&theonepage=1', function (){
        $('.addBuyerTitleForm').submit (function(event) {
            event.preventDefault();
            var formMessages = $('#form-messages');
            $('#submitbutton').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'index.php?m=marketingsettings&d=postadd&theonepage=1',
                data: $('.addBuyerTitleForm, .addBuyerForm').serialize(),
            })
                .done(function(response) {
                    if(response.includes("success"))
                        closetinymcemodal();
                    else
                    {
                        $(formMessages).removeClass('success');
                        $(formMessages).addClass('error');
                        $(formMessages).text(response);
                        $('#submitbutton').prop('disabled', false);
                    }
                })
        });
    });
    $('#tinymce_modal').addClass('showWindow');
    $('#tinymce_modal').after('<div id="assign_company_shadow"></div>');
    $('#add_customer_modal').css('overflow-y', 'hidden');
}

function copyContentResults()
{
    var textToCopy = $('.ai-form .input').html();
    textToCopy = textToCopy.replace(/<br ?\/?>/g, "\n");
    var tempInput = $("<textarea>");
    $("body").append(tempInput);
    tempInput.val(textToCopy).select();
    document.execCommand("copy");
    tempInput.remove();
    alertify.set({ delay: 7000 });
    alertify.success('Text copied to clipboard');
}
function createEmailCampaign(id)
    {
        $('.ai_modal_content').html('');
        $('#ai_modal').addClass('showWindow');
        $('#ai_modal .ai_modal_content').html('<div id="loader"><div class="loader"></div> Loading...</div>');

        $('.ai_modal_content').load('index.php?m=ai&d=createemailcampaign&id='+id+'&theonepage=1', function(){
            $('#loader').remove();
        });

        $('#ai_modal').after('<div id="assign_company_shadow"></div>');
        $('#add_customer_modal').css('overflow-y', 'hidden');
    }
function createSMSCampaign(id)
    {
        $('.ai_modal_content').html('');
        $('#ai_modal').addClass('showWindow');
        $('#ai_modal .ai_modal_content').html('<div id="loader"><div class="loader"></div> Loading...</div>');

        $('.ai_modal_content').load('index.php?m=ai&d=createemailcampaign&id='+id+'&type=sms&theonepage=1', function(){
            $('#loader').remove();
        });

        $('#ai_modal').after('<div id="assign_company_shadow"></div>');
        $('#add_customer_modal').css('overflow-y', 'hidden');
    }

function isJSON(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function RegenerateSocialContent(id, platform)
    {
        if (platform === 'instagram')
            {
                $('#socialcontent').val('');
                $('.regenerate-content').hide();
                $('#socialcontent').after('<div id="loader" style="float: right;top: -40px;position: relative;right: 10px;"><span class="loader"></span> Loading...</div>');

                $('.ai_modal_content').load('index.php?m=ai&d=createsocialcontent&id='+id+'&platform=' + platform + '&theonepage=1', function (){
                    $('#socialcontent').after('<div class="regenerate-content"><a href="javascript:;" onclick="RegenerateSocialContent('+ id +',\''+ platform +'\');"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg></a></div>');
                });
            }
        else
            {
                $('#message').val('');
                $('.regenerate-content').hide();
                $('#message').after('<div id="loader" style="float: right;top: -40px;position: relative;right: 10px;"><span class="loader"></span> Loading...</div>');

                $.get('index.php?m=ai&d=createsocialcontent&id='+id+'&platform=' + platform + '&theonepage=1', function(response){
                    if (isJSON(response))
                        {
                            content = JSON.parse(decodeURIComponent(response));
                            $('#loader').remove();
                            $('.regenerate-content').show();
                            $('#message').val(content.content);
                        }
                    else
                        {
                            $('#loader').remove();
                            $('.ai_modal_content').html('<div className="error-message">Something Went Wrong</div>');
                        }
                });
            }
    }
function createSocialContent(id, platform)
    {
        $('.ai_modal_content').html('');
        $('#ai_modal').addClass('showWindow');
        $('#ai_modal .ai_modal_content').html('<div id="loader"><div class="loader"></div> Loading...</div>');

        if (platform === 'instagram')
            {
                $('.ai_modal_content').load('index.php?m=ai&d=createsocialcontent&id='+id+'&platform=' + platform + '&theonepage=1', function (){
                    $('#socialcontent').after('<div class="regenerate-content"><a href="javascript:;" onclick="RegenerateSocialContent('+ id +',\''+ platform +'\');"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg></a></div>');
                });
            }
        else {
            $.get('index.php?m=ai&d=createsocialcontent&id='+id+'&platform=' + platform + '&theonepage=1', function(response){
                if (isJSON(response))
                {
                    content = JSON.parse(decodeURIComponent(response));
                    $('.ai_modal_content').load(content.url + '&returnto=index.php?m=marketingcontent', function(data){
                        $('#message').val(content.content);
                        $('#message').after('<div class="regenerate-content"><a href="javascript:;" onclick="RegenerateSocialContent('+ id +',\''+ platform +'\');"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg></a></div>');
                        if (content.image !== '')
                            InsertImage(content.image, content.path);
                    });
                }
                else {
                    $('#loader').remove();
                    $('.ai_modal_content').html('<div className="error-message">Something Went Wrong</div>');
                }
            });
        }

        $('#ai_modal').after('<div id="assign_company_shadow"></div>');
        $('#add_customer_modal').css('overflow-y', 'hidden');
    }
function saveContentResults()
{
    $('.tinymce_modal_content').html('');
    $('.tinymce_modal_content').load('index.php?m=marketingsettings&d=saveresultsmodal&theonepage=1', function (){
        $('.addContentTitleForm').submit (function(event) {
            event.preventDefault();
            var formMessages = $('#form-messages');
            $('#submitbutton').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: 'index.php?m=marketingsettings&d=saveresults&theonepage=1',
                data: {
                    title: $('.addContentTitleForm #title').val(),
                    text: $('.ai-form .input').html()
                },
            })
            .done(function(response) {
                if(response.includes("success"))
                {
                    alertify.set({ delay: 7000 });
                    alertify.success('Content Saved');
                    closetinymcemodal();
                }
                else
                {
                    $(formMessages).removeClass('success');
                    $(formMessages).addClass('error');
                    $(formMessages).text(response);
                    $('#submitbutton').prop('disabled', false);
                }
            })
        });
    });
    $('#tinymce_modal').addClass('showWindow');
    $('#tinymce_modal').after('<div id="assign_company_shadow"></div>');
    $('#add_customer_modal').css('overflow-y', 'hidden');
}

function saveCustomPromptTemplate(id_log)
    {
        $('.tinymce_modal_content').html('');
        $('.tinymce_modal_content').load('index.php?m=marketingtemplates&d=addtemplate&id_log=' + id_log + '&theonepage=1', function (){
            $('.addBuyerTitleForm').submit (function(event) {
                event.preventDefault();
                var formMessages = $('#form-messages');
                var form = $('.addBuyerTitleForm');
                var formData = new FormData(form[0]);

                $('.adminform_savebutton input').prop('disabled', true);
                $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    url: 'index.php?m=marketingtemplates&d=postaddtemplate&theonepage=1',
                    data: formData
                })
                    .done(function(response) {
                        if(response.includes("success"))
                            closetinymcemodal();
                        else
                            {
                                $(formMessages).removeClass('success');
                                $(formMessages).addClass('error');
                                $(formMessages).text(response);
                                $('.adminform_savebutton input').prop('disabled', false);
                            }
                    })
            });
        });
        $('#tinymce_modal').addClass('showWindow');
        $('#tinymce_modal').after('<div id="assign_company_shadow"></div>');
        $('#add_customer_modal').css('overflow-y', 'hidden');
    }

function ThrowError(error){
    $('#form-messages').html('');
    $('#form-messages').html(error);
    $('#form-messages').show();
}

function ResetErrors(){
    $('#form-messages').html('');
    $('#form-messages').hide();
}
