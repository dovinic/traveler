@extends('layout.main')
@section('content')

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
                <div class="card-header">

                  <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Nama Paket</th>
                        <th>Nama Produk</th>
                        <th>Total Harga</th>
                        <th>ID Transaksi</th>
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
                                </td>
                                <td>
                                    @foreach ($namaproduk as $pkts)
                                        @if ($d->id_produk == $pkts->id)
                                            {{ $pkts->nama_produk }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ formatRupiah($d->total_harga) }}</td>
                                <td>{{ $d->id_transaksi }}</td>
                                <td>
                                    @if ($d->status == "Lunas")
                                        <button type="button" class="btn btn-block btn-success">{{ $d->status }}</button>
                                    @elseif ($d->status == "Proses")
                                        <button type="button" class="btn btn-block btn-primary">{{ $d->status }}</button>
                                    @elseif ($d->status == "Belum Bayar")
                                        <button type="button" class="btn btn-block btn-warning">{{ $d->status }}</button>
                                    @elseif ($d->status == "Batal")
                                        <button type="button" class="btn btn-block btn-danger">{{ $d->status }}</button>
                                    @endif
                                <td>
                                    <a href="{{ route('admin.transaksi.edit',['id' => $d->id]) }}" class="btn btn-primary"><i class="fas fa-pen"></i> Edit</a>
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
                                      <p>Mau Hapus Paket <b>{{ $d->name }}</b>? Yakin Gak Kids?</p>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <form action="{{ route('admin.transaksi.delete',['id' => $d->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Gajadi</button>
                                            <button type="submit" class="btn btn-danger">Yakin la kids</button>
                                        </form>
                                    </div>
                                  </div>
                                  <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                              </div>
                              <!-- /.modal -->
                        @endforeach
                    </tbody>
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

@endsection
