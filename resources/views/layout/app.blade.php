<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Rebate</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="{{ csrf_token() }}" name="_token" />
        <meta content="{{ auth()->user()->RebateRole }}" name="_ucategory" />
        <meta content="{{ auth()->user()->Username }}" name="userIdentity" />
        <meta content="{{ auth()->user()->Position_id }}" name="positionID" />
        <meta content="{{ json_encode(App\Helper\Helper::$leaders) }}" name="leaders" />
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        @yield('moreCss')

        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <style>
            /* .dataTables_paginate{
                display: none;
            } */
        </style>
    </head>


    <body>

        <div class="header-bg">
            <!-- Navigation Bar-->
                @include('layout.header')
            <!-- End Navigation Bar-->
    
        </div>
        <!-- header-bg -->
        
        <div class="wrapper">
            <div class="container-fluid">
                    @yield('content')
            </div>
        </div>
        <!-- end wrapper -->
        @if ( in_array(request()->segment(2),['dashboard','approval']) )
            <x-date-range-modal :categories="$categories ?? []"/>
        @endif
        <!-- Footer -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                            © {{ date("Y") }} Rebate <span class="d-none d-md-inline-block"> - AIMI / IT</span>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer -->


        <!-- jQuery  -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
        <script src="{{ asset('assets/js/detect.js') }}"></script>
        <script src="{{ asset('assets/js/fastclick.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
        <script src="{{ asset('assets/js/waves.js') }}"></script>
        <script src="{{ asset('assets/js/wow.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>
        <script src="{{ asset('assets/js/moment.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquerySpellingNumber.js') }}"></script>

        
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script src="{{ asset('assets/js/global.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        @yield('moreJs')
        <script>
            $('.datepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                zIndexOffset: 10000,
            });
            $("input[name=to]").on('change',function(){
                BaseModel.datecheckRange(
                    $('input[name=from]').val(),
                    $(this).val()
                )
            })
            $("input[name=from]").on('change',function(){
                BaseModel.datecheckRange(
                    $(this).val(),
                    $('input[name=to]').val()
                )
            })

        //    $(".getReport").on('click',function(){
        //         $.ajax({
        //             type:'GET',
        //             url:"category/report/list"
        //         }).done(function(data){
        //             let _hold = '<option value="">Select Category</option>'
        //             data.forEach(element => {
        //                 _hold+=`<option value="${element.id}">${element.catname}</option>`
        //             });
        //             $("select[name=filtercategory]").html(_hold)
        //         }).fail(function (jqxHR, textStatus, errorThrown) {
        //             console.log(errorThrown);
        //         })
        //     })

        </script>

    </body>
</html