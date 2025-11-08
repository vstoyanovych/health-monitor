<?php /* Smarty version 2.6.26, created on 2025-08-04 00:17:36
         compiled from aisocialsharebutton.tpl */ ?>
<h3>Social Content</h3>
<div class="row">
    <div class="col-md-12">
        <div class="social-share-buttons-wrapper">
            <a href="javascript:;" onclick="ShareWindow(<?php echo $this->_tpl_vars['data']['id']; ?>
, 'facebook')" class="share-window-button"><i class="fa fa-facebook"></i> Facebook</a>
            <a href="javascript:;" onclick="ShareWindow(<?php echo $this->_tpl_vars['data']['id']; ?>
, 'twitter')" class="share-window-button"><i class="fa fa-twitter"></i> Twitter</a>
            <a href="javascript:;" onclick="ShareWindow(<?php echo $this->_tpl_vars['data']['id']; ?>
, 'pinterest')" class="share-window-button"><i class="fa fa-pinterest"></i> Pinterest</a>
            <a href="javascript:;" onclick="ShareWindow(<?php echo $this->_tpl_vars['data']['id']; ?>
, 'reddit')" class="share-window-button"><i class="fa fa-reddit"></i> Reddit</a>
            <a href="javascript:;" onclick="ShareWindow(<?php echo $this->_tpl_vars['data']['id']; ?>
, 'bsky')" class="share-window-button"> BlueSky</a>
        </div>
        <div id="sharingPreloader"></div>
    </div>
</div>

<script src="ext/notifiers/alertify/lib/alertify.min.js"></script>
<script>
    function ShareWindow(id, platform){
        $('#sharingPreloader').html('');
        $('#sharingPreloader').load('index.php?m=ai&d=sharecontent&id=' + id + '&platform=' + platform + '&theonepage=1', function (){

        });
    }

    function ShareOnTwitter(text, url){
        $.get('index.php?m=ai&d=shareontwitter&url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(text));
        var formMessages = $('.error-messages');
        $(formMessages).addClass('success');
        $(formMessages).addClass('aui-message aui-message-success');
        $(formMessages).text('Posted on Twitter');
        $('#twitterShare').hide();
    }

    function ShareOnFacebook(id){
        var formMessages = $('.error-messages');
        var text = $('#socialcontent').val();

        if (text === undefined || text == '')
            {
                $(formMessages).removeClass('success');
                $(formMessages).addClass('aui-message aui-message-error');
                $(formMessages).text('Fill required field');
            }
        else
            {
                $.get('index.php?m=ai&d=shareonfacebook&theonepage=1&id=' + id + '&text=' + encodeURIComponent(text), function (result){
                    $(formMessages).addClass('success');
                    $(formMessages).addClass('aui-message aui-message-success');
                    $(formMessages).text('Posted on Facebook');
                    $('#facebookShare').hide();
                });
            }
    }
</script>
