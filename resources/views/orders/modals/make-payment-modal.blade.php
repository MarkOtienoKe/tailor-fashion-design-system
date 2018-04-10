<!-- Modal -->
<div class="modal fade" id="makePaymentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form role="form" method="POST" action="" id="make_payment_form" enctype="multipart/form-data">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel"> @lang('order.payments.title')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="status" name="status" value="ACTIVE">
                    <input type="hidden" id="order_id" name="order_id" value="">
                    <input type="hidden" id="payment_type" name="payment_type" value="ORDER PAYMENT">
                    <div class="form-group ">
                        <label class="control-label">Payment Method <span class="required_field">*</span></label>
                        <div>
                            <select id="payment_method" class="form-control input-lg"
                                    name="payment_method">
                                <option value="">--Select--</option>
                                <option value="CASH">CASH</option>
                                <option value="MPESA">MPESA</option>
                                <option value="CHEQUE">CHEQUE</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mpesa_transaction" hidden>
                        <label class="">Mpesa Transaction Id</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="mpesa_transaction_id" value="" required>
                        </div>
                    </div>
                    <div class="form-group upload_cheque" hidden>
                        <label class="">Upload Cheque</label>
                        <div>
                            <input type="file" class="form-control input-lg" name="cheque_image" value="" required>
                        </div>
                    </div>
                    <div class="form-group amount_to_pay" hidden>
                        <label class="">Amount</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="amount" value="">
                        </div>
                    </div>
                </div>
                <div id="loader"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="makePayment" type="submit" value="Submit">Save changes</button>
                </div>
            </div>
        </form>

    </div>
</div>