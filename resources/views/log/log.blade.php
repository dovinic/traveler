@extends('layout.main')
@section('content')

<style>
    .mailbox-subject a {
        color: black; /* Ganti dengan warna yang Anda inginkan */
    }
    .mailbox-name a {
        color: red; /* Ganti dengan warna yang Anda inginkan */
        font-weight: 600;
    }
</style>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Log</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
            <div class="callout callout-info">
                <h5><b>Catatan:</b></h5>
                Log Transaksi Bersifat Sementara! Apabila Statusnya Lunas maka Lognya akan hilang. ini bertujuan hanya untuk menginfokan kepada admin apabila ada Pelanggan baru.
            </div>
            </div>

          <!-- /.col -->
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title"><b>Transaksi Baru</b></h3>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive mailbox-messages">
                  <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                          <th>Nama</th>
                          <th>Informasi</th>
                          <th>Waktu</th>
                        </tr>
                      </thead>
                    <tbody>
                        @foreach ($logs as $b)
                            @foreach ($transaksi as $t)
                                @if ($t->id_transaksi == $b->invoice)
                                    @if ($t->status == 'Proses')
                                        <tr>
                                            <td class="mailbox-name"><a href="{{ route('admin.transaksi.edit',['id' => $b->id2]) }}">{{ $b->nama }}</a></td>
                                            <td class="mailbox-subject"><a href="{{ route('admin.transaksi.edit',['id' => $b->id2]) }}"><b>Invoice #{{ $b->invoice }}</b> - Telah melakukan pembayaran</a></td>
                                            <td class="mailbox-date">{{ $b->diff }}</td>
                                        </tr>
                                    @endif
                                @endif

                            @endforeach
                        @endforeach
                    </tbody>
                  </table>
                  <!-- /.table -->
                </div>
                <!-- /.mail-box-messages -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
    <!-- /.content -->
  </div>

<script>
$(function () {
    //Enable check and uncheck all functionality
    $('.checkbox-toggle').click(function () {
    var clicks = $(this).data('clicks')
    if (clicks) {
        //Uncheck all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
        $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
    } else {
        //Check all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
        $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
    }
    $(this).data('clicks', !clicks)
    })

    //Handle starring for font awesome
    $('.mailbox-star').click(function (e) {
    e.preventDefault()
    //detect type
    var $this = $(this).find('a > i')
    var fa    = $this.hasClass('fa')

    //Switch states
    if (fa) {
        $this.toggleClass('fa-star')
        $this.toggleClass('fa-star-o')
    }
    })
})
</script>

@endsection
