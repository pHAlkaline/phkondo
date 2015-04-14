
<div class="jumbotron">
    <h1><?= __('pHkondo'); ?></h1>
    <p><?= __('Welcome'); ?></p>
    <?php if ($this->Session->read('User.language')=='por'): ?>
    <h2>Software para Gestão e Administração de Condomínios</h2>
    <p class="text-primary">É uma excelente ferramenta de apoio à administração de condomínios, gratuito, <a target="_blank" href="https://www.youtube.com/watch?v=Og1WuD8vMTI&amp;t=1490">software livre </a> distribuído sobre <a target="_blank" href="http://opensource.org/licenses/GPL-2.0">liçenca GNU GPL-2.0</a>.</p>
    <p class="text-primary">Sem qualquer limitação tem como principais características a gestão de Exercícios, Fracções Proprietários e Representantes, Orçamentos, Notas de Crédito e Débito (Quotas), Contas Bancárias e Movimentos, Administradores, Conferência de Faturas, Recibos, Manutenção, Seguros, Minutas de Documentos,  e muito mais.</p>
    <p class="text-primary">pHKondo sempre foi publicado sob uma licença Open Source, e para continuar, no futuro isso vai nos custar milhares de horas para desenvolver e testar.</p>
    <p class="text-primary">Se você acha este software valioso, considere uma doação ou patrocinio de formar a ajudar a manter pHKondo GRÁTIS.</p>
    <?php endif; ?>
    <?php if ($this->Session->read('User.language')=='eng'): ?>
    <h2>Software for condominium property managers</h2>
    <p class="text-primary">It is an excellent tool to Manage your entire condo portfolio, it's free, open source and distributed under license GNU GPL-2.0.</p>
    <p class="text-primary">Without limiting, its main features are management of Properties its Owners and Representatives, Budgets, Credit and Debit Notes (shares), Bank Accounts and Movements, Billing, Payment Receipts, Maintenance, Insurances, and more.</p>
    <p class="text-primary">pHKondo is a complicated piece of software, and has always been released under an Open Source license, 
      and to continue into the future this will cost us thousands of hours to develop, test and support. 
      If you find pHKondo valuable, we would appreciate it if you would consider a donation.</p>
    <?php endif; ?>
    <p><a class="btn btn-primary btn-lg" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3XPHC4Z3YJW88" target="_blank" role="button"><?= __('Donate Here') ?></a></p>
</div>


