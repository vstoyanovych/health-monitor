<?php /* Smarty version 2.6.26, created on 2025-11-07 20:35:28
         compiled from article_add.tpl */ ?>
<?php $this->assign('m', $this->_tpl_vars['modules'][$this->_tpl_vars['index']]); ?>

<?php if ($this->_tpl_vars['action'] == 'addblock'): ?>
    <div id="article_block_<?php echo $this->_tpl_vars['m']['block_id']; ?>
">
        <div class="editor">
            <div style="padding-top:10px;">Message<sup class="adminform-required">*</sup></div>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editors_".($this->_tpl_vars['_settings']['ext_editor']).".tpl", 'smarty_include_vars' => array('editor_doing' => 'editor','class' => "block_".($this->_tpl_vars['m']['block_id']),'var' => "block_".($this->_tpl_vars['m']['block_id']),'value' => $this->_tpl_vars['m']['content'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


            <a href="javascript:;" class="edit-article-buttons" onclick="saveContent(<?php echo $this->_tpl_vars['m']['block_id']; ?>
, <?php echo $this->_tpl_vars['m']['article_id']; ?>
)">Save</a>
            <script>
                initEditor(<?php echo $this->_tpl_vars['m']['article_id']; ?>
, <?php echo $this->_tpl_vars['m']['block_id']; ?>
);
            </script>
        </div>
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] == 'editblock'): ?>
    <div class="editor">
        <div style="padding-top:10px;">Message<sup class="adminform-required">*</sup></div>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editors_".($this->_tpl_vars['_settings']['ext_editor']).".tpl", 'smarty_include_vars' => array('editor_doing' => 'editor','class' => "block_".($this->_tpl_vars['m']['block_id']),'var' => "block_".($this->_tpl_vars['m']['block_id']),'value' => $this->_tpl_vars['m']['content'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <a href="javascript:;" class="edit-article-buttons" onclick="saveContent(<?php echo $this->_tpl_vars['m']['block_id']; ?>
, <?php echo $this->_tpl_vars['m']['article_id']; ?>
, 'edit')">Save</a>
        <script>
            initEditor(<?php echo $this->_tpl_vars['m']['article_id']; ?>
, <?php echo $this->_tpl_vars['m']['block_id']; ?>
);
        </script>
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] == 'addimageblock'): ?>
    <div id="article_block_<?php echo $this->_tpl_vars['m']['block_id']; ?>
">
        <div class="editor">
            <div style="padding-top:10px;">Image URL<sup class="adminform-required">*</sup></div>
            <input type="text" name="image_url" id="image_url" value="<?php echo $this->_tpl_vars['m']['content']; ?>
" class="form-control" />
            <a href="javascript:;" class="edit-article-buttons" onclick="saveEmbedImage(<?php echo $this->_tpl_vars['m']['block_id']; ?>
, <?php echo $this->_tpl_vars['m']['article_id']; ?>
)">Save</a>
        </div>
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] == 'adduploadimageblock'): ?>
    <div id="article_block_<?php echo $this->_tpl_vars['m']['block_id']; ?>
">
        <div class="editor">
            <div class="field_title">
                <h4>Upload image</h4>
            </div>
            <div id="main_image">
                <INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="<?php echo $this->_tpl_vars['_settings']['max_upload_filesize']; ?>
">
                <input type="file" name="userfile" id="userfile_<?php echo $this->_tpl_vars['m']['block_id']; ?>
" class="uploadimage" data-block-id="<?php echo $this->_tpl_vars['m']['block_id']; ?>
" data-article-id="<?php echo $this->_tpl_vars['m']['article_id']; ?>
">
                <div class="imagepreview">
                    <div class="image" id="imagepreview" style="text-align: left">
                        <?php if ($this->_tpl_vars['data']['image'] != ""): ?>
                            <img src="<?php echo $this->_tpl_vars['data']['image']; ?>
" />
                            <a href="javascript:;" class="edit-article-buttons" onclick="removeImageBlock(<?php echo $this->_tpl_vars['data']['block_id']; ?>
)">Remove Image</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <script>
                $("#userfile_<?php echo $this->_tpl_vars['m']['block_id']; ?>
").change(function() {
                    processImageBlockUpload(<?php echo $this->_tpl_vars['m']['article_id']; ?>
, <?php echo $this->_tpl_vars['m']['block_id']; ?>
);
                    });
            </script>
        </div>
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['action'] == 'addembedblock'): ?>
    <div id="article_block_<?php echo $this->_tpl_vars['m']['block_id']; ?>
