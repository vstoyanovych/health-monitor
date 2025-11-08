/**
 * LUNA - Responsive Admin Theme
 *
 */

function topupballance(){
    $('.tinymce_modal_content').html('');
    $('.tinymce_modal_content').load('index.php?m=balance&theonepage=1');
    $('#tinymce_modal').addClass('showWindow');
    $('#tinymce_modal').after('<div id="assign_company_shadow"></div>');
    $('#add_customer_modal').css('overflow-y', 'hidden');
}
function viewballance(){
    $('.tinymce_modal_content').html('');
    $('.tinymce_modal_content').load('index.php?m=balance&d=view&theonepage=1');
    $('#tinymce_modal').addClass('showWindow');
    $('#tinymce_modal').after('<div id="assign_company_shadow"></div>');
    $('#add_customer_modal').css('overflow-y', 'hidden');
}

function closetinymcemodal() {
    $('#tinymce_modal').removeClass('showWindow import-modal');
    $('.tinymce_modal_content').html('');
    $('#assign_company_shadow').remove();
    $('#add_customer_modal').css('overflow-y', 'auto');
}

function switchFeatured(id, url){
    $.get( url + '&theonepage=1', function(data){
        $('#content_item_' + id + ' .featured_content i').removeClass('fa-star')
        $('#content_item_' + id + '.featured_content i').removeClass('fa-star-o')
        if (data === '1' )
            $('#content_item_' + id + '.featured_content i').addClass('fa-star')
        else if (data === '0' )
            $('#content_item_' + id + '.featured_content i').addClass('fa-star-o')
    })
}

$(document).ready(function () {

    $('#section_header').html($('#block0title').html());


    // Handle minimalize left menu
    $('.left-nav-toggle a').on('click', function(event){
        event.preventDefault();
        $("body").toggleClass("nav-toggle");
        $.get('index.php?m=settings&d=togglesidebar')
    });

    // Hide all open sub nav menu list
    $('.nav-second').on('show.bs.collapse', function () {
        $('.nav-second.in').collapse('hide');
    });

    // Handle panel toggle
    $('.panel-toggle').on('click', function(event){
        event.preventDefault();
        var hpanel = $(event.target).closest('div.panel');
        var icon = $(event.target).closest('i');
        var body = hpanel.find('div.panel-body');
        var footer = hpanel.find('div.panel-footer');
        body.slideToggle(300);
        footer.slideToggle(200);

        // Toggle icon from up to down
        icon.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        hpanel.toggleClass('').toggleClass('panel-collapse');
        setTimeout(function () {
            hpanel.resize();
            hpanel.find('[id^=map-]').resize();
        }, 50);
    });

    // Handle panel close
    $('.panel-close').on('click', function(event){
        event.preventDefault();
        var hpanel = $(event.target).closest('div.panel');
        hpanel.remove();
    });
});