<div class="modal fade" id="bk-confirm-modal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form class="modal-content" id="bk-confirm-form" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">
                    {{ __('_record.editing') }}
                </h5>
                <button class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{ __('_dialog.execute') }}
            </div>

            <div class="modal-footer">
                <button class="mr-0 btn btn-success bk-min-w-50" type="submit">
                    {{ __('_dialog.yep') }}
                </button>
                <button class="btn btn-secondary bk-min-w-50" data-dismiss="modal">
                    {{ __('_dialog.nope') }}
                </button>
            </div>
        </form>
    </div>
</div>
