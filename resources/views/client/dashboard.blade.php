@extends('layout.order')
@section('content')

<link rel="stylesheet" href="{{ asset('lte/dist/css/Testi/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('lte/dist/css/Testi/css/swiper-bundle.min.css') }}">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard Client</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard Client</li>
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
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $totaltransaksi }}</h3>
                <p>Total Pelanggan</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-stalker"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->


      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <div class="slide-container swiper">
        <div class="title">TESTIMONI</div>
        <div class="slides-content">
            <div class="card-wrapper swiper-wrapper">
                @foreach ($testi as $t)
                    @if ($t->action == 'Publik')
                        <div class="cards swiper-slide">
                            <div class="images-content">
                                <span class="overlay"></span>

                                <div class="cards-image">
                                    <img src="{{ asset('lte/dist/css/Testi/pict/1.jpg') }}" alt="Vonzy" class="cards-img">
                                </div>
                            </div>

                            <div class="cards-content">
                                <h2 class="name">
                                    {{ $t->nama }}
                                </h2>
                                <p class="description">{{ $t->ulasan }}</p>
                                @php
                                    $matchingPaket = $allpaket->where('name', $t->paket)->first();
                                @endphp
                                <a href="{{ route('order',['id' => $matchingPaket->id]) }}" class="button"><i class="fas fa-cube"></i> {{ $t->paket }}</a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="swiper-pagination"></div>
    </div>
  </div>

  <script src="{{ asset('lte/dist/css/Testi/js/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('lte/dist/css/Testi/js/script.js') }}"></script>
@endsection