">
        <div class="editor">
            <div style="padding-top:10px;">Embed Code<sup class="adminform-required">*</sup></div>
            <textarea type="text" name="embed_code" class="form-control" id="embed_code"><?php echo $this->_tpl_vars['m']['content']; ?>
</textarea>
            <a href="javascript:;" class="edit-article-buttons" onclick="saveEmbedCode(<?php echo $this->_tpl_vars['m']['block_id']; ?>
, <?php echo $this->_tpl_vars['m']['article_id']; ?>
)">Save</a>
            <input type="hidden" id="blockID" value="<?php echo $this->_tpl_vars['m']['block_id']; ?>
">
            <script src="themes/default/article_block.js"></script>
        </div>
    </div>
<?php endif; ?>


<?php if ($this->_tpl_vars['action'] == 'view'): ?>



    <div id="editorconten" data-id="<?php echo $this->_tpl_vars['data']['id']; ?>
">
        <div class="error"></div>


        <div class="sidebar-container">
            <div class="toggle-gear">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
            </div>
            <div class="sidebar">

                <div class="col-md-12 flex gap-10 mb-10 controls-section flex-direction-row flex-wrap-wrap" style="position: relative; top:-10px;">
                    <div class="flex-1"></div>
                    <div class="content-modifications flex gap-10 flex-direction-row flex-wrap-wrap">
                        <?php if ($this->_tpl_vars['data']['original_content_url'] != ""): ?>
                            <a href="<?php echo $this->_tpl_vars['data']['original_content_url']; ?>
" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"></path></svg></a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['data']['get_original_content_url'] != ""): ?>
                            <a href="<?php echo $this->_tpl_vars['data']['get_original_content_url']; ?>
" class="edit-article-buttons">Reset To Original Article</a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['data']['full_article_rewrite_url'] != ""): ?>
                            <div class="dropdown action-buttons table mb-0">
                                <button class="btn ab-button dropdown-toggle btn-focus-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                    <span>Rewrite All <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.5 6.75L9 11.25L13.5 6.75" stroke="#4B5563" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-compaign dropdown-menu-cont">
                                    <a href="<?php echo $this->_tpl_vars['data']['full_article_rewrite_url']; ?>
" class="dropdown-item "><span>Neutral</span></a>
                                    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['data']['full_article_rewrite_url_writing_style']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                                        <a href="<?php echo $this->_tpl_vars['data']['full_article_rewrite_url_writing_style'][$this->_sections['i']['index']]['url']; ?>
" class="dropdown-item" title="<?php echo $this->_tpl_vars['data']['full_article_rewrite_url_writing_style'][$this->_sections['i']['index']]['title']; ?>
"><?php echo $this->_tpl_vars['data']['full_article_rewrite_url_writing_style'][$this->_sections['i']['index']]['emojy']; ?>
<span><?php echo $this->_tpl_vars['data']['full_article_rewrite_url_writing_style'][$this->_sections['i']['index']]['title']; ?>
</span></a>
                                    <?php endfor; endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="main_info_section">
                    <div class="col-md-12 flex pb-2 align-items-center" id="title_section">
                        <div class="col-md-12 field_title flex flex-direction-row">
                            <h4 class="flex-1">Title:</h4>
                            <div class="action-buttons">
                                <a href="javascript:;" class="edit-button" onclick="editTitle()" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg></a>
                                <?php if ($this->_tpl_vars['data']['title_rewrite_url'] != ""): ?>
                                    <a href="<?php echo $this->_tpl_vars['data']['title_rewrite_url']; ?>
" class="edit-button" title="Rewrite with OpenAI"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20">><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="data_section">
                            <div id="savedtitle" style="<?php if ($this->_tpl_vars['data']['title'] != ""): ?>display: table<?php else: ?>display: none<?php endif; ?>">
                                <h1><?php echo $this->_tpl_vars['data']['title']; ?>
</h1>
                            </div>
                            <div id="article-title" <?php if ($this->_tpl_vars['data']['title'] != ""): ?> style="display:none;"<?php endif; ?>>
                                <div class="col-md-12">
                                    <input type="text" name="title" class="form-control" value="<?php echo $this->_tpl_vars['data']['title']; ?>
" id="title" placeholder="title"/>
                                </div>
                                <a href="javascript:;" class="edit-article-buttons" onclick="saveTitle(<?php echo $this->_tpl_vars['data']['id']; ?>
)">Save</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 flex pt-2 pb-2 align-items-center" id="short_description_section">
                        <div class="col-md-12 field_title flex flex-direction-row">
                            <h4 class="flex-1">Short Description:</h4>
                            <div class="action-buttons">
                                <a href="javascript:;" class="edit-button" onclick="editDescription()" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg></a>
                                <?php if ($this->_tpl_vars['data']['title_rewrite_url'] != ""): ?>
                                    <a href="<?php echo $this->_tpl_vars['data']['short_description_rewrite_url']; ?>
