<h3>Social Content</h3>
<div class="row">
    <div class="col-md-12">
        <div class="social-share-buttons-wrapper">
            <a href="javascript:;" onclick="ShareWindow({$data.id}, 'facebook')" class="share-window-button"><i class="fa fa-facebook"></i> Facebook</a>
            <a href="javascript:;" onclick="ShareWindow({$data.id}, 'twitter')" class="share-window-button"><i class="fa fa-twitter"></i> Twitter</a>
            <a href="javascript:;" onclick="ShareWindow({$data.id}, 'pinterest')" class="share-window-button"><i class="fa fa-pinterest"></i> Pinterest</a>
            <a href="javascript:;" onclick="ShareWindow({$data.id}, 'reddit')" class="share-window-button"><i class="fa fa-reddit"></i> Reddit</a>
            <a href="javascript:;" onclick="ShareWindow({$data.id}, 'bsky')" class="share-window-button"> BlueSky</a>
        </div>
        <div id="sharingPreloader"></div>
    </div>
</div>

<script src="ext/notifiers/alertify/lib/alertify.min.js"></script>
<script>
    function ShareWindow(id, platform){ldelim}
        $('#sharingPreloader').html('');
        $('#sharingPreloader').load('index.php?m=ai&d=sharecontent&id=' + id + '&platform=' + platform + '&theonepage=1', function (){ldelim}

        {rdelim});
    {rdelim}

    function ShareOnTwitter(text, url){ldelim}
        $.get('index.php?m=ai&d=shareontwitter&url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(text));
        var formMessages = $('.error-messages');
        $(formMessages).addClass('success');
        $(formMessages).addClass('aui-message aui-message-success');
        $(formMessages).text('Posted on Twitter');
        $('#twitterShare').hide();
    {rdelim}

    function ShareOnFacebook(id){ldelim}
        var formMessages = $('.error-messages');
        var text = $('#socialcontent').val();

        if (text === undefined || text == '')
            {ldelim}
                $(formMessages).removeClass('success');
                $(formMessages).addClass('aui-message aui-message-error');
                $(formMessages).text('Fill required field');
            {rdelim}
        else
            {ldelim}
                $.get('index.php?m=ai&d=shareonfacebook&theonepage=1&id=' + id + '&text=' + encodeURIComponent(text), function (result){ldelim}
                    $(formMessages).addClass('success');
                    $(formMessages).addClass('aui-message aui-message-success');
                    $(formMessages).text('Posted on Facebook');
                    $('#facebookShare').hide();
                {rdelim});
            {rdelim}
    {rdelim}
</script>

