<div class="row">
    <div class="col-md-12">
        <div class="error-messages"></div>
        <textarea id="socialcontent" name="socialcontent" rows="4" class="form-control">{$data.content}</textarea>

        <div class="social-share-buttons-wrapper">
            {if $data.platform eq "facebook"}
                <button onclick="share.fb('{$data.url}')" class="simple-button large inverse"><i class="fa fa-facebook"></i> Share on Facebook</button>
            {/if}
            {if $data.platform eq "twitter"}
                <button id="twitterShare" onclick="share.tw('{$data.content_for_sharring}', '{$data.url}')" class="simple-button large inverse"><i class="fa fa-twitter"></i> Share on Twitter</button>
            {/if}
            {if $data.platform eq "pinterest"}
                <button onclick="share.pin('{$data.content_for_sharring}', '{$data.media}', '{$data.url_pinterest}')" class="simple-button large inverse" count-layout="horizontal"><i class="fa fa-pinterest"></i> Pinterest</button>
            {/if}
            {if $data.platform eq "reddit"}
                <button onclick="share.reddit('{$data.content_for_sharring}', '{$data.url}')" class="simple-button large inverse" count-layout="horizontal"><i class="fa fa-reddit"></i> <span>Reddit</span></button>
            {/if}
            {if $data.platform eq "bsky"}
                <button onclick="share.bsky('{$data.content_for_sharring}', '{$data.url}')" class="simple-button large inverse" count-layout="horizontal"> <span>BlueSky</span></button>
            {/if}
        </div>
    </div>
</div>


