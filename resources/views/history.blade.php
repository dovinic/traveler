@extends('layout.order')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            @foreach ($transaksi as $d)
                <h1 class="m-0">Invoice #{{ $invoice }}</h1>
                @endforeach
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Invoice #{{ $invoice }}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="callout callout-info">
                <h5><i class="fas fa-info"></i> Catatan:</h5>
                Halaman ini telah disempurnakan untuk pencetakan. Klik tombol cetak di bagian bawah faktur untuk menguji.
              </div>


                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Paket</th>
                        <th>Produk</th>
                        <th>ID Transaksi</th>
                        <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                        <tbody>
                            @foreach ($transaksi as $d)
                                <tr>
                                    <td>{{ $d->nama }}</td>
                                    <td>
                                        @foreach ($allpaket as $pkt)
                                            @if ($d->id_paket == $pkt->id)
                                                {{ $pkt->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($allproduk as $prk)
                                            @if ($d->id_produk == $prk->id)
                                                {{ $prk->nama_produk }}
                                            @endif
                                        @endforeach
                                    </td>
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">

                  <!-- /.col -->
                  <div class="col-6">
                    <p class="lead">Bayar Sebelum {{ $tgl_berangkat[0] }}</p>

                    <div class="table-responsive">
                      <table class="table">
                        <tr>
                          <th>Subtotal</th>
                          <td>{{ formatRupiah($transaksi[0]->total_harga) }}</td>
                        </tr>
                        <tr>
                          <th>Total:</th>
                          <td>{{ formatRupiah($transaksi[0]->total_harga) }}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-6">
                        @if ($transaksi[0]->status == 'Belum Bayar')
                            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#bayar"><i class="far fa-credit-card"></i> Bayar</button>
                        @else
                            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#bayar" disabled><i class="far fa-credit-card"></i> Bayar</button>
                        @endif

                        <a href="{{ route('invoice',['id' => $transaksi[0]->id_transaksi]) }}" target="_blank" class="btn btn-primary float-right" style="margin-right: 5px;"><i class="fas fa-print"></i> Cetak</a>
                    </div>
                </div>
              </div>
              <!-- /.invoice -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <form action="{{ route('proof',['id' => $transaksi[0]->id_transaksi]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal fade" id="bayar">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info"></i> Catatan:</h5>
                            Silahkan Upload bukti pembayaran anda dibawah ini, Jika belum bayar silahkan cek invoice terlebih dahulu.
                        </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">Upload File</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="file" id="file" accept=".jpg, .jpeg, .png, .pdf">
                                    <label class="custom-file-label" for="file">Pilih File</label>
                                </div>
                            </div>
                            @error('file')
                                <small>{{ $message }}</small>
                            @enderror
                          </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="{{ route('invoice',['id' => $transaksi[0]->id_transaksi]) }}" class="btn btn-primary float-right" style="margin-right: 5px;"><i class="fas fa-print"></i> Cetak</a>
                    <button type="submit" class="btn btn-success">Kirim</button>
                    </div>
                </div>
                <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </form>

      </section>
    <!-- /.content -->
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    @if ($transaksi->isEmpty())
        Swal.fire({
            icon: 'error',
            title: 'ID Transaksi Tidak Ditemukan',
            text: 'Maaf, ID transaksi yang Anda cari tidak ditemukan.'
        }).then(function() {
            // Redirect ke halaman lain atau lakukan tindakan lain sesuai kebutuhan Anda.
            window.location.href = '{{ route('historys') }}'; // Gantilah 'route.name' dengan nama rute yang sesuai.
        });
    @endif
</script>
<script>
    $(function () {
        bsCustomFileInput.init();
    });
</script>

@endsection
