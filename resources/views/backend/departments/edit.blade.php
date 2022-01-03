@extends('backend.layouts.default')

@section('page_title', 'Listing Departments')

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
                <h2>Listing Departments</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @include('backend.partials.error')

                <form method="post" action="{{ route('department.update',$department->id) }}" class="form-inline">
                    @method('put')
                    <form method="post" action="" class="form-inline">
                        <div class="form-group">
                            <label class="col-form-label name_label">Department Name</label>
                            <input type="text" name="name" class="form-control name_input" placeholder=" Enter Department Name" value="{{ $department->name }}">
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success btn_create">Update Department</button>
                    </form>
                    
                </form>
                <div class="ln_solid"></div>
            </div>
        </div>
    </div>
</div>

@stop
