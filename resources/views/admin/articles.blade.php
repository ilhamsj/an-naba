@extends('layouts.admin')

@section('title_page', 'Blog')
@section('title_content')
<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="tambah_data">
  <i class="fa fa-plus-circle fa-sm text-white-50" aria-hidden="true"></i>
  Tambah Data
</a>
@endsection
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
                  <th>Cover</th>
                  <th>Title</th>
                  <th>Kategori</th>
                  <th>Update</th>
                  <th>Publish</th>
                  <th>ِِAksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ Str::title(Str::after(URL::current(), env('APP_URL'))) }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          @csrf

        <div class="form-group">
          <label for="">Kategori</label>
          <select class="form-control" name="category_id" id="category_id">
            @foreach ($categories as $item)
                <option value="{{ $item->id }}"> {{ $item->name }} </option>
            @endforeach
          </select>
        </div>

          <div class="form-group">
            <label for="">Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
              placeholder="" value="{{ old('email') ? old('email') : '' }}">
          </div>

          <div class="form-group">
            <label for="content">Content</label>
            <div class="spinner-grow text-danger collapse" id="loading_summernote" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <textarea class="form-control" name="content" id="content"
              rows="10">{{ old('content') ? old('content') : '' }}</textarea>
          </div>

        <div class="row">  
          <div class="form-group col">
            <img data-src="holder.js/500x300?auto=yes&textmode=exact&random=yes" class="img-fluid rounded" id="output_image"/>
          </div>
          <div class="form-group col">
            <label for="">Cover</label>
            <input onchange="preview_image(event)" type="file" class="form-control-file" name="cover" id="cover" placeholder="" aria-describedby="fileHelpId">
          </div>
        </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="">Message</button>
        <div class="spinner-grow text-danger collapse" id="loading" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('styles')
        <link href="{{ secure_url('vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ secure_url('vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
<script>
  preview_image = (event) => {
    var reader = new FileReader();
    reader.onload = function()
    {
      var output = document.getElementById('output_image');
      output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
  }
  $(document).ready(function () {

      // read
      var table = $('table').DataTable({
          order : [[3,'desc']],
          responsive: true,
          processing: true,
          serverSide: true,
          ajax: "/api/v1/artikel",
          columns: [
              { data: 'cover', name: 'cover' },
              { data: 'title', name: 'title' },
              { data: 'category', name: 'category' },
              { data: 'updated_at', name: 'updated_at' },
              { data: 'created_at', name: 'created_at' },
              { data: 'action', name: 'action' }
          ]
      });

      // delete content
      $('table').on('click', '.btnDelete', function (e) {
        e.preventDefault()

        var url = $(this).attr('data-url');
        $.ajax({
          type: "DELETE",
          url: url,
          success: function (response) {
            console.log(response);
            table.draw()
            showMessage(response.status)
          }
        });
      });

      // edit
      $('table').on('click', '.btnEdit', function (e) {
        e.preventDefault()

        hapusError()

        var url   = $(this).attr('href')
        var modal = $('#modelId').modal('show');

        $('#modelId').find('.modal-footer > button:nth-child(2)').text('Update').attr('id', 'updateContent').attr('data-url', url);

        $.ajax({
          type: "GET",
          url: url,
          success: function (response) {
            $.each(response, function (index, value) {
              console.log(index + ' :' + value);
              if(index == 'content') {
                $('form').find('.note-editor > .note-editing-area > .note-editable').html(value);
                $('textarea').val(value);
              } else if(index == 'cover') {
                $('#modelId').find('img').attr('src', '../'+value)
              } else {
                $('#'+index).val(value)
              }
            });
          }
        });
      });

      // update
      $('#modelId').on('click', '#updateContent', function (e) {

        hapusError();
        $('#loading').show();

        var url   = $(this).attr('data-url');
        var form  = $('#modelId').find('form')[0];
        var data  = new FormData(form);
        data.append('_method', 'PUT');

        $.ajax({
          type: "POST",
          url: url,
          data: data,
          contentType: false,
          processData: false,
          cache: false,
          success: function (response) {
            console.log(response);
            table.draw();
            $('#loading').hide();
            $('#modelId').modal('hide');
            showMessage(response.status);
          },
          error: function (xhr) {
            displayError(xhr.responseJSON);
            $('#loading').hide();
          }
        });
      });

      // modal show
      $('#tambah_data').click(function (e) { 
        e.preventDefault();
        $('#modelId').modal('show');
        $('#modelId').find('img').attr('src', '{{ secure_url("asset/cover.svg") }}');
        $('#modelId').find('.modal-footer > button:nth-child(2)').text('Simpan').attr('id', 'publishContent');
      });

      // store data
      $('#modelId').on('click', '#publishContent', function (e) {
        e.preventDefault();

        $('#loading').show();

        var form = $('#modelId').find('form')[0];
        var data = new FormData(form);

        hapusError()

        $.ajax({
          type: "POST",
          url: "/api/v1/artikel",
          data: data,
          contentType: false,
          processData: false,
          cache: false,
          success: function (response) {
            console.log(response);
            table.draw();
            $('#modelId').modal('hide');
            showMessage(response.status);
            $('#loading').hide();
          },
          error: function (xhr) {
              displayError(xhr.responseJSON);
              console.log(xhr.responseText);
              $('#loading').hide();
          }
        });
      });

      // summernote
      $('form') .find('#content').summernote({
          tabsize: 2,
          height: 500,
          followingToolbar: false,
          callbacks: {
            onMediaDelete : function(files) {
              var file = files[0].src;
              var nama_file = file.replace('{{ env("APP_URL")}}images/', '')
              deleteImage(nama_file)
            },
            onImageUpload: function(files) {
              uploadImage(files[0]);
            },
          }
      });

      // summernote
      function deleteImage(file) {
        $.ajax({
          type: "DELETE",
          url: "../api/v1/file/"+file,
          beforeSend: function (xhr) {
            $('#loading_summernote').show();
          },
          success: function (response) {
            console.log(response);
          },
          complete: function () {
            $('#loading_summernote').hide();
          },
        });
      }

      // summernote
      function uploadImage(files) {

        var data = new FormData();
        data.append("file", files);
        
        $.ajax({
          type: "POST",
          url: "/api/v1/file",
          contentType: false,
          cache: false,
          processData: false,
          data: data,
          beforeSend: function (xhr) {
            $('#loading_summernote').show();
            console.log('beforesend');
          },
          success: function (response) {
            console.log('success');
            $('form').find('#content').summernote('insertImage', response);
          },
          complete: function () {
            $('#loading_summernote').hide();
            console.log('complete');
          },
        });
      }

      // show error
      function displayError(res) {
        if ($.isEmptyObject(res) == false)
        {
          $.each(res.errors, function (key, value) {
            if(key != 'content') {
              $('#' + key)
                .closest('.form-group')
                .append('<span class="invalid-feedback" role="alert"> <strong>'+ value +'</strong> </span>')
                .find('input').addClass("is-invalid")
            } else {
              $('.note-editor')
                .closest('.form-group')
                .append('<span class="invalid-feedback" role="alert"> <strong>'+ value +'</strong> </span>')
                .find('.note-editor').addClass("is-invalid")
            }
          })
        }
      }

      function hapusError()
      {
        $('.invalid-feedback').remove();
        $('.form-group').find('input').removeClass("is-invalid");
        $('.form-group').find('.note-editor').removeClass("is-invalid");
      }

    }); // end doc ready
</script>
@endpush