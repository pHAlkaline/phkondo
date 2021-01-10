<h2><?php echo $title_for_step; ?></h2>
<div id="page-content" class="col-sm-9">

    <div class="install form">
        <?php echo $this->Form->create(false, array('url' => array('controller' => 'install', 'action' => 'database')));
        ?>
        <fieldset>
            <legend><?php echo __d('install', 'Setup database connection'); ?></legend>
            <div class="form-group">
                <?php
                echo $this->Form->input('datasource', array(
                    'class' => 'form-control',
                    'label' => 'Datasource',
                    'default' => 'Database/Mysql',
                    'empty' => false,
                    'options' => array(
                        'Database/Mysql' => 'mysql',
                        'Database/Sqlite' => 'sqlite',
                        'Database/Postgres' => 'postgres',
                        'Database/Sqlserver' => 'mssql',
                    ),
                ));
                ?>
            </div>

            <div class="form-group">
                <?php
                echo $this->Form->input('host', array('class' => 'form-control', 'label' => __('Host'), 'default' => 'localhost'));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('login', array('class' => 'form-control', 'label' => __('User'), 'default' => 'root'));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('password', array('class' => 'form-control', 'label' => __('Password')));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('database', array('class' => 'form-control', 'label' => __d('install','Database'), 'default' => 'phkondo'));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('encoding', array('class' => 'form-control', 'label' => __('Encoding'), 'default' => 'utf8'));
                ?>
            </div>
            <div class="form-group">
                <?php
                //echo $this->Form->input('prefix', array('label' => 'Prefix'));
                echo $this->Form->input('port', array('class' => 'form-control', 'label' => __('Port (leave blank if unknown)')));
                ?>
            </div>

        </fieldset>
        <div class="form-group">                
            <?php echo $this->Form->button(__('Submit'), array('type'=>'submit','class' => 'btn btn-large btn-primary')); ?>  
        </div>
        <?php echo $this->Form->end(); ?>
    </div>

</div>
<div class="clear"></div>