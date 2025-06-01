<div class="modal fade" id="delete-item-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('dash.delete') }} {{ trans($module_name.'.single') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="DELETE">
                    @method('DELETE')
                    <div class="">
                        <p style="color: #5e5e5e;">{{ trans('dash.are_you_sure_delete') }}
                            <span class="item-name" style="font-weight: bold;">{{ trans('dash.this')}} {{ trans($module_name.'.single')}} </span> {{ trans('dash.?') }}
                        </p>
                    </div>
                    <div class="modal-btns d-flex" style="justify-content: end;">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="">{{ trans('dash.cancel')}}</button>
                        <button type="submit" class="btn btn-primary" onclick="deleteItem(this,event)">{{ trans('dash.delete')}}</button>
                    </div>
                </form>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->