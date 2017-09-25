<?php
       $moneyMakerRouteName = \App\Applications\MoneyMakerApplication::getInstance()->getRouteNamePrefix();
       $moneyMakerPrefix = \App\Applications\MoneyMakerApplication::getInstance()->getRoutePrefix();
?>

<input id="ajax-urls"
       type="hidden"
       data-moneymaker-user-state-url="{{ route($moneyMakerRouteName.'application.users.changeState',['application_id'=>'###','app_user_id'=>'##']) }}"
       data-moneymaker-user-delete-url="{{ route($moneyMakerRouteName.'application.users.delete',['application_id'=>'###','app_user_id'=>'##']) }}"
       data-moneymaker-transaction-status-url="{{ route($moneyMakerRouteName.'application.transactions.updateStatus',['application_id'=>'###','transaction_id'=>'##']) }}"
/>
