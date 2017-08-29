<input id="ajax-urls"
       type="hidden"
       {{--,'state'=>'###',--}}
       data-user-state-url="{{ route('application.users.changeState',['application_slug'=>'####','application_id'=>'###','app_user_id'=>'##',]) }}"
       data-user-delete-url="{{ route('application.users.delete',['application_slug'=>'####','application_id'=>'###','app_user_id'=>'##',]) }}"
       data-transaction-status-url="{{ route('application.transactions.updateStatus',['application_slug'=>'####','application_id'=>'###','transaction_id'=>'##',]) }}"
/>
