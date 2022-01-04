@extends('backend.layouts.default')

@section('page_title', 'Dashboard')

@section('style')
<link href="{{ asset('vendors/reportrange/css/daterangepicker.css') }}" rel="stylesheet">
@stop

@section('content')
    
<div class="page-title">
    <div class="title_left">
        <h3>Dashboard</h3>
    </div>
    <div class="title_right">
        <div class="col-md-5 col-sm-5   form-group pull-right top_search">
            <div class="input-group">
                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="row">
            <div class="col-sm-3">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-account-multiple widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Quiz</h5>
                        <h3 class="mt-3 mb-3 report_quiz"></h3>
                    </div>
                </div> 
            </div>
            @if(Auth::user()->hasRole('Super Admin'))
            <div class="col-sm-3">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-account-multiple widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Departments</h5>
                        <h3 class="mt-3 mb-3 report_departments"></h3>
                    </div>
                </div> 
            </div>   
            <div class="col-sm-3">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-account-multiple widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Admin</h5>
                        <h3 class="mt-3 mb-3 report_admins"></h3>
                        <p class="mb-0 text-muted">
                    </div>
                </div> 
            </div>   
            @endif 
            <div class="col-sm-3">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-account-multiple widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Total Users</h5>
                        <h3 class="mt-3 mb-3 report_users"></h3>
                    </div>
                </div> 
            </div>                             
        </div>
    </div>   
</div>
<div class="row">
    
</div>

@stop

@section('script')
<script src="{{ asset('vendors/reportrange/js/moment.min.js') }}"></script>
<script src="{{ asset('vendors/reportrange/js/daterangepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
    
        var start = moment('1970-01-01');
        var end = moment();

        function cb(start, end) {
            if(start.format('DD/MM/YYYY') == '01/01/1970') {
                $('#reportrange span').html('All time');
            }else {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));          
            }            
        }
        
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'All time': [moment('1970-01-01'), moment()],
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
    
        cb(start, end);

        var startDate = $('#reportrange').data('daterangepicker').startDate.format('Y-MM-DD HH:mm:ss');
        var endDate = $('#reportrange').data('daterangepicker').endDate.format('Y-MM-DD HH:mm:ss'); 
        function filterData(start,end)
        {
            $.ajax({
                url:"{{ route('filtered_data')}}" + '/' + start + '/' + end,
                //  url:"",
                success:function(data) {
                    var data = data.data;
                    $('.report_departments').text(data.department_count);
                    $('.report_quiz').text(data.quiz_count);
                    $('.report_admins').text(data.admin_count);
                    $('.report_users').text(data.user_count);
                }
            });  
        }

        filterData(startDate , endDate);

        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            console.log(ev);
            console.log(picker);
            var startdate = picker.startDate.format('YY-MM-DD HH:mm:ss');
            var enddate = picker.endDate.format('YY-MM-DD HH:mm:ss');
            
            filterData(startdate , enddate);
        });

    });
</script>
@stop