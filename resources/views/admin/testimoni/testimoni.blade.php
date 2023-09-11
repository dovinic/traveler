@extends('layout.main')
@section('content')

<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Testimonial</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Testimonial</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <table id="list-transaksi" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Invoice</th>
                        <th>Nama Paket</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->nama }}</td>
                                <td>{{ $d->invoice }}</td>
                                <td>{{ $d->paket }}</td>
                                <td>
                                    @if ($d->action == "Publik")
                                        <button type="button" class="btn btn-block btn-success">{{ $d->action }}</button>
                                    @else
                                        <button type="button" class="btn btn-block btn-danger">{{ $d->action }}</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="" data-toggle="modal" data-target="#modal-detail{{ $d->id }}" class="btn btn-primary"><i class="fas fa-pen"></i> Edit</a>
                                    <a href="" data-toggle="modal" data-target="#modal-hapus{{ $d->id }}" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Hapus</a>
                                </td>
                            </tr>

                            <div class="modal fade" id="modal-hapus{{ $d->id }}">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <p>Mau Hapus Ulasan <b>{{ $d->nama }}</b>?</p>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <form action="{{ route('admin.transaksi.delete',['id' => $d->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="justify-content-between">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                  </div>
                                  <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                              </div>


                                <div class="modal fade" id="modal-detail{{ $d->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <form action="{{ route('admin.testimoni.update',['id' => $d->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Ulasan dari <b>{{ $d->nama }}</b></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-12">
                                                    <!-- general form elements -->
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Bromo Creative</h3>
                                                        </div>
                                                        <div class="row">
                                                            <div class="card-body col-md-12">
                                                                <div class="form-group">
                                                                    <label for="ulasan">Ulasan</label>
                                                                    <textarea type="longtext" class="form-control" id="ulasan" name="ulasan" rows="5" disabled>{{ $d->ulasan }}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="action">Action</label>
                                                                    <select name="action" id="action" class="form-control">
                                                                        <option value="Hidden" {{ $d->action == 'Hidden' ? 'selected' : '' }}>Hidden</option>
                                                                        <option value="Publik" {{ $d->action == 'Publik' ? 'selected' : '' }}>Publik</option>
                                                                    </select>
                                                                    @error('action')
                                                                        <small>{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>

                              <!-- /.modal -->
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Invoice</th>
                            <th>Nama Paket</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


<!-- jQuery -->
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('lte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('lte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
    $(function () {
        $("#list-transaksi").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#list-transaksi_wrapper .col-md-6:eq(0)');
    });
</script>

@endsection