" class="edit-button" title="Rewrite with OpenAI"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20">><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg></a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="data_section">
                            <div id="saveddescription">
                                <div class="description" id="descriptionPreview"><?php echo $this->_tpl_vars['data']['short_description']; ?>
</div>
                            </div>
                            <div id="article-description">
                                <div class="col-md-12" id="descriptionEditor" style="display: none;">
                                    <textarea name="description" class="form-control" id="description" rows="6" placeholder="Short Description"><?php echo $this->_tpl_vars['data']['short_description']; ?>
</textarea>
                                    <div class="col-md-12">
                                        <a href="javascript:;" class="edit-article-buttons" onclick="saveDescription(<?php echo $this->_tpl_vars['data']['id']; ?>
)">Save</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 flex pt-2 pb-2 align-items-center" id="short_info_section">
                        <div class="col-md-12 field_title">
                            <h4>Info</h4>
                        </div>
                        <div class="data_section">
                            <div id="saveddescription">
                                <div class="description"><?php echo $this->_tpl_vars['data']['info']; ?>
</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 flex pt-2 pb-2 align-items-center" id="tags_section">
                        <div class="col-md-12 field_title flex flex-direction-row">
                            <h4 class="flex-1">Tags:</h4>
                            <div class="action-buttons">
                                <a href="javascript:;" class="edit-button" onclick="editTags()" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg></a>
                                <?php if ($this->_tpl_vars['data']['tags_generate_url'] != ""): ?>
                                    <a href="<?php echo $this->_tpl_vars['data']['tags_generate_url']; ?>
" class="edit-button" title="Rewrite with OpenAI"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20">><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="data_section flex">
                            <div id="savedtags">
                                <div class="tags_list" id="tagsPreview">
                                    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['data']['tags']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                                        <?php if ($this->_tpl_vars['data']['tags'][$this->_sections['i']['index']]['checked']): ?>
                                            <div class="label label-info"><?php echo $this->_tpl_vars['data']['tags'][$this->_sections['i']['index']]['title']; ?>
</div>
                                        <?php endif; ?>
                                    <?php endfor; endif; ?>
                                </div>
                            </div>
                            <div id="article-tags">
                                <div class="col-md-12" id="tagsEditor" style="display: none;">
                                    <select id="js-tags-selector" class="tags-for-regularpages tags-form" name="tags_selected[]" multiple>
                                        <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['data']['tags']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                                            <option value="<?php echo $this->_tpl_vars['data']['tags'][$this->_sections['i']['index']]['value']; ?>
" <?php if ($this->_tpl_vars['data']['tags'][$this->_sections['i']['index']]['checked'] == 1): ?>SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['data']['tags'][$this->_sections['i']['index']]['title']; ?>
</option>
                                        <?php endfor; endif; ?>
                                    </select>
                                    <div class="col-md-12">
                                        <a href="javascript:;" class="edit-article-buttons" onclick="saveTags(<?php echo $this->_tpl_vars['data']['id']; ?>
)">Save</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 flex pt-2 pb-2 align-items-center" id="keywords_section">
                        <div class="col-md-12 field_title flex flex-direction-row">
                            <h4 class="flex-1">Keywords:</h4>
                            <div class="action-buttons">
                                <?php if ($this->_tpl_vars['data']['keywords_rewrite_url'] != ""): ?>
                                    <a href="<?php echo $this->_tpl_vars['data']['keywords_rewrite_url']; ?>
" class="edit-button" title="Rewrite with OpenAI"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20">><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="data_section">
                            <div id="saveddescription">
                                <div class="description" id="keywordsPreview"><?php echo $this->_tpl_vars['data']['keywords']; ?>
</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 flex pt-2 pb-2 align-items-center" id="short_description_section">
                        <div class="col-md-12 field_title">
                            <h4>Channel</h4>
                        </div>
                        <div class="data_section flex flex-direction-row flex-wrap-wrap">
                            <div id="article-type">
                                <select name="type_f" size="1" id="type_f" class="form-control">
                                    <option value="">-- Select Type --</option>
                                    <option value="ytvideo" <?php if ($this->_tpl_vars['data']['type'] == 'ytvideo'): ?>selected<?php endif; ?>>Video</option>
                                    <option value="content" <?php if ($this->_tpl_vars['data']['type'] == 'content'): ?>selected<?php endif; ?>>Content</option>
                                </select>
                                <input type="hidden" id="article_id" value="<?php echo $this->_tpl_vars['data']['id']; ?>
