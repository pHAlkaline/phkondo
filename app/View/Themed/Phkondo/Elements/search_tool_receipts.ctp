<?php $this->Html->script('search', false); ?>
<?php
$advSearchStyle = 'display:none;padding:10px 0 10px 0;';
if ($hasAdvSearch) {
    $advSearchStyle = 'padding:10px 0 10px 0;';
}
?>
<div class="clearfix"></div>
<?php if (isset($keyword)) : ?>

    <div class="col-sm-12 col-lg-6 pull-right">
        <?php
        echo $this->Form->create(null, array('novalidate' => true, 'style="padding:10px 0 10px 0;', 'role' => 'search', 'type' => 'get', $this->request->here));
        ?>
        <div class="input-group">
            <?php
            foreach ($this->request->query as $key => $value) :
                $formKeys = ['keyword', 'page', 'receipt_status_id', 'entity_id', 'start_date', 'close_date'];
                if (!in_array($key, $formKeys)) :
                    echo $this->Form->hidden($key, array('value' => $value));
                endif;
            endforeach;
            ?>
            <input type="text" class="form-control" id="keyword" name="keyword" onblur="if (this.value == '')
                               this.value = '<?php echo __('Search'); ?>';" onfocus="if (this.value == '<?php echo __('Search'); ?>')
                               this.value = '';" value="<?php echo $keyword ?>" />

            <div class="input-group-btn">
                <button type="submit" class="btn btn-default" aria-label="<?php echo __('Search'); ?>">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                <button type="button" id="searchFormClear" class="btn btn-default" aria-label="<?php echo __('Clear'); ?>">
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
                <button type="button" id="searchFormFilter" class="btn btn-default" aria-label="<?php echo __('More options'); ?>">
                    <span class="glyphicon glyphicon-filter"></span>
                </button>
                <button type="button" class="btn btn-default table-export-bttn" data-table=".table-export" aria-label="<?php echo __('CSV'); ?>">
                    <span class="glyphicon glyphicon-download"></span>
                </button>
            </div>


        </div>
        <div class="clearfix"></div>
        <div class="panel-group" id="AdvancedSearchFields" style="<?php echo $advSearchStyle; ?>">
            <div class="panel panel-default">
                <div class="panel-body">
                <div class="col-sm-6">
                    <?php echo $this->Form->input('start_date', array(
                        'type' => 'text', 
                        'class' => 'form-control datefield',
                        'data-date-start-date'=>$fiscalYearData['FiscalYear']['open_date'],
                        'data-date-end-date'=>$fiscalYearData['FiscalYear']['close_date'],
                        )); ?>
                    </div><!-- .form-group -->
                    <div class="col-sm-6">
                    <?php echo $this->Form->input('close_date', array(
                        'type' => 'text', 
                        'class' => 'form-control datefield',
                        'data-date-start-date'=>$fiscalYearData['FiscalYear']['open_date'],
                        'data-date-end-date'=>$fiscalYearData['FiscalYear']['close_date'],
                        )); ?>
                    </div><!-- .form-group -->
                    <div class="col-xs-12 col-md-6 ">
                        <?php echo $this->Form->input('Receipt.entity_id', array('empty' => __('All'), 'class' => 'form-control')); ?>
                    </div><!-- .form-group -->
                    <div class="col-xs-12 col-md-6">
                        <?php echo $this->Form->input('Receipt.receipt_status_id', array('empty' => __('All'), 'class' => 'form-control')); ?>
                    </div><!-- .form-group -->
                   
                </div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
<?php endif; ?>
<div class="clearfix"></div>