
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>INVOICE</title>

    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    .text-td {
           text-align: center;
            vertical-align: middle

    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="3">
                    <table>
                        <tr>
                            <td class="title">
                                Kasir Online
                            </td>

                            <td>
                                Invoice #: {{$nota->nomorpesanan}}<br>
                                Tanggal: {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $nota->created_at)->format('Y-m-d');}}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="3">
                    <table>
                        <tr>
                            <td>
                                Penerima : <br>
                                {{$nota->nama}}<br>
                                {{$nota->telepon}}<br>
                                {{$nota->alamat}}
                            </td>

                            <td>
                                Pengirim :<br>
                                Kasir Andrea<br>
                                Jl. kasir rt/rw 002/001 kel. kasir kec. kasir.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            {{--<tr class="heading">
                <td>
                    
                </td>

                <td>
                    Check #
                </td>
            </tr>

            <tr class="details">
                <td>
                    Check
                </td>

                <td>
                    1000
                </td>
            </tr>--}}

            <tr class="heading">
                <td class="text-td" style="width: 33%"> 
                    Nama Barang
                </td>

                <td class="text-td" style="width: 33%">
                    Jumlah
                </td>

                <td class="text-td" style="width: 33%">
                    Harga
                </td>
            </tr>

            @foreach ($keranjang as $item)
                <tr class="item">
                <td class="text-td">
                    {{$item->produk->nama}}
                </td>
                <td class="text-td">
                    {{$item->jumlah}}
                </td>
                <td class="text-td">
                    {{$item->harga}}
                </td>
            </tr>
  
            @endforeach

            <br><br><br>
            <tr class="total">
                <td> </td>
                <td></td>
                <td>
                    Harga Pesanan : Rp.  {{$nota->harga}}<br>
                    Ongkos Kirim :Rp.  {{$nota->ongkir}}<br>
                   Total:Rp.  {{$nota->harga_total}}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>