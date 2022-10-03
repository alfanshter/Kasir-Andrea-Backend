<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>INVOICE</title>

    <style>
        .invoice-box {
            font-size: 6px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 5;
        }

        .invoice-box table tr.top table td.title {
            font-size: 8px;
            line-height: 10px;
            color: #333;
        }

        .invoice-box table tr.information table td {}

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {}

        .invoice-box table tr.item td {
            padding-bottom: 1px;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            font-weight: bold;
            padding-bottom: 1px;
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
        <center>
            <p style="font-size:10px;"><b>wdfashion x <br>
                    Andreavokoofficial</b>
            </p>

        </center>

        <table cellpadding="0" cellspacing="0">
            <tr class="information">
                <td colspan="3">
                    <table>
                        <tr>
                            <td>
                                <p style="font-size: 8px;"> Pengirim :<br>
                                    Wdfashion x <br>
                                    andreavox<br>
                                    {{$nota->user->nama}} <br>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size: 8px;">
                                    Penerima : <br>
                                    {{$nota->nama}}<br>
                                    {{$nota->telepon}}<br>
                                    {{$nota->alamat}}

                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <center>
                                    <p style="color: red; ">Sertakan video unboxing Tanpa bukti video refund dan retur tidak berlaku</p>
                                </center>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <br>
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
                <td></td>
                <td></td>
                <td>
                    Harga Pesanan : Rp. {{$nota->harga}}<br>
                    Ongkos Kirim :Rp. {{$nota->ongkir}}<br>
                    Kurir :{{$nota->kurir}}<br>
                    Total:Rp. {{$nota->harga_total}}
                </td>
            </tr>
        </table>
    </div>
</body>

</html>