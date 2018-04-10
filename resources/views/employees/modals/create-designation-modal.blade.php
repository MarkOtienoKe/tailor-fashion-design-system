<!-- Modal -->
<div class="modal fade" id="createDesignationModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form role="form" method="POST" action="" id="create_designation_form">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel"> Create Designation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="status" name="status" value="ACTIVE">
                    <div class="form-group">
                        <label class="">Name <span required_field>*</span></label>
                        <div>
                            <input type="text" class="form-control input-lg" name="designation_name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="">Description<span
                                    class="optional_field"> (optional)</span></label>
                        <div>
                            <textarea type="text" class="form-control input-lg" name="description" value=""></textarea>
                        </div>
                    </div>
                </div>
                <div id="designation_loader"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="createDesignation" type="submit" value="Submit">Save changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>