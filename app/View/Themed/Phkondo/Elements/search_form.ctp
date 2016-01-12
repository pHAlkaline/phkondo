<?php $this->Html->script('search', false); ?>
<?php
if (isset($keyword) && $keyword != null) {
    $this->Paginator->options(array('url' => array_merge($this->passedArgs, array('keyword' => $keyword))));
} else {
    $keyword = ''; //__('Search...');
}
$request = preg_replace('#(/page:)(\d+)#', '', $this->request->here);
?>
<form action="<?php echo $request; ?>"  method="get" class="search-form col-md-3 pull-right" role="search">
    <div class="input-group custom-search-form">
        <input type="text" class="form-control"  name="keyword" onblur="if (this.value == '')
                        this.value = '<?php echo __('Search'); ?>';" onfocus="if (this.value == '<?php echo __('Search'); ?>')
                                    this.value = '';" value="<?php echo $keyword ?>" >
        <span  class="input-group-btn">
            <button type="submit" class="btn btn-default" type="button">
                <i class="fa fa-search"></i>
            </button>
            <button type="submit" class="btn btn-default" id="searchFormClear" type="button">
                <i class="fa fa-remove"></i>
            </button>
        </span>
    </div>
    <!-- /input-group -->

</form>
<!-- /.search form -->