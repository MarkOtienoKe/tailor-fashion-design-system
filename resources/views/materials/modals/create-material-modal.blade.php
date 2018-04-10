<!-- Modal -->
<div class="modal fade" id="createMaterialModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form role="form" method="POST" action="" id="create_material_form">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"> @lang('customer.titles.create')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="status" name="status" value="ACTIVE">
                    <div class="form-group">
                        <label class="">Name</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Description</label>
                        <div>
                            <textarea class="form-control input-lg" name="description"></textarea>
                        </div>
                    </div>
            </div>
            <div id="loader"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="createMaterial" type="submit" value="Submit">Save changes</button>
            </div>
        </div>
    </form>

</div>
</div>