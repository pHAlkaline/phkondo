<?php $this->Html->script('search', false); ?>
<div class="clearfix"></div>
<?php
if (isset($keyword)) :
    ?>
    <div class="col-sm-12">
    <?php echo $this->Form->create(null, array('class' => 'navbar-form navbar-right', 'role' => 'search', 'type' => 'get', $this->request->base)); ?>
        <div class="input-group">
        <?php
        foreach ($this->request->query as $key => $value):
            if ($key != 'keyword' && $key != 'page'):
                echo $this->Form->hidden($key, array('value' => $value));
            endif;
        endforeach;
        ?>
            <input type="text"
                   class="form-control"
                   id="keyword"
                   name="keyword"
                   onblur="if (this.value == '')
                               this.value = '<?php echo __('Search'); ?>';"
                   onfocus="if (this.value == '<?php echo __('Search'); ?>')
                               this.value = '';" value="<?php echo $keyword ?>" >
            <div class="input-group-btn">
                <button type="submit" class="btn btn-default" aria-label="<?php echo __('Search'); ?>">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                <button type="button" id="searchFormClear" class="btn btn-default" aria-label="<?php echo __('Clear'); ?>">
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
            </div>
        </div>

     <?php echo $this->Form->end(); ?>
    </div>
<?php endif; ?>
<div class="clearfix"></div>