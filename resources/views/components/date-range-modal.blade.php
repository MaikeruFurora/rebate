<div class="modal fade" id="dateRangeModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="dateRangeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <form target="_blank" action="{{ route('authenticate.report.by.filter') }}" autocomplete="off" method="post">@csrf
            <div class="modal-header p-1">
              <h5 class="modal-title" id="dateRangeModalLabel">Filter Report</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Type of report</label>
                    <select name="type" class="custom-select custom-select-sm">
                        <option value="reportByCategory">Report By Category</option>
                        <option value="reportByStatus">Report By Status</option>
                        <option value="rebateUsed">Rebate Used</option>
                        <option value="rebateUnused">Rebate Unused</option>
                    </select>
                </div>
                {{-- <div class="form-group">
                  <label for="">Category</label>
                  <select name="filtercategory" class="custom-select custom-select-sm"></select>
                </div> --}}
                <div class="input-daterange" id="report-range-modal">
                    <div class="form-group">
                        <label for="">Date From</label>
                        <input type="text" class="form-control form-control-sm datepicker" name="from" required>
                    </div>
                    <div class="form-group">
                        <label for="">Date To</label>
                        <input type="text" class="form-control form-control-sm datepicker" name="to" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-sm" name="btnSaveChanges">Filter</button>
            </div>
        </form>
      </div>
    </div>
  </div>