function importVideo(playlistID) {
    $('.tinymce_modal_content').html('');
    $('.tinymce_modal_content').load('index.php?m=playlists&d=importvideo&id=' + playlistID + '&theonepage=1');
    $('#tinymce_modal').addClass('showWindow');
    $('#tinymce_modal').after('<div id="assign_company_shadow"></div>');
    $('#add_customer_modal').css('overflow-y', 'hidden');
}
function toggelStatus(id) {
    $.get('index.php?m=playlists&d=toggle_status&id=' + id + '&theonepage=1', function (data) {
        if (data == 1) {
            $('#toggelStatus_'+ id).html('<i class="fa fa-toggle-on" style="font-size: 28px; color: darkgreen"></i>');
        } else {
            $('#toggelStatus_' + id).html('<i class="fa fa-toggle-off" style="font-size: 28px; color: #ccc"></i>');
        }
    });
}

function toggelFeatured(id) {
    $.get('index.php?m=playlists&d=toggle_featured&id=' + id + '&theonepage=1', function (data) {
        if (data == 1) {
            $('#toggelFeatured_'+ id).html('<i class="fa fa-toggle-on" style="font-size: 28px; color: darkgreen"></i>');
        } else {
            $('#toggelFeatured_' + id).html('<i class="fa fa-toggle-off" style="font-size: 28px; color: #ccc"></i>');
        }
    });
}
function toggelResourceStatus(id) {
    $.get('index.php?m=importresources&d=toggle_status&id=' + id + '&theonepage=1', function (data) {
        if (data == 1) {
            $('#toggelStatus_'+ id).html('<i class="fa fa-toggle-on" style="font-size: 28px; color: darkgreen"></i>');
        } else {
            $('#toggelStatus_' + id).html('<i class="fa fa-toggle-off" style="font-size: 28px; color: #ccc"></i>');
        }
    });
}
