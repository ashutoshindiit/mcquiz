@extends('backend.layouts.default')

@section('page_title', 'Listing Quizs')

@section('style')
<style>
.invite_btn { width: 100%; }
</style>
@stop

@section('content')


<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><b>{{ $quiz->name }}</b></h2>
                <div class="clearfix"></div>
                <h2>Quiz Users:</h2>
                <a href="{{ route('quiz.index') }}" class="btn btn-success pull-right">Back to Quizs</a>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @include('backend.partials.error')

                @if(empty($quiz->userAttemptQuiz->count()))
                    <p>No Records found.</p>
                @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Attempt Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quiz->userAttemptQuiz as $key => $attempt)
                            <tr>
                                <th scope="row">{{ $key+1 }}</th>
                                <td>{{ $attempt->user->full_name }}</td>
                                <td>{{ $attempt->created_at->format('Y-m-d H:i:s') }}</td>
                                <td><a href="{{ route('quiz.report.user', [$quiz->slug, $attempt->user_id]) }}" class="btn btn-sm btn-info">View Answers</a> </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>

@stop

@section('script')

@stop