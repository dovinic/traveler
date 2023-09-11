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
            <h1 class="m-0">History Transaksi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">History Transaksi</li>
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
                        <th>Nama Paket</th>
                        <th>Total Harga</th>
                        <th>Invoice</th>
                        <th>Trip Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->nama }}</td>
                                <td>
                                    @foreach ($namapaket as $pkt)
                                        @if ($d->id_paket == $pkt->id)
                                            {{ $pkt->name }}
                                        @endif
                                    @endforeach
                                    @foreach ($namaproduk as $pkts)
                                        @if ($d->id_produk == $pkts->id)
                                            ({{ $pkts->nama_produk }})
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ formatRupiah($d->total_harga) }}</td>
                                <td>{{ $d->id_transaksi }}</td>
                                <td>{{ \Carbon\Carbon::parse($d->tgl_berangkat)->format('Y-m-d') }}</td>
                                <td>
                                    @if ($d->status == "Lunas")
                                        <a href="{{ route('admin.view-file', ['filename' => $d->file]) }}" target="_blank" class="btn btn-block btn-success">{{ $d->status }}</a>
                                    @elseif ($d->status == "Proses")
                                        <a href="{{ route('admin.view-file', ['filename' => $d->file]) }}" target="_blank" class="btn btn-block btn-primary">{{ $d->status }}</a>
                                    @elseif ($d->status == "Belum Bayar")
                                        <button type="button" class="btn btn-block btn-warning">{{ $d->status }}</button>
                                    @elseif ($d->status == "Batal")
                                        <button type="button" class="btn btn-block btn-danger">{{ $d->status }}</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.transaksi.edit',['id' => $d->id]) }}" class="btn btn-primary"><i class="fas fa-pen"></i> Edit</a>
                                    <a href="" data-toggle="modal" data-target="#modal-detail{{ $d->id }}" class="btn btn-secondary"><i class="fas fa-list"></i> Detail</a>
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
                                      <p>Mau Hapus Data <b>{{ $d->name }}</b>?</p>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <form action="{{ route('admin.transaksi.delete',['id' => $d->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                  </div>
                                  <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                              </div>

                              <div class="modal fade" id="modal-detail{{ $d->id }}">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Detail Info - <b>{{ $d->nama }}</b></h4>
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
                                              <!-- /.card-header -->
                                              <!-- form start -->
                                              <div class="row">
                                                <div class="card-body col-md-6">
                                                  <div class="form-group">
                                                    <label for="ridho">Nama</label>
                                                    <input type="text" class="form-control" value="{{ $d->nama }}" disabled>
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="ridho">Jenis Paket</label>
                                                    <input type="text" class="form-control" value="@php
                                                            $selectedPackageName = null; // Default value

                                                            foreach ($namapaket as $pkt) {
                                                                if ($d->id_paket == $pkt->id) {
                                                                    $selectedPackageName = $pkt->name;
                                                                    break; // Keluar dari perulangan jika sudah ditemukan
                                                                }
                                                            }

                                                            echo $selectedPackageName;
                                                        @endphp (@php
                                                            $selectedPackageName = null; // Default value

                                                            foreach ($namaproduk as $pkt) {
                                                                if ($d->id_produk == $pkt->id) {
                                                                    $selectedPackageName = $pkt->nama_produk;
                                                                    break; // Keluar dari perulangan jika sudah ditemukan
                                                                }
                                                            }

                                                            echo $selectedPackageName;
                                                        @endphp)" disabled>
                                                </div>

                                                  <div class="form-group">
                                                    <label for="ridho">Total Harga</label>
                                                    <input type="text" class="form-control" value="{{ formatRupiah($d->total_harga) }}" disabled>
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="ridho">Nomor HP</label>
                                                    <a href="https://api.whatsapp.com/send?phone=62{{ $d->phone_number }}" target="_blank" class="btn btn-block btn-dark">0{{ $d->phone_number }}</a>
                                                  </div>
                                                </div>

                                                <!-- /.card-body -->
                                                <div class="card-body col-md-6">
                                                    <div class="form-group">
                                                      <label for="ridho">Invoice</label>
                                                      <input type="text" class="form-control" value="{{ $d->id_transaksi }}" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                      <label for="ridho">Penjemputan</label>
                                                      <input type="text" class="form-control" value="{{ $d->penjemputan }}" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ridho">Trip Date</label>
                                                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($d->tgl_berangkat)->format('Y-m-d') }}" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ridho">Status / Bukti Bayar</label>
                                                        @if ($d->status == "Lunas")
                                                            <a href="{{ route('admin.view-file', ['filename' => $d->file]) }}" target="_blank" class="btn btn-block btn-success">{{ $d->status }}</a>
                                                        @elseif ($d->status == "Proses")
                                                            <a href="{{ route('admin.view-file', ['filename' => $d->file]) }}" target="_blank" class="btn btn-block btn-primary">{{ $d->status }}</a>
                                                        @elseif ($d->status == "Belum Bayar")
                                                            <button type="button" class="btn btn-block btn-warning">{{ $d->status }}</button>
                                                        @elseif ($d->status == "Batal")
                                                            <button type="button" class="btn btn-block btn-danger">{{ $d->status }}</button>
                                                        @endif
                                                    </div>
                                              </div>
                                        </div>
                                    </div>
                                  </div>
                                  <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                              </div>
                              <!-- /.modal -->
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Nama Paket</th>
                            <th>Total Harga</th>
                            <th>Invoice</th>
                            <th>Trip Date</th>
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
