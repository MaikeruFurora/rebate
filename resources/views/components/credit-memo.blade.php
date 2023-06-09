<!-- Modal -->
<form action="{{ route('authenticate.cm.print') }}"  target="_blank">@csrf
<div class="modal fade" id="creditMemo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="creditMemoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header p-0">
                <h6 class="modal-title" id="creditMemoLabel">CREDIT MEMO</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-2">
                    <input type="hidden" name="header">
                   <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="mb-0">Customer</label>
                            <input type="text" class="form-control" placeholder="Please enter customer" name="clientname" readonly>
                            <label for="mb-0">Address</label>
                            <textarea class="form-control" placeholder="Please enter address" name="address"  rows="4"></textarea>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group ">
                            <label for="mb-0">Date (Rebate Approved)</label>
                            <input type="text" class="form-control" placeholder="Please enter date" readonly name="approved_at">
                            <label for="mb-0">TIN</label>
                            <input type="text" class="form-control" placeholder="Please enter TIN" name="tin" maxlength="20">
                            <label for="mb-0">Bus Style</label>
                            <input type="text" class="form-control" placeholder="Please enter Bus Style" name="business_style">
                        </div>
                    </div>
                   </div>
                   <div class="row border-top">
                        <div class="col-8">
                            <div class="form-group">
                                <label for="mb-0" id="amountToWord">Amount to Word</label>
                                <input type="text" class="form-control" placeholder="Please enter" name="numbertoword">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mb-0">Amount</label>
                                <input type="text" class="form-control" readonly name="rebateAmount">
                            </div>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-12">
                           
                            <div class="form-group">
                                <label for="mb-0">Description</label>
                                <textarea id="my-textarea" class="form-control" rows="3" name="details"></textarea>
                            </div>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <div class="form-group mb-0 p-0 row">
                                    <label for="" class="col-sm-2 col-form-label">Invoice</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" maxlength="15" name="invoice">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group mb-0 p-0 row">
                                    <label for="" class="col-sm-2 col-form-label">DR</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="" maxlength="15" name="dr">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="form-group mb-0 p-0 row">
                                    <label for="" class="col-sm-3 col-form-label">PO</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="" maxlength="15" name="po">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group mb-0 p-0 row">
                                    <label for="" class="col-sm-3 col-form-label">Rebate</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="" maxlength="15" name="seriescode" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group mb-0 p-0 row">
                                    <label for="" class="col-sm-3 col-form-label">CM Docs</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="" maxlength="15" name="cm_docs">
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>
                </div>
                <div class="modal-footer p-1">
                    <button type="button" style="font-size:11px" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" style="font-size:11px" class="btn btn-primary" id="print">Print</button>
                </div>
            </div>
        </div>
    </div>
</form>