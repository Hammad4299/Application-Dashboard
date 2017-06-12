<script type="text/html" id="checklist-document-row-template">
    @include('partials.checklist.checklist-document-row',['document'=>null])
</script>

<script type="text/html" id="checklist-insert-row-template">
    @include('partials.checklist.checklist-insert-row',['asset'=>null])
</script>

<script type="text/html" id="checklist-document-row-indexes-template">
    @include('partials.checklist.document-row-indexes',['index'=>0,'insertIndex'=>null])
</script>

<script type="text/html" id="file-status-row">
    <tr>
        <td class="col-sm-4 js-file-name">Filename</td>
        <td class="col-sm-2 js-file-status">Status</td>
        <td class="col-sm-6 js-message">Message</td>
    </tr>
</script>

<script type="text/html" id="document-insert-editable-template">
    <div class="col-sm-12 clearfix padding-0 margin-top" data-insert-id="">
        <div class="col-sm-8 padding-0"><input type="text" name="insert_name" class="form-control"></div>
        <div class="col-sm-4 padding-0">
            <div class="arrows-container" style="margin-left: 25px;">
                <span data-item-selector="[data-insert-id]" data-parent-container=".js-inserts" class="js-order arrow-btn big"  data-direction="up"><i class="fa fa-sort-up" aria-hidden="true"></i></span>
                <span data-item-selector="[data-insert-id]" data-parent-container=".js-inserts" class="js-order arrow-btn big" data-direction="down"><i class="fa fa-sort-desc" aria-hidden="true"></i></span>
            </div>
            <button class="btn btn-danger js-delete-insert-btn" style="height: 42px;">Delete</button>

        </div>
    </div>
</script>

<script type="text/html" id="sigpage-block-editable-template">
    <div class="col-sm-12 clearfix padding-0 margin-top" data-block-id="">
        <div class="col-sm-8 padding-0">
            <input type="text" name="block_name" class="form-control">
        </div>
        <div class="col-sm-4 padding-0">
            <div class="arrows-container" style="margin-left: 25px;">
                <span data-item-selector="[data-block-id]" data-parent-container=".js-blocks" class="js-order arrow-btn big"  data-direction="up"><i class="fa fa-sort-up" aria-hidden="true"></i></span>
                <span data-item-selector="[data-block-id]" data-parent-container=".js-blocks" class="js-order arrow-btn big" data-direction="down"><i class="fa fa-sort-desc" aria-hidden="true"></i></span>
            </div>
            <button class="btn btn-danger js-delete-block-btn">Delete</button>

        </div>
    </div>
</script>