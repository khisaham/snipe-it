{{-- See snipeit_modals.js for what powers this --}}
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">{{ trans('general.priority') }}</h2>
        </div>
        <div class="modal-body">
            <form action="{{ route('api.ticket.store') }}" onsubmit="return false" method="post">
                {{ csrf_field() }}
                <div class="alert alert-danger" id="modal_error_msg" style="display:none">
                </div>
                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12"><label for="modal-name">{{ trans('general.name') }}:
                        </label></div>
                    <div class="col-md-8 col-xs-12 required">
                        <select class="form-control select2" data-placeholder="Select Priority" name="priority" style="width: 100%" id="priority" data-select2-id="priority_select" tabindex="-1" aria-hidden="true">
                            <option value="" data-select2-id="7">Select Priority</option>
                            <option value="urgent">Urgent</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select> 
                    </div>
                </div>
                <input type="text" name='ticket_no' id="modal-ticket_no" value="{{ request('ticket_no') }}" />
                <input type="text" name="update" id="modal-ticket_no" value="priority" />
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.cancel') }}</button>
            <button type="button" class="btn btn-primary" id="modal-save">{{ trans('general.save') }}</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->