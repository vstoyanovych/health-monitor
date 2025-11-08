<?php /* Smarty version 2.6.26, created on 2024-10-14 21:38:24
         compiled from articlecustompromptcreate.tpl */ ?>
<div class="custom-prompts-section">
    <div class="content-generator-wrapper">
        <div class="col-md-12 col-sm-12 flex-1">
            <div class="ai-form col-md-12">
                <div class="history">
                    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['data']['items']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                        <div>
                            <div class="itme-wrapper <?php if ($this->_tpl_vars['data']['items'][$this->_sections['i']['index']]['isincoming']): ?> incoming<?php else: ?> outgoing<?php endif; ?>" id="item_<?php echo $this->_tpl_vars['data']['items'][$this->_sections['i']['index']]['id']; ?>
">
                                <?php if ($this->_tpl_vars['data']['items'][$this->_sections['i']['index']]['text'] != ""): ?>
                                    <span><?php echo $this->_tpl_vars['data']['items'][$this->_sections['i']['index']]['text']; ?>
</span>
                                <?php endif; ?>
                            </div>
                            <?php if ($this->_tpl_vars['data']['items'][$this->_sections['i']['index']]['isincoming']): ?>
                                <div class="content-management-buttons <?php if ($this->_tpl_vars['data']['items'][$this->_sections['i']['index']]['isincoming']): ?> incoming<?php else: ?> outgoing<?php endif; ?>">
                                    <div class="wrapper pull-right">
                                        <div class="flex">
                                            <a href="javascript:;" onclick="saveCustomPromptResults(<?php echo $this->_tpl_vars['data']['items'][$this->_sections['i']['index']]['id']; ?>
, <?php echo $this->_tpl_vars['data']['block']; ?>
)" title="Save Results"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="26" height="26" stroke-width="1" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9" /></svg></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endfor; endif; ?>
                </div>
                <div class="input"></div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="generator-image-form col-md-12">
                <div class="generator-form-wrapper">
                    <div>
                        <input type="hidden" name="temp" id="temp" value="<?php echo $this->_tpl_vars['data']['temp']; ?>
">
                        <input type="hidden" name="text" id="text" value="<?php echo $this->_tpl_vars['data']['text']; ?>
">
                        <input type="hidden" name="article" id="article" value="<?php echo $this->_tpl_vars['data']['article']; ?>
">
                        <input type="hidden" name="block" id="block" value="<?php echo $this->_tpl_vars['data']['block']; ?>
">
                        <textarea class="form-control mb-10" id="image-prompt" rows="5" placeholder="Prompt"></textarea>
                        <div class="help-info hint">Prompt example: Create a list of catchy headlines for an article about health and fitness trends</div>
                    </div>
                    <div class="generator-header-buttons">
                        <a href="javascript:;" onclick="ExecuteCustomPrompt();" id="createButton" >Submit</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>