"/>
                            </div>
                            <div id="article-channel">
                                <select id="channel_id" name="channel_id" class="form-control">
                                    <option value="0">-- Select Channel --</option>
                                    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['data']['channels_ids']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                                        <option<?php if ($this->_tpl_vars['data']['channel'] == $this->_tpl_vars['data']['channels_ids'][$this->_sections['i']['index']]): ?> selected<?php endif; ?> value="<?php echo $this->_tpl_vars['data']['channels_ids'][$this->_sections['i']['index']]; ?>
"><?php echo $this->_tpl_vars['data']['channels_titles'][$this->_sections['i']['index']]; ?>
</option>
                                    <?php endfor; endif; ?>
                                </select>
                            </div>
                            <div id="article-playlist" <?php if ($this->_tpl_vars['data']['type'] == 'content'): ?>style="display:none;"<?php endif; ?>>
                                <select id="playlist_id" name="playlist_id">
                                    <option value="0">-- Select Playlist --</option>
                                    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['data']['playlists_ids']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                                        <option<?php if ($this->_tpl_vars['data']['playlist'] == $this->_tpl_vars['data']['playlists_ids'][$this->_sections['i']['index']]): ?> selected<?php endif; ?> value="<?php echo $this->_tpl_vars['data']['playlists_ids'][$this->_sections['i']['index']]; ?>
"><?php echo $this->_tpl_vars['data']['playlists_titles'][$this->_sections['i']['index']]; ?>
</option>
                                    <?php endfor; endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>




                    <div class="col-md-12 flex pt-2 pb-2 align-items-center" id="short_description_section">
                        <div class="col-md-12 field_title">
                            <h4>Upload main image</h4>
                        </div>
                        <div class="data_section">
                            <div id="main_image">
                                <INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="<?php echo $this->_tpl_vars['_settings']['max_upload_filesize']; ?>
">
                                <input type="file" name="userfile" id="userfile">
                                <div class="imagepreview">
                                    <div class="image" id="imagepreview" style="text-align: left">
                                        <?php if ($this->_tpl_vars['data']['main_image'] != ""): ?>
                                            <img src="<?php echo $this->_tpl_vars['data']['main_image']; ?>
" />
                                            <a href="javascript:;" class="edit-article-buttons" onclick="removeImage(<?php echo $this->_tpl_vars['data']['id']; ?>
)">Remove Image</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12 flex pt-2 pb-2 align-items-center" id="main_video_section">
                        <div class="col-md-12 field_title flex flex-direction-row">
                            <h4 class="flex-1">Hero Video Youtube URL:</h4>
                            <div class="action-buttons">
                                <a href="javascript:;" class="edit-button" onclick="editVideo()" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg></a>
                            </div>
                        </div>
                        <div class="data_section">
                            <div id="savedvideo" style=" width: 100%;">
                                <div class="embedvideo">
                                    <?php echo $this->_tpl_vars['data']['youtube_video_embed']; ?>

                                </div>
                            </div>
                            <div id="video-url" style="display:none;">
                                <div class="col-md-12">
                                    <input type="text" name="youtube_video_url" class="form-control" value="<?php echo $this->_tpl_vars['data']['youtube_video_url']; ?>
" id="youtube_video_url" placeholder="Youtube Video URL"/>
                                </div>
                                <a href="javascript:;" class="edit-article-buttons" onclick="saveVideo(<?php echo $this->_tpl_vars['data']['id']; ?>
)">Save</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 flex gap-10 mt-10 controls-section flex-direction-row flex-wrap-wrap">
                    <div class="content-publication flex gap-10 flex-direction-row flex-wrap-wrap w-100 mt-10">
                        <?php if ($this->_tpl_vars['data']['draft']): ?>
                            <a href="javascript:;" onclick="publishArticle()" class="pull-right publish-article-buttons" title="Publish"><span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="25" height="25"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" /></svg> Publish</span></a>
                        <?php endif; ?>
                        <div class="flex-1"></div>
                        <?php if ($this->_tpl_vars['data']['exiturl'] != ""): ?>
                            <a href="<?php echo $this->_tpl_vars['data']['exiturl']; ?>
" id="exit-button" class="pull-right exit-article-buttons"><span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="25" height="25"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" /></svg></span></a>
                        <?php endif; ?>
                        <a href="javascript:;" onclick="deleteArticle()" class="pull-right delete-article-buttons"><span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="25" height="25"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div id="content-section" class="editor-content-body-wrapper">
            <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['data']['content']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                <div class="article_block field_id_<?php echo $this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['id']; ?>
