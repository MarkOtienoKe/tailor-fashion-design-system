<!-- Modal -->
<div class="modal fade" id="editCustomerModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form role="form" method="POST" action="" id="edit_customer_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h class="modal-title" id="exampleModalLabel"> @lang('employee.titles.edit')</h>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_token" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="employeeId" name="employee_id" value="">
                    <div class="form-group">
                        <label class="">Name</label>
                        <div>
                            <input id="edit_name" type="text" class="form-control input-lg" name="name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">EMail</label>
                        <div>
                            <input id="edit_email" type="email" class="form-control input-lg" name="email" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Phone Number</label>
                        <div>
                            <input type="text" id="edit_mobile" class="form-control input-lg" name="mobile">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Address</label>
                        <div>
                            <input type="text" id="edit_address" class="form-control input-lg" name="address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">ID Number</label>
                        <div>
                            <input id="edit_id_no" type="text" class="form-control input-lg" name="id_number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Date of Employment</label>
                        <div>
                            <input id="edit_date_of_employment" type="date" class="form-control input-lg" name="date_of_employment">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Salary</label>
                        <div>
                            <input id="edit_salary" type="text" class="form-control input-lg" name="salary">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Designation</label>
                        <div>
                            <select id="edit_designationId" class="form-control input-lg" name="designation_id"></select>
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