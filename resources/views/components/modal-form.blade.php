<div>
  <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header p-0">
          <h6 class="modal-title"></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="display"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- div for edit -->
<div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <form id="editForm" autocomplete="off">@csrf
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <input type="hidden" name="id">
                <input type="hidden" name="depOnAmount">
                <input type="hidden" class="form-control" name="category" readonly>
                <span class="msg"></span>
               <div class="form-row">
               <div class="form-group col-6">
                    <label for="">Category</label>
                    <input type="text" class="form-control" name="catname" readonly>
                </div>
                {{-- <div class="form-group col-6">
                    <label for="">Docnum</label>
                    <input type="text" class="form-control" name="docnum" readonly>
                </div> --}}
                <div class="form-group col-6">
                  <label for="">Reference</label>
                  <input type="text" class="form-control" name="reference" placeholder="Reference" readonly required>
              </div>
               </div>
                <div class="form-row">
                 
                  <div class="form-group col-6">
                      <label for="">Rebate Amount</label>
                      <input type="text" class="form-control" name="rebateAmount" placeholder="" required>
                  </div>
                  <div class="form-group col-6">
                      <label for="">Rebate Balance</label>
                      <input type="text" class="form-control" name="rebateBalance" readonly placeholder="Rebate Amount" maxlength="20">
                  </div>
                </div>
                <div class="form-group">
                    <label for="my-textarea">Reason</label>
                    <textarea id="my-textarea" class="form-control" name="reason" rows="6" placeholder="Type here" required onkeyup="BaseModel.countChar(this)" maxlength="500" readonly></textarea>
                    <span class="text-muted"><span class="showCountChar">0</span>/500</span>
                </div>
                <div class="form-group">
                    <label for="my-textarea">Reject Remarks</label>
                    <p class="p-remarks" style="font-size: 15px;"></p>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="btnSaveChanges">Save, Changes</button>
          </div>
      </form>
    </div>
  </div>
</div>
</div>