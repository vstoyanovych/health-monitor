function closeopenaimodal() {
    $('#openai_assistant_modal').removeClass('showWindow');
    $('.openai_assistant_modal_content').html('');
    $('#assign_company_shadow').remove();
    $('#openai_assistant_modal_shadow').remove();
    $('body').removeClass('modal-open');
}


function socialMediaPost(id, platform)
{
    $('.openai_assistant_modal_content').html('');
    $('#openai_assistant_modal').addClass('showWindow');
    $('#openai_assistant_modal .openai_assistant_modal_content').html('<div id="loader"><div class="loader"></div> Loading...</div>');

    $('.openai_assistant_modal_content').load('index.php?m=ai&d=socialmediapost&id='+id+'&platform=' + platform + '&theonepage=1', function(response){});

    $('#openai_assistant_modal').after('<div id="assign_company_shadow"></div>');
    $('#add_customer_modal').css('overflow-y', 'hidden');
}