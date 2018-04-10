<!-- Modal -->
<div class="modal fade" id="editUserModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form role="form" method="POST" action="" id="edit_user_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h class="modal-title" id="exampleModalLabel"> @lang('user.titles.edit')</h>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_token" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="userId" name="user_id" value="">
                    <div class="form-group">
                        <label class="control-label">Username</label>
                        <div>
                            <input type="text" class="form-control input-lg" id="edit_name" name="name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">E-Mail Address</label>
                        <div>
                            <input type="email" id="edit_email" class="form-control input-lg" name="email" value="">
                        </div>
                    </div>

                </div>
                <div id="edit_loader"></div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" type="submit" value="Submit">Save changes</button>
                </div>
            </div>

        </form>
    </div>
</div>