function closemodal() {
    location.reload();
}
function closeassignmodal() {
    $('#tinymce_modal').removeClass('showWindow');
    $('.tinymce_modal_content').html('');
    $('#assign_company_shadow').remove();
    $('#add_customer_modal').css('overflow-y', 'auto');
}
function addaccount(title = '') {
    if (title === '')
        var url = 'index.php?m=accounts&d=add&theonepage=1'
    else
        var url = 'index.php?m=accounts&d=add&title=' + encodeURIComponent(title) + '&theonepage=1'

    $('.tinymce_modal_content').html('');
    $('.tinymce_modal_content').load(url);
    $('#tinymce_modal').addClass('showWindow');
    $('#tinymce_modal').after('<div id="assign_company_shadow"></div>');
    $('#add_customer_modal').css('overflow-y', 'hidden');
}

function editaccount( account ) {
    $('.tinymce_modal').html('');
    $('.tinymce_modal_content').load('index.php?m=accounts&d=add&id=' + account + '&theonepage=1');
    $('#tinymce_modal').addClass('showWindow');
    $('#tinymce_modal').after('<div id="assign_company_shadow"></div>');
    $('#add_customer_modal').css('overflow-y', 'hidden');
}
function removeImage(id) {
    $.get('index.php?m=accounts&d=removeimage&theonepage=1&id='+id, {});
    $('#imagepreview').html('');
}
function GenerateAccountDescriptionWithAI(id)
    {
        $.get('index.php?m=accounts&d=generateaccountinfo&theonepage=1&id='+id+'&name='+$('#image_search_text').val(), function(data){
            var response = JSON.parse(decodeURIComponent(data));
            if (response.status === 'success')
                {
                    $('#description').val(response.data['description'])
                    $('#date_of_birth').val(response.data['date_of_birth'])
                    $('#birth_sign').val(response.data['birth_sign'])
                    $('#height').val(response.data['height'])
                    $('#category').val(response.data['category'])
                    $('#facebook').val(response.data['facebook'])
                    $('#twitter').val(response.data['twitter'])
                    $('#instagram').val(response.data['instagram'])
                }

        });
    }