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

                <form method="post" action="{{ route('department.store') }}" class="form-inline">
                    
                    <form method="post" action="" class="form-inline">
                        <div class="form-group">
                            <label class="col-form-label name_label">Department Name</label>
                            <input type="text" name="name" class="form-control name_input" placeholder=" Enter Department Name">
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success btn_create">Create Department</button>
                    </form>
                    
                </form>
                <div class="ln_solid"></div>
                @if(empty($departments->count()))
                    <p>No Department found.</p>
                @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $key => $department)
                            <tr>
                                <th scope="row">{{ $key+1 }}</th>
                                <td>{{ $department->name }}</td>
                                <td>
                                    <a href="{{ route('department.edit', $department->id) }}" class="btn btn-sm btn-info action_btn" style="margin-right: 3px;">Edit</a>
                                    <form action="{{ route('department.destroy',$department->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this record?');">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button type="submit" name="Delete" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
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
