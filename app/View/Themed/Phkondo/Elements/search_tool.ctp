<?php

if (isset($keyword)) :
    echo $this->Form->create(null, array('class' => 'navbar-form navbar-right', 'role' => 'search', 'type' => 'get', 'url' => $this->request->here));
?>
<div class="form-group">
                    <?php
                    foreach ($this->request->query as $key => $value):
                        if ($key != 'keyword' && $key != 'page'):
                            echo $this->Form->hidden($key, array('value' => $value));
                        endif;
                    endforeach;
                    ?>
    <input type="text"
           class="form-control"
           name="keyword"
           onblur="if (this.value == '')
                       this.value = '<?php echo __('Search'); ?>';"
           onfocus="if (this.value == '<?php echo __('Search'); ?>')
                       this.value = '';" value="<?php echo $keyword ?>" >
</div>
<button type="submit" class="btn btn-default"><?php echo __('Search'); ?></button>
</form>
<?php endif; ?>