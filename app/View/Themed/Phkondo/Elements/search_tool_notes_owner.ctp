<?php

$this->Html->script('search', false); ?>
<?php 
$advSearchStyle = 'display:none;padding:10px 0 10px 0;';
if ($hasAdvSearch) {
    $advSearchStyle = 'padding:10px 0 10px 0;';
}
?>
<?php if (isset($keyword)) : ?>
<div class="clearfix"></div>
<?php
echo $this->Form->create(null, array('novalidate' => true, 'style="padding:10px 0 10px 0;','class' => 'col-sm-12', 'role' => 'search', 'type' => 'get', $this->request->here));
?>
<div class="input-group col-md-4 col-sm-6 col-xs-12 pull-right">
 <?php 
 foreach ($this->request->query as $key => $value):
     $formKeys=['keyword','page','note_status_id','note_type_id'];
     if (!in_array($key,$formKeys)):
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
                           this.value = '';" value="<?php echo $keyword ?>" />

    <div class="input-group-btn">
        <button type="submit" class="btn btn-default" aria-label="<?php echo __('Search'); ?>">
            <span class="glyphicon glyphicon-search"></span>
        </button>
        <button type="submit" id="searchFormClear" class="btn btn-default" aria-label="<?php echo __('Clear'); ?>">
            <span class="glyphicon glyphicon-remove"></span>
        </button>
        <button type="button" id="searchFormFilter" class="btn btn-default" aria-label="<?php echo __('More options'); ?>">
            <span class="glyphicon glyphicon-filter"></span>
        </button>
    </div>


</div>
<div class="clearfix"></div>
<div class="panel-group" id="AdvancedSearchFields" style="<?php echo $advSearchStyle; ?>">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-sm-6" >
                        <?php echo $this->Form->input('Note.note_type_id', array('empty' => __('All'), 'class' => 'form-control')); ?>
            </div><!-- .form-group -->
            <div class="col-sm-6" >
                        <?php echo $this->Form->input('Note.note_status_id', array('empty' => __('All'), 'class' => 'form-control')); ?>
            </div><!-- .form-group -->
          
        </div>
    </div>
</div>
</form>
</div>
<div class="clearfix"></div>
<?php endif; ?>