" id="article_block_<?php echo $this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['id']; ?>
">
                    <div class="flex" style="align-items: inherit;">
                        <div style="width:30px; margin-right: 20px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" style="margin-top:2px; cursor: pointer" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-move"><polyline points="5 9 2 12 5 15"></polyline><polyline points="9 5 12 2 15 5"></polyline><polyline points="15 19 12 22 9 19"></polyline><polyline points="19 9 22 12 19 15"></polyline><line x1="2" y1="12" x2="22" y2="12"></line><line x1="12" y1="2" x2="12" y2="22"></line></svg>
                        </div>
                        <div>
                            <?php if ($this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['type'] == 'image'): ?>
                                <img src="<?php echo $this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['content']; ?>
" />
                            <?php elseif ($this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['type'] == 'custom_image'): ?>
                                <?php if ($this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['image_exists'] == '1'): ?>
                                    <img src="<?php echo $this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['content']; ?>
" />
                                <?php endif; ?>
                            <?php elseif ($this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['type'] == 'embed'): ?>
                                <?php echo $this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['content']; ?>

                            <?php else: ?>
                                <?php echo $this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['content']; ?>

                            <?php endif; ?>

                            <div class="manage-contant-buttons">
                                <?php if ($this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['type'] == 'image'): ?>
                                    <a href="javascript:;" class="edit-article-buttons" onclick="editEmbedImage(<?php echo $this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['id']; ?>
, <?php echo $this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['article']; ?>
)">Edit</a>
                                <?php elseif ($this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['type'] == 'embed'): ?>
                                    <a href="javascript:;" class="edit-article-buttons" onclick="editEmbedCode(<?php echo $this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['id']; ?>
, <?php echo $this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['article']; ?>
)">Edit</a>
                                <?php else: ?>
                                    <a href="javascript:;" class="edit-article-buttons" onclick="editText(<?php echo $this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['id']; ?>
, <?php echo $this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['article']; ?>
)">Edit</a>
                                <?php endif; ?>
                                <a href="javascript:;" class="edit-article-buttons" onclick="deleteBlock(<?php echo $this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['id']; ?>
, <?php echo $this->_tpl_vars['data']['content'][$this->_sections['i']['index']]['article']; ?>
)">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; endif; ?>


        </div>
        <div class="col-md-12" id="addblock_section">
            <a href="javascript:;" onclick="AddText(<?php echo $this->_tpl_vars['data']['id']; ?>
)"><span class="icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="25" height="25"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" /></svg><span>Add Text</span></span></a>
            <a href="javascript:;" onclick="UploadImage(<?php echo $this->_tpl_vars['data']['id']; ?>
)"><span class="icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="25" height="25"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg><span>Upload Image</span></span></a>
            <a href="javascript:;" onclick="AddImage(<?php echo $this->_tpl_vars['data']['id']; ?>
)"><span class="icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="25" height="25"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" /></svg><span>Embed Image</span></span></a>
            <a href="javascript:;" onclick="AddEmbedCode(<?php echo $this->_tpl_vars['data']['id']; ?>
)"><span class="icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  width="25" height="25"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75 16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" /></svg><span>Add Embed Code</span></span></a>
        </div>





    <script src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="themes/<?php echo $this->_tpl_vars['special']['theme']; ?>
/assets/js/required/jquery-ui-1.11.0.custom/jquery-ui.min.js"></script>
    <script type="text/javascript" src="themes/default/jquery.ui.touch-punch.min.js"></script>

    <script>
        $('.dropdown-toggle').dropdown();

            function initializeSortable(){
                $("#content-section").sortable({
                    update: function (event, ui) {
                        var sortorder = [];
                        $('#content-section .article_block').each(function(index) {
                            var classes = $(this).attr("class").split(' ');
                            for (var i = 0; i < classes.length; i++) {
                                if (classes[i].indexOf('field_id_') === 0) {
                                    var id = classes[i].substring(9);
                                    sortorder.push(id);
                                    break;
                                    }
                                }
                            });

                        console.log("Sorted order:", sortorder);

                        $.ajax({
                            type: 'POST',
                            url: 'index.php?m=article&d=setsortorder&id=<?php echo $this->_tpl_vars['data']['id']; ?>
',
                            data: {
                                'sortorder': sortorder
                                }
                            });
                        }
                    });
                $("#content-section").disableSelection();
            }

            initializeSortable();

    </script>

    <script type="text/javascript" src="ext/editors/<?php echo $this->_tpl_vars['_settings']['ext_editor']; ?>
/tinymce.min.js"></script>
    <script type="text/javascript" src="themes/default/article_editor.js"></script>
<?php endif; ?>