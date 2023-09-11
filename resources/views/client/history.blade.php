@extends('layout.order')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Invoice #{{ $transaksi->id_transaksi }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Invoice #{{ $transaksi->id_transaksi }}</li>
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
                <div class="text-capitalize">Halaman ini telah disempurnakan untuk pencetakan. Klik tombol cetak di bagian bawah faktur untuk menguji.</div>
              </div>


                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Jenis Paket</th>
                        <th>Invoice</th>
                        <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                        <tbody>
                            <tr>
                                <td>{{ $transaksi->nama }}</td>
                                <td>
                                    @foreach ($allpaket as $pkt)
                                        @if ($transaksi->id_paket == $pkt->id)
                                            {{ $pkt->name }}
                                        @endif
                                    @endforeach
                                    @foreach ($allproduk as $prk)
                                    @if ($transaksi->id_produk == $prk->id)
                                        ({{ $prk->nama_produk }})
                                    @endif
                                @endforeach
                                </td>
                                <td>{{ $transaksi->id_transaksi }}</td>
                                <td>
                                    @if ($transaksi->status == "Lunas")
                                        <button type="button" class="btn btn-block btn-success">{{ $transaksi->status }}</button>
                                    @elseif ($transaksi->status == "Proses")
                                        <button type="button" class="btn btn-block btn-primary">{{ $transaksi->status }}</button>
                                    @elseif ($transaksi->status == "Belum Bayar")
                                        <button type="button" class="btn btn-block btn-warning">{{ $transaksi->status }}</button>
                                    @elseif ($transaksi->status == "Batal")
                                        <button type="button" class="btn btn-block btn-danger">{{ $transaksi->status }}</button>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">

                  <!-- /.col -->
                  <div class="col-12 col-sm-6">
                    <p class="lead"><b>Bayar Sebelum {{ $tgl_berangkat }}</b></p>

                    <div style="display: flex; align-items: center;">
                        <img src="{{ asset('lte/dist/img/bca.png') }}" alt="Bank BCA" width="100px" style="margin-right: 20px;">
                        <div style="text-align: left; font-weight: bold;">
                            <div style="margin-bottom: 5px;">622 501 3610</div>
                            <div>CITRA AYU DIYAH PITALOKA</div>
                        </div>
                    </div>

                    <div class="table-responsive">
                      <table class="table">
                        <tr>
                          <th>Subtotal</th>
                          <td>{{ formatRupiah($transaksi->total_harga) }}</td>
                        </tr>
                        <tr>
                          <th>Total:</th>
                          <td>{{ formatRupiah($transaksi->total_harga) }}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-12 col-sm-6">
                        <a href="https://api.whatsapp.com/send?phone=6282292829630&text=Halo Admin Bromocreative.com Tolong Cek Orderan Saya.%0ANama: {{ $transaksi->nama }}%0AInvoice: {{ $transaksi->id_transaksi }}%0AStatus Order: {{ $transaksi->status }}" target="_blank" class="btn btn-success float-left"><ion-icon name="logo-whatsapp"></ion-icon> Chat</a>
                        <a href="{{ route('invoice',['id' => $transaksi->id_transaksi]) }}" target="_blank" class="btn btn-dark float-left" style="margin-left: 5px;"><i class="fas fa-print"></i> Cetak</a>

                        @if ($today->lte($transaksi->tgl_berangkat))
                            @if ($transaksi->status == 'Belum Bayar')
                                <button type="button" class="btn btn-primary float-left" style="margin-left: 5px;" data-toggle="modal" data-target="#bayar"><i class="far fa-credit-card"></i> Bayar</button>
                            @else
                                <button type="button" class="btn btn-primary float-left" style="margin-left: 5px;" data-toggle="modal" data-target="#bayar" disabled><i class="far fa-credit-card"></i> Bayar</button>
                            @endif
                        @endif

                        @if (!$today->lte($transaksi->tgl_berangkat) && $transaksi->status == 'Lunas')
                            <button type="button" class="btn btn-primary float-left" style="margin-left: 5px;" data-toggle="modal" data-target="#ulasan"><i class="far fa-comments"></i> Beri Ulasan</button>
                        @endif
                    </div>
                </div>
              </div>
              <!-- /.invoice -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        {{-- Beri Ulasan --}}

        @if (!$today->lte($transaksi->tgl_berangkat) && $transaksi->status == 'Lunas')
            <form action="{{ route('ulasan',['id' => $transaksi->id_transaksi]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal fade" id="ulasan">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="callout callout-info">
                                Terima kasih telah menggunakan jasa kami, Ulasan anda sangat berarti.
                            </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="ulasan">Ulasan Anda:</label>
                                @if ($testi)
                                    <textarea type="longtext" class="form-control" id="ulasan" name="ulasan" placeholder="Beri Ulasan..." rows="5" disabled>{{ $testi->ulasan }}</textarea>
                                @else
                                    <textarea type="longtext" class="form-control" id="ulasan" name="ulasan" placeholder="Beri Ulasan..." rows="5"></textarea>
                                @endif
                                @error('ulasan')
                                    <small id="error-message">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            @if (!$testi)
                                <button type="submit" class="btn btn-success">Kirim</button>
                            @endif
                        </div>
                    </div>
                    <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </form>
        @endif

        {{-- Bayar --}}

        @if ($transaksi->status == 'Belum Bayar')
            <form action="{{ route('proof',['id' => $transaksi->id_transaksi]) }}" method="POST" enctype="multipart/form-data">
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
                        <a href="{{ route('invoice',['id' => $transaksi->id_transaksi]) }}" class="btn btn-primary float-right" style="margin-right: 5px;"><i class="fas fa-print"></i> Cetak</a>
                        <button type="submit" class="btn btn-success">Kirim</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </form>
        @endif

      </section>
    <!-- /.content -->
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    // Tampilkan SweetAlert jika ada pesan error pada elemen dengan nama 'file'
    @if ($errors->has('file'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ $errors->first('file') }}',
        });
    @endif

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Thanks!',
            text: '{{ session('success') }}', // Menampilkan pesan kesuksesan dari sesi
        });
    @endif

    // Menambahkan event listener hanya jika elemen dengan ID 'file' ada
    var fileInput = document.getElementById('file');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            // Hapus pesan error setiap kali pengguna memilih file baru
            var customFileLabel = document.querySelector('.custom-file-label');
            if (customFileLabel) {
                customFileLabel.textContent = 'Pilih File';
            }

            // Jika SweetAlert masih tampil, sembunyikan SweetAlert
            Swal.close();
        });
    }
</script>

<script>
    @if ($findtransaksi->isEmpty())
        Swal.fire({
            icon: 'error',
            title: 'ID Transaksi Tidak Ditemukan',
            text: 'Maaf, ID transaksi yang Anda cari tidak ditemukan.'
        }).then(function() {
            // Redirect ke halaman lain atau lakukan tindakan lain sesuai kebutuhan Anda.
            window.location.href = '{{ route('historys') }}'; // Gantilah 'route.name' dengan nama rute yang sesuai.
        });
    @endif


    // Mendapatkan pesan error
    var errorMessage = document.getElementById('error-message');

    // Mengecek apakah terdapat error pada input ulasan
    if (errorMessage && errorMessage.textContent.trim() !== '') {
        // Menampilkan SweetAlert dengan pesan error
        Swal.fire({
            icon: 'error',
            title: 'ERROR',
            text: errorMessage.textContent,
        });
    }


</script>

<script>
    $(function () {
        bsCustomFileInput.init();
    });

</script>

@endsection
