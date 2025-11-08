<?php /* Smarty version 2.6.26, created on 2024-10-13 03:59:46
         compiled from aisocialshare.tpl */ ?>
<div class="row">
    <div class="col-md-12">
        <div class="error-messages"></div>
        <textarea id="socialcontent" name="socialcontent" rows="4" class="form-control"><?php echo $this->_tpl_vars['data']['content']; ?>
</textarea>

        <div class="social-share-buttons-wrapper">
            <?php if ($this->_tpl_vars['data']['platform'] == 'facebook'): ?>
                <button onclick="share.fb('<?php echo $this->_tpl_vars['data']['url']; ?>
')" class="simple-button large inverse"><i class="fa fa-facebook"></i> Share on Facebook</button>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['data']['platform'] == 'twitter'): ?>
                <button id="twitterShare" onclick="share.tw('<?php echo $this->_tpl_vars['data']['content_for_sharring']; ?>
', '<?php echo $this->_tpl_vars['data']['url']; ?>
')" class="simple-button large inverse"><i class="fa fa-twitter"></i> Share on Twitter</button>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['data']['platform'] == 'pinterest'): ?>
                <button onclick="share.pin('<?php echo $this->_tpl_vars['data']['content_for_sharring']; ?>
', '<?php echo $this->_tpl_vars['data']['media']; ?>
', '<?php echo $this->_tpl_vars['data']['url_pinterest']; ?>
')" class="simple-button large inverse" count-layout="horizontal"><i class="fa fa-pinterest"></i> Pinterest</button>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['data']['platform'] == 'reddit'): ?>
                <button onclick="share.reddit('<?php echo $this->_tpl_vars['data']['content_for_sharring']; ?>
', '<?php echo $this->_tpl_vars['data']['url']; ?>
')" class="simple-button large inverse" count-layout="horizontal"><i class="fa fa-reddit"></i> <span>Reddit</span></button>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['data']['platform'] == 'bsky'): ?>
                <button onclick="share.bsky('<?php echo $this->_tpl_vars['data']['content_for_sharring']; ?>
', '<?php echo $this->_tpl_vars['data']['url']; ?>
')" class="simple-button large inverse" count-layout="horizontal"> <span>BlueSky</span></button>
            <?php endif; ?>
        </div>
    </div>
</div>

