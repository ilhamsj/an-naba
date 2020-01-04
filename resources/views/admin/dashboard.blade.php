@extends('layouts.admin')

@section('title_page', 'Dashboard')
@section('content')
<div class="row">
  @foreach ($data as $key => $val)
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-0 border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ $key }}</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($val) }}</div>
            </div>
            <div class="col-auto">
              <i class="fa fa-database fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
</div>

@endsection
