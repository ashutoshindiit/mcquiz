@extends('backend.layouts.default')

@section('page_title', 'Listing Users')

@section('style')
@stop

@section('content')

    @if( ! Auth::user()->can('manage_user'))
        @include('errors.401')
    @else        
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    User : {{ $user->full_name }}
                </h2>
                <a href="{{ route('scoreboard') }}" class="btn btn-success pull-right">Back to Scoreboard</a>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Quiz Name</th>
                                <th>Total Questions</th>
                                <th>Correct</th>
                                <th>Score</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($user->attempt as $attempt)
                            @php 
                                $total = $attempt->userQuestionAnswer->count();
                                $correct = $attempt->userQuestionAnswer->where('is_right',1)->count();
                                $percentage = ($correct/$total)*100;
                                $percentage_format = number_format((float)$percentage, 2, '.', '');
                            @endphp 
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attempt['quiz']['name'] }}</td>
                                <td>{{ $total }}</td>
                                <td>{{ $correct }}</td>
                                <td>{{ $percentage_format }} %</td>
                                <td>{{ $attempt['created_at']->format('F j, Y, g:i a') }} </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>

            </div>
        </div>
    @endif

@stop