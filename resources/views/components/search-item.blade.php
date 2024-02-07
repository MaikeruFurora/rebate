<!-- Modal -->
<div class="modal fade" id="searchData" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="searchDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header p-1">
          <h5 class="modal-title" id="searchDataLabel">Search Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <form action="{{ route('authenticate.approval.search') }}" id="searchForm" autocomplete="off">@csrf
                    <div class="input-group border my-3">
                        <input type="search" class="form-control" name="search" placeholder="Search" aria-label="" aria-describedby="button-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-secondary" type="submit" id="button-addon2">Search</button>
                        </div>
                    </div>
                </form>
                <table id="datatableSearchData" class="table table-bordered"  style="border-collapse: collapse; width: 100%;font-size:11px">
                    <thead class="table-dark">
                        <tr style="font-size:11px">
                            <td width="15%">Category</td>
                            <td>DocDate</td>
                            <td>Client Name</td>
                            <td>EncodedBy</td>
                            <td>RebateAmount</td>
                            <td>Rebate Bal</td>
                            <td>Reference</td>
                            <td>SeriesCode</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
      </div>
    </div>
</div>