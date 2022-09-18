
<div class="jumbotron">
    <h1><img src="<?php echo $logo_image_src; ?>" style="height:100%;" alt="phkondo" class="img-responsive center-block" /></h1>
    <!--p><?php //echo  __('Welcome'); ?></p-->
    <?php if (Configure::read('Config.language')=='por'){ ?>
    <div class="row center-text">
    <h2>Software para Gestão e Administração de Condomínios</h2>
    </div>
    <br/><br/>
    <p class="text-primary">É uma excelente ferramenta de apoio à administração de condomínios, gratuito, <a target="_blank" href="https://www.youtube.com/watch?v=Og1WuD8vMTI&amp;t=1490">software livre </a> distribuído sobre <a target="_blank" href="http://opensource.org/licenses/GPL-2.0">liçenca GNU GPL-2.0</a>.</p>
    <p class="text-primary">Sem qualquer limitação tem como principais características a gestão de Períodos Contabilísticos, Fracções, Proprietários e Representantes, Orçamentos, Notas de Crédito e Débito (Quotas), Contas Bancárias e Movimentos, Administradores, Conferência de Faturas, Recibos, Manutenção, Seguros, Minutas de Documentos....</p>
    <p class="text-primary">pHKondo sempre foi publicado sob uma licença Open Source, e para continuar, vai obrigar a muitas horas de dedicação para desenvolver e testar.</p>
    <p class="text-primary">Se você acha este software valioso, considere algum tipo de contribuição de forma a manter o pHKondo gratuíto Open Source.</p>
    <?php } else { ?>
    <div class="row text-center">
    <h2 class="mx-auto">Software for condominium property managers</h2>
    </div>
    <br/><br/>
    <p class="text-primary">It is an excellent tool to Manage your entire condo portfolio, it's free, open source and distributed under license GNU GPL-2.0.</p>
    <p class="text-primary">Without limiting, its main features are management of Accounting Periods, Properties, Owners, Representatives, Budgets, Fees, Accounts, Movements, Billing, Payment Receipts, Maintenance, Insurances....</p>
    <p class="text-primary">pHKondo is a complicated piece of software, and has always been released under an Open Source license, 
      and to continue this will cost many hours of dedication to develop, test and support. 
      If you find pHKondo valuable, we would appreciate it if you would consider a contribution.</p>
    <?php } ?>
    <p><a class="btn btn-primary btn-lg" href="https://github.com/pHAlkaline/phkondo/wiki/Keep-This-Tool-OpenSource" target="_blank" role="button"><?php echo  __('Contribute Here') ?></a></p>
</div>


