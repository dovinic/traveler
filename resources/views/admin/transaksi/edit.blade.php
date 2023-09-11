@extends('layout.main')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Ubah Transaksi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Ubah Transaksi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.transaksi.update',['id' => $data->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                  <!-- left column -->
                  <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">Form Ubah Transaksi</h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      <form>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="nama" value="{{ $data->nama }}" disabled>
                                @error('nama')
                                    <small>{{ $message }}</small>
                                @enderror
                              </div>
                          <div class="form-group">
                            <label for="id_paket">Nama Paket</label>
                            <select name="id_paket"  id="id_paket" class="form-control">
                                @foreach($namapaket as $paket)
                                    @if ($data->id_paket == $paket->id)
                                        <option value="{{ $paket->id }}" selected>{{ $paket->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('id_paket')
                                <small>{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label for="id_produk">Nama Produk</label>
                            <select name="id_produk" id="id_produk" class="form-control">
                                @foreach($namaproduk as $produk)
                                    @if ($data->id_produk == $produk->id)
                                        <option value="{{ $produk->id }}" selected>{{ $produk->nama_produk }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('id_produk')
                                <small>{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label for="total_harga">Total Harga</label>
                            <input type="number" class="form-control" id="total_harga" name="total_harga" value="{{ $data->total_harga }}" placeholder="Masukan Jumlah Harga">
                            @error('total_harga')
                                <small>{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label for="id_transaksi">ID Transaksi</label>
                            <input type="text" class="form-control" id="id_transaksi" name="id_transaksi" value="{{ $data->id_transaksi }}" disabled>
                            @error('id_transaksi')
                                <small>{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label for="status">Status Pesanan</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Lunas" {{ $data->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="Proses" {{ $data->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Belum Bayar" {{ $data->status == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                                <option value="Batal" {{ $data->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                            </select>
                            @error('status')
                                <small>{{ $message }}</small>
                            @enderror
                          </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                            @if ($data->status != 'Belum Bayar')
                                <a href="{{ route('admin.view-file', ['filename' => $data->file]) }}" target="_blank" class="btn btn-primary">Lihat Bukti Bayar</a>
                            @endif
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
            </form>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
    <!-- /.content -->
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Mendengarkan perubahan pada select paket
    $('#id_paket').on('change', function () {
        var idPaket = $(this).val();

        // Mengirim permintaan AJAX untuk mendapatkan produk berdasarkan paket yang dipilih
        $.ajax({
            url: '/admin/get-products-by-paket/' + idPaket,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Menghapus opsi sebelumnya di select produk
                $('#id_produk').empty();

                // Menambahkan opsi produk berdasarkan respons dari kontroler
                $.each(data, function (index, produk) {
                    $('#id_produk').append('<option value="' + produk.id + '">' + produk.nama_produk + '</option>');
                });

            },
            error: function () {
                console.log('Terjadi kesalahan saat mengambil produk.');
            }
        });
    });
</script>

@endsection
