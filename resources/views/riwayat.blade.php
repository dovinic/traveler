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
                <a href="#findInvoice" class="float-right" data-toggle="modal">Lupa ID Transaksi? Klik Disini</a>
                <!--<button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#bayar"><ion-icon name="key-outline"></ion-icon> Bayar</button>-->
            </div>
        </div>
    </div>

    <form method="POST" id="searchForm">
        @csrf <!-- Ini adalah token CSRF untuk keamanan -->
        <div class="modal fade" id="findInvoice">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info"></i> Catatan:</h5>
                            Masukan Nomer yang didaftarkan ketika Order Pesanan. (Misal: 81234567890)
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <input type="search" name="nomerhp" class="form-control form-control-lg" placeholder="8123456789">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div id="searchResults">

                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </form>

</section>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Tangani saat form pencarian disubmit
    $("#searchForm").on("submit", function(e) {
        e.preventDefault(); // Mencegah pengiriman form biasa

        // Ambil nomor HP dari form
        var nomerhp = $("input[name='nomerhp']").val();

        // Kirim permintaan AJAX ke server
        $.ajax({
            url: '/cari-data/' + nomerhp, // Menggunakan URL dengan nomor HP sebagai bagian dari URL
            type: 'GET', // Menggunakan metode GET
            dataType: 'json', // Tentukan jenis respons yang diharapkan
            success: function(data) {
                // Bangun string HTML untuk menampilkan data
                var html = "";

                // Periksa apakah data ada dan bukan kosong
                if (data.length > 0) {
                    html += `
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Invoice</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                            <tbody>
                        `;
                    $.each(data, function(index, datas) {
                        html += `
                            <tr>
                                <td>${datas.nama}</td>
                                <td>${datas.id_transaksi}</td>
                                <td><a href="/history/${datas.id_transaksi}" target="_blank" class="btn btn-primary"><i class="fas fa-pen"></i> Detail</a></td>
                            </tr>
                        `;
                    });
                    html += `
                        </tbody>
                        </table>
                        </div>
                    `;
                } else {
                    html = "Data tidak ditemukan.";
                }

                // Tampilkan hasil pencarian di dalam div searchResults
                $("#searchResults").html(html);
            },
            error: function() {
                alert("ERROR.");
            }
        });
    });
});

</script>



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
