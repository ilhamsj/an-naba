@extends('layouts.admin')

@section('title_page', 'Kritik dan Saran')

@section('content')

<div class="row">
  <div class="col">
    <div class="card border-0 shadow mb-4">
      <a href="#collapseCardExample" class="d-block card-header py-3 border-0" data-toggle="collapse" role="button"
        aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">Data</h6>
      </a>
      <div class="collapse show" id="collapseCardExample">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Category</th>
                  <th>Content</th>
                  <th>Date</th>
                  <th>Tandai</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  $(document).ready(function () {
      // read
      var table = $('table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{route('reviews.index')}}",
        columns: [
          { data: 'name', name: 'name' },
          { data: 'email', name: 'email' },
          { data: 'category', name: 'category' },
          { data: 'content', name: 'content' },
          { data: 'created_at', name: 'created_at' },
          { data: 'action', name: 'action' },
        ]
      });
  });
</script>
@endpush