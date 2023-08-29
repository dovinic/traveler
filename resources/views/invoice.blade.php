<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('lte/dist/css/invoice/invoice.css') }}">
    <title>Invoice</title>
</head>
<body>
    <div class="page" size="A4">
        <div class="top-section">
            <div class="logo">
                <img src="{{ asset('lte\dist\img\bromo.png') }}">
            </div>
            <div class="address">
                <div class="address-content">
                    <h2> BROMO </h2>
                    <p> CREATIVE.COM </p>
                </div>
            </div>

            <div class="contact">
                <div class="iconic">
                    <ion-icon name="call"></ion-icon>
                    <ion-icon name="mail"></ion-icon>
                    <ion-icon name="location"></ion-icon>
                </div>
                <div class="contact-content">
                    <div class="email"> +62 857-5584-2891 </div>
                    <div class="number"> bromocreative@gmail.com </div>
                    <div class="alamat"> Jl.Simpang Danau Yamur no.60 Sawojajar Malang, Jawa Timur </div>
                </div>
            </div>
        </div>

        <div class="billing-invoice">
            <div class="invoice-kiri">
                <h2 class="inv"> INVOICE </h2>
                <p class="web"> www.bromocreative.com </p>
                <div class="bawahnya"></div>
            </div>
            <div class="invoice-kanan">
                <h2 class="inv2"> INVOICE TO </h2>
                <p class="received"> {{ $buyer->nama }} </p>
            </div>
        </div>

        <div class="rincian-invoice">
            <div class="invoice-kiri">
                <p>Invoice No <span class="span">#{{ $buyer->id_transaksi }}</span></p>
                <p>Invoice Date <span class="span">{{ $tgl_invoice[0] }}</span></p>
                <p>Trip Date <span class="span">{{ $tgl_berangkat[0] }}</span></p>
            </div>
            <div class="invoice-kanan">
                <p>Phone<span class="span">+62 {{ $buyer->phone_number }}</span></p>
                <p>Trip<span class="span">Bromo Midnight</span></p>
                <p>Penjemputan<span class="span">{{ $buyer->penjemputan }}</span></p>
            </div>
        </div>

        <div class="table">
            <table>
                <tr>
                    <th>Nama Paket</th>
                    <th>Jumlah Penumpang</th>
                    <th>Total Harga</th>
                </tr>
                <tr>
                    <td>
                        @foreach ($allpaket as $pkt)
                            @if ($buyer->id_paket == $pkt->id)
                                {{ $pkt->name }}
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach ($allproduk as $prk)
                            @if ($buyer->id_produk == $prk->id)
                                {{ $prk->nama_produk }}
                            @endif
                        @endforeach
                    </td>
                    <td>{{ formatRupiah($buyer->total_harga) }}</td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            </table>
        </div>

        <div class="bottom-section">
            <div class="payment">
                <p>Metode Pembayaran</p>
                <p class="norek">No Rek BCA 622-501-3610</p>
                <p>AN CITRA AYU DIYAH PITALOKA</p>
            </div>
            <div class="status">
                <p>Subtotal<span class="span">{{ formatRupiah($buyer->total_harga) }}</span></p>
                <p>Total<span class="span">{{ formatRupiah($buyer->total_harga) }}</span></p>
                <p>Status Pesanan<span class="span">
                    @if ($buyer->status == "Lunas")
                        <button type="button" class="btn-success">{{ $buyer->status }}</button>
                    @elseif ($buyer->status == "Proses")
                        <button type="button" class="btn-primary">{{ $buyer->status }}</button>
                    @elseif ($buyer->status == "Belum Bayar")
                        <button type="button" class="btn-warning">{{ $buyer->status }}</button>
                    @elseif ($buyer->status == "Batal")
                        <button type="button" class="btn-danger">{{ $buyer->status }}</button>
                    @endif
                </span></p>
            </div>

        </div>

        <div class="penutup">
            <ion-icon name="logo-instagram"></ion-icon>
            <a href="https://www.instagram.com/bromocreative" target="_blank">bromocreative</a>
            <ion-icon name="globe-outline"></ion-icon>
            <a href="https://www.bromocreative.com" target="_blank">www.bromocreative.com</a>
            <ion-icon name="logo-whatsapp"></ion-icon>
            <a href="https://api.whatsapp.com/send?phone=6281331753531" target="_blank">0813-3175-3531</a>
        </div>

    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>
</html>
