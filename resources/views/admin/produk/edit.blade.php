@extends('layout.main')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Ubah Produk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Ubah Produk</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.produk.update',['id' => $data->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                  <!-- left column -->
                  <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">Form Ubah Produk</h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      <form>
                        <div class="card-body">
                          <div class="form-group">
                            <label for="id_paket">Nama Paket</label>
                            <select name="id_paket" class="form-control">
                                @foreach ($namapaket as $pkt)
                                    <option value="{{ $pkt->id }}" {{ $pkt->id == $data->id_paket ? 'selected' : '' }}>{{ $pkt->name }}</option>
                                @endforeach
                            </select>
                            @error('id_paket')
                                <small>{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="nama_produk" value="{{ $data->nama_produk }}" placeholder="Masukan Nama Produk">
                            @error('nama_produk')
                                <small>{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" value="{{ $data->harga }}" placeholder="Masukan Jumlah Harga">
                            @error('harga')
                                <small>{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label for="info">Info Produk</label>
                            <textarea type="longtext" class="form-control" id="info" name="info" placeholder="Masukan Keterangan Produk">{{ $data->info }}</textarea>
                            @error('info')
                                <small>{{ $message }}</small>
                            @enderror
                          </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                          <button type="submit" class="btn btn-primary">Submit</button>
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

@endsection
