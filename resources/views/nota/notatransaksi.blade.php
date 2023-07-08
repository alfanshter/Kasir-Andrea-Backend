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
            <p style="font-size:10px;"><b>NOTA</b><br>
                MySweetSugar
            </p>

        </center>

        <table cellpadding="0" cellspacing="0">
            <tr class="information">
                <td colspan="3">
                    <table>
                        <tr>
                            <td>
                                <p style="font-size: 8px;">
                                    Tanggal : {{$tanggal}} <br>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size: 8px;">
                                    Penerima : <br>
                                    {{$nota['nama']}}<br>
                                    Rekening : {{$nota['pembayaran']}}<br>
                                    Alamat : {{$users['alamat']}}<br>
                                    Telp : {{$users['telepon']}}<br>

                                </p>
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
                    {{$item['nama']}}
                </td>
                <td class="text-td">
                    {{$item['jumlah']}}
                </td>
                <td class="text-td">
                    {{$item['harga']}}
                </td>
            </tr>

            @endforeach

            <br><br><br>
            <tr class="total">
                <td></td>
                <td colspan="2"> Total : Rp. {{$nota['total_harga']}}<br>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>