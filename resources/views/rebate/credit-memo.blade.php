@extends('./layout/app')
@section('moreCss')
<style>
    label{
        /* font-size: 12px; */
    }
</style>
<!-- Sweet Alert -->
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css">
  
@endsection
@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <h4 class="page-title m-0">REBATE ENTRY</h4>
                </div>
                <div class="col-md-5">
                    <form id="searchInvoice">@csrf
                        <div class="input-group">
                            <select name="category" class="form-control bg-white" required>
                                    <option value="" selected disabled>Select Type</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" id="{{$category}}">{{ $category->catname }}</option>
                                @endforeach
                            </select>
                            <input type="text" class="form-control bg-white" placeholder="Please Select" name="search" required autocomplete="off" maxlength="10">
                            <div class="input-group-append">
                                <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i> Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card" id="mainCard">
    <div class="card-body">
  
    </div>
</div>


@endsection

@section('moreJs')
    <script src="{{  asset('assets/plugins/jquery-number/jquery.number.js') }} "></script>
    <!-- Sweet-Alert  -->
    <script src="{{  asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{  asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{  asset('assets/js/dashboard.js') }}"></script>
@endsection