@extends('layout.order')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Form Order</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">{{ $paket->name }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Silahkan Lengkapi Pemesanan Anda</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('order.send') }}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukan Nama Anda">
                    @error('nama')
                        <small>{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="phone_number">Nomor HP</label>
                    <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Misal: 8123456789">
                    @error('phone_number')
                        <small>{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="id_paket">Jenis Paket</label>
                    <select name="id_paket" id="id_paket" class="form-control">
                        <option value="{{ $paket->id }}" selected>{{ $paket->name }}</option>
                    </select>
                    @error('id_paket')
                        <small>{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="id_produk">Jumlah Orang</label>
                    <select name="id_produk" id="id_produk" class="form-control">
                        <option value="" selected disabled>- PILIH -</option>
                        @foreach ($produk as $pkt)
                            <option value="{{ $pkt->id }}">{{ $pkt->nama_produk }}</option>
                        @endforeach
                    </select>
                    @error('id_produk')
                        <small>{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="kota">Lokasi Jemput</label>
                    <select name="kota" id="kota" class="form-control">
                        @foreach ($kota as $city)
                            <option value="{{ $city->kota }}">{{ $city->kota }} (+{{ formatRupiah($city->harga) }})</option>
                        @endforeach
                    </select>
                    @error('kota')
                        <small>{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label>Tanggal Berangkat:</label>
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                          <input type="text" name="tgl_berangkat" id="tgl_berangkat" class="form-control datetimepicker-input" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask data-target="#reservationdate"/>
                          <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                    @error('tgl_berangkat')
                        <small>{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="form-group">
                     {!! NoCaptcha::renderJs('id', false, 'recaptchaCallback') !!}
                    {!! NoCaptcha::display(['data-theme' => 'light']) !!}
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                    @endif
                  </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
          </div>
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Rincian Transaksi</h3>
              </div>
                <div class="card-body">
                    <label for="info">Keterangan :</label>
                    <textarea class="form-control form-control-lg" id="info" name="info" rows="6" readonly>-</textarea>
                    <br>
                    <label for="price">Total Harga:</label>
                    <input type="text" class="form-control form-control-lg" id="price" name="price" disabled placeholder="-">
                </div>
                <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.card -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    $(function () {
        $('#reservationdate').datetimepicker({
            format: 'L'
        });

        $('[data-mask]').inputmask()
    });

    // Mendengarkan perubahan pada select paket
    $('#id_produk').on('change', function () {
        var idProduk = $(this).val();

        function formatRupiah(angka) {
            var rupiah = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(angka);
            return rupiah;
        }

        // Mengirim permintaan AJAX untuk mendapatkan produk berdasarkan paket yang dipilih
        $.ajax({
            url: '/get-price/' + idProduk,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Menghapus isi sebelumnya di input type text
                $('#price').val('');
                $('#info').val('');

                // Menambahkan data produk ke dalam input type text
                $.each(data, function (index, price) {
                    $('#price').val($('#price').val() + formatRupiah(price.harga) + '\n');
                    $('#info').val($('#info').val() + price.info + '\n');
                });
            },
            error: function () {
                console.log('Terjadi kesalahan saat mengambil produk.');
            }
        });
    });
</script>



@endsection
