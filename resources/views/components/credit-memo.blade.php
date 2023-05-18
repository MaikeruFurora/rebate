<!-- Modal -->
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
                <form>
                   <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="mb-0">Customer</label>
                            <input type="text" class="form-control" placeholder="Please enter customer">
                            <label for="mb-0">Address</label>
                            <input type="text" class="form-control" placeholder="Please enter address">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group ">
                            <label for="mb-0">Date</label>
                            <input type="text" class="form-control" placeholder="Please enter date">
                            <label for="mb-0">TIN</label>
                            <input type="text" class="form-control" placeholder="Please enter TIN">
                            <label for="mb-0">Bus Style</label>
                            <input type="text" class="form-control" placeholder="Please enter Bus Style">
                        </div>
                    </div>
                   </div>
                   <div class="row border-top">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="mb-0">Amount</label>
                                <input type="text" class="form-control" placeholder="Please enter address">
                            </div>
                            <div class="form-group">
                                <label for="mb-0">Description</label>
                                <textarea id="my-textarea" class="form-control" name="" rows="3"></textarea>
                            </div>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <div class="form-group mb-0 p-0 row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Invoice</label>
                                    <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputEmail3">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group mb-0 p-0 row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">DR</label>
                                    <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputEmail3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="form-group mb-0 p-0 row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">PO</label>
                                    <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputEmail3">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group mb-0 p-0 row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Rebate</label>
                                    <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputEmail3">
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>
                </form>
            </div>
            <div class="modal-footer p-1">
                <button type="button" style="font-size:11px" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" style="font-size:11px" class="btn btn-primary btn-sm">Save & print</button>
            </div>
        </div>
    </div>
</div>