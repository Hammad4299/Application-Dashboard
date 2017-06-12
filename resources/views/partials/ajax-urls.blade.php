<input id="ajax-urls"
       type="hidden"
       data-checklist-versions-url="{{ route('checklists.versions',['checklist_id'=>'##']) }}"
       data-checklist-versions-show-url="{{ route('checklists.show-version',['checklist_id'=>'##','version_id'=>'###']) }}"
       data-checklist-get-url="{{ route('checklists.index',['ajax'=>'true']) }}"
       data-checklist-update-url="{{ route('checklists.update',['checklist_id'=>'##']) }}"

       data-document-create-update-url="{{ route('documents.create-update',['checklist_id'=>'##','version_id'=>'###']) }}"
       data-document-delete-url="{{ route('documents.destroy',['checklist_id'=>'##','document_id'=>'####','version_id'=>'###']) }}"
       data-document-update-order-url="{{ route('documents.updateOrder',['checklist_id'=>'##','version_id'=>'###','document_id'=>'####']) }}"
       data-document-compile-url="{{ route('documents.compile',['checklist_id'=>'##','version_id'=>'###']) }}"
       data-document-inserts-url="{{ route('documents.inserts', ['checklist_id'=>'##','version_id'=>'###', 'document_id' => '####']) }}"



       data-version-delete-url="{{ route('version.destroy',['checklist_id'=>'##','version_id'=>'###']) }}"
       data-version-create-url="{{ route('version.create',['checklist_id'=>'##']) }}"
       data-version-update-url="{{ route('version.update-name',['checklist_id'=>'##','version_id'=>'###']) }}"

       data-group-delete-url="{{route('documentgroup.destroy',['checklist_id'=>'##','version_id'=>'###','group_id'=>'####'])}}"
       data-group-create-update-url="{{ route('documentgroup.createupdate',['checklist_id'=>'##','version_id'=>'###'])}}"
       data-group-get-url="{{ route('documentgroup.get',['checklist_id'=>'##','version_id'=>'###']) }}"

       data-subtitle-delete-url="{{ route('subtitle.destroy',['checklist_id'=>'##','subtitle_id'=>'###']) }}"
       data-subtitle-create-or-update-url="{{ route('subtitle.createOrUpdate',['checklist_id'=>'##']) }}"

       data-autoloads-get-url="{{ route('autoloads.get',['checklist_id'=>'##','type'=>'###']) }}"

       data-attachment-create-url="{{ route('attachment.store') }}"

       data-sigpage-create-update-url="{{ route('sigpages.storeOrUpdate',['checklist_id'=>'##','version_id'=>'###','document_id'=>'####']) }}"
       data-sigpage-delete-url="{{ route('sigpages.destroy',['checklist_id'=>'##','version_id'=>'###','sigpage_id'=>'####']) }}"
       data-sigpage-generate-url="{{ route('sigpages.generate',['checklist_id'=>'##','version_id'=>'###']) }}"

       data-init-sig-block-url="{{ route('sigpages.init', ['checklist_id'=>'##','version_id'=>'###','document_id'=>'####']) }}"



       data-sigblock-create-edit-url="{{ route('sigblock.createOrEdit',['checklist_id'=>'##','sigblock_id'=>'####','version_id'=>'###']) }}"
/>

