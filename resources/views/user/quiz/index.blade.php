@extends('user.layouts.default')

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
                <h2>Todays Quiz</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @include('backend.partials.error')

                @if(empty($quizs->count()))
                    <p>No Quiz found.</p>
                @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Questions</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quizs as $key => $quiz)
                            <tr>
                                <th scope="row">{{ $key+1 }}</th>
                                <td>{{ $quiz->name }}</td>
                                <td>{{ $quiz->questions_count }} {{ ($quiz->questions_count > 0) ? 'Questions' : 'Question'; }} </td>
                                <td>
                                    @if($quiz->is_attempt_count !=1)
                                    <a href="{{ route('user.quiz.view', $quiz->slug) }}" class="btn btn-sm btn-info">Join Quiz</a> 
                                    @else
                                    <a href="javascript:void(0);" class="btn btn-sm btn-info">Already Attempt</a> 
                                    @endif
                                </td>
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
<script>

setShareLinks();

function socialWindow(url) {
  var left = (screen.width - 570) / 2;
  var top = (screen.height - 570) / 2;
  var params = "menubar=no,toolbar=no,status=no,width=570,height=570,top=" + top + ",left=" + left;
  // Setting 'params' to an empty string will launch
  // content in a new tab or window rather than a pop-up.
  // params = "";
  window.open(url,"NewWindow",params);
}

function setShareLinks() {
  var pageUrl = encodeURIComponent(document.URL);
  var tweet = encodeURIComponent($("meta[property='og:description']").attr("content"));

  $(".social-share.twitter").on("click", function() {
    url = "https://twitter.com/intent/tweet?url=" + pageUrl + "&text=" + tweet;
    socialWindow(url);
  });
}  
</script>
@stop