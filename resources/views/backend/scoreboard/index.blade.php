@extends('backend.layouts.default')

@section('page_title', 'Listing Users')

@section('style')
<link href="{{ asset('vendors/reportrange/css/daterangepicker.css') }}" rel="stylesheet">
@stop

@section('content')

    @if( ! Auth::user()->can('manage_user'))
        @include('errors.401')
    @else  
          
        <div class="x_panel">
            <div class="row">
                <div class="title_left col-md-6">
                    <h2>
                        Users Scoreboard
                    </h2>
                </div>
                <div class="col-md-6 form-group">
                    <select class="form-control" data-role="select-dropdown" name="department">
                        <option value="">Choose Department</option>
                        @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ ucfirst($department->name) }}</option>
                        @endforeach
                    </select>  
                    <div class="input-group">
                        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>                   
                </div>                     
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped data-table">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Total Score</th>
                                <th>View</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ (($users->currentPage() - 1 ) * $users->perPage() ) + $loop->iteration }}</td>
                                <td>{{ ucwords($user->first_name) }}</td>
                                <td>{{ ucwords($user->last_name) }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->department['name'] }}</td>
                                <td>{{  $user->designation }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}
                                <td>{{ ($user->user_question_ans_count/$user->user_question_count)*100 }} %</td>
                                <td><a href="{{ route('scoreboard.user', $user->id) }}" class="btn btn-sm btn-info action_btn" style="margin-right: 3px;">View</a></td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <div>Showing
                        {{ ($users->currentpage()-1) * $users->perpage()+1}} to
                        {{(($users->currentpage()-1) * $users->perpage())+$users->count()}} of
                        {{$users->total()}} records
                    </div>

                    {{ $users->links() }}
                </div>

            </div>
        </div>
    @endif

@stop

@section('script')
<script src="{{ asset('vendors/reportrange/js/moment.min.js') }}"></script>
<script src="{{ asset('vendors/reportrange/js/daterangepicker.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
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
            // $.ajax({
            //     url:"{{ route('filtered_data')}}" + '/' + start + '/' + end,
            //     //  url:"",
            //     success:function(data) {
            //         var data = data.data;
            //         $('.report_departments').text(data.department_count);
            //         $('.report_quiz').text(data.quiz_count);
            //         $('.report_admins').text(data.admin_count);
            //         $('.report_users').text(data.user_count);
            //     }
            // });  
        }

        //filterData(startDate , endDate);

        // $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        //     console.log(ev);
        //     console.log(picker);
        //     var startdate = picker.startDate.format('YY-MM-DD HH:mm:ss');
        //     var enddate = picker.endDate.format('YY-MM-DD HH:mm:ss');
            
        //     filterData(startdate , enddate);
        // });

        var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "",
        columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        
    });
</script>
@stop