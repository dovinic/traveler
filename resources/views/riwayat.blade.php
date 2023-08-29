@extends('layout.order')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Riwayat Transaksi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Riwayat Transaksi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



  <section class="content">
    <div class="container-fluid">
        <h2 class="text-center display-4">ID Transaksi: </h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="{{ route('cari') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="search" name="id_transaksi" class="form-control form-control-lg" placeholder="Masukan ID Transaksimu disini">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  @if ($transaksi->isEmpty())
      Swal.fire({
          icon: 'error',
          title: 'ID Transaksi Tidak Ditemukan',
          text: 'Maaf, ID transaksi yang Anda cari tidak ditemukan.'
      });
  @endif
</script>
@endsection
