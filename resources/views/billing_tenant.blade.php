<!doctype html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <title>Billing-{{$billing->nomor_billing}}-T</title>
    </head>

    <body>
        <div id="BillingOwner" style="width: 500px; border: 2px black solid;">
            <table id="tabelTitle" class="black--text" style="table-layout:fixed; width: 470px; max-height: 145px; margin-top: 5px; margin-left: 25px; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th class="text-center mt-4">
                            <img contain height="130" width="150" src="image/logoKLBizHub.jpg"></img>
                        </th>
                        <th class="text-center mt-1 mr-3" style="font-size: 12px; margin-top: 5px">
                            <p class="indigo--text text--darken-3" style="font-size: 26px; font-weight:bold">KL BIZ HUB</p>
                            <p class="mb-3 red--text" style=" margin-top: -20px; font-size: 14px">KOMPLEKS PERGUDANGAN</p>
                            <p style="margin-top: -18px; font-size: 12px">Jl. Perusahaan Raya No. 22-35 Malang</p>
                            <p style="margin-top: -18px; font-size: 12px">65153</p>
                            <p style="margin-top: -18px; font-size: 12px">Telp. (0341) 419000</p>
                            <p style="margin-top: -18px; font-size: 12px"><a><u>http://klbizhub.com</u></a></p>
                        </th>
                    </tr>
                </thead>
            </table>

            <div>
                <table id="tabelTitle" class="black--text" style="table-layout:fixed; width: 470px; margin-left: 25px; border-collapse: collapse;">
                    <thead style="border-top: 2.4px black dashed; margin-top: 5px">
                        <tr>
                            <th class="text-left" style="font-size: 12px; width: 265px">Penyewa: {{$billing->nama_penyewa}}</th>
                            <th class="text-left ml-5" style="font-size: 12px; vertical-align: text-top;">Tagihan Bulan: {{Helper::getBulan()}} {{Helper::getTahun()}}</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div style="margin-bottom: 5px; margin-top: 2px">
                <table id="tabelTitle" class="black--text" style="table-layout:fixed; width: 470px; margin-left: 25px; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th class="text-left" style="font-size: 12px; width: 265px">Alamat: {{$billing->alamat_penyewa}}</th>
                            <th class="text-left ml-5" style="font-size: 12px; vertical-align: text-top;">No. Kavling: {{$billing->nomor_kavling}}</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div>
                <table id="tabelSubtitle" class="black--text" style="table-layout:fixed; width: 470px; margin-left: 25px; border-collapse: collapse;">
                    <thead style="border-top: 2.4px black dashed;">
                        <tr>
                            <th class="text-left" style="font-size: 12px;">Cetakan ke - 2</th>
                            <th class="text-left ml-5" style="font-size: 12px;">No. Billing: {{$billing->nomor_billing}}</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div style="margin-top: 2px;">
                <table id="tabelDetail" style="table-layout:fixed; width: 470px; margin-left: 25px; border-collapse: collapse" class="black--text">
                    <thead style="border-bottom: 1px black solid; border-top: 3px black double">
                        <tr>
                            <th class="text-left" style="font-size: 12px;">Luas Bangunan (m<span style="content: "\00B2";">&#178;</span>)</th>
                            <th class="text-center" style="font-size: 12px;">Tagihan / m<span style="content: "\00B2";">&#178;</span></th>
                            <th class="text-right" style="font-size: 12px;">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td class="text-left" style="font-size: 12px;">{{$billing->luas_bangunan}}</td>
                        <td class="text-center" style="font-size: 12px;">{{Helper::changeToCurrency(2500)}}</td>
                        <td class="text-right" style="font-size: 12px;">{{Helper::changeToCurrency($billing->biaya_kotor)}}</td>
                    </tbody>
                </table>

                <table id="tabelDetailPembayaran" style="table-layout:fixed; width:470px; margin-left: 25px; border-collapse: collapse" class="black--text align-right">
                    <thead>
                        <tr>
                            <th class="text-right" style="width: 42.5%"></th>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px black dashed; border-bottom: 1px black dashed">
                        <tr>
                            <td></td>
                            <td class="text-left" style="font-size: 12px;">Pajak 10%</td>
                            <td class="text-right" style="font-size: 12px;">{{Helper::changeToCurrency($billing->total_pajak)}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-left" style="font-size: 12px;">Denda</td>
                            <td class="text-right" style="font-size: 12px;">{{Helper::changeToCurrency($billing->jumlah_denda * 5000)}}</td>
                        </tr>
                    </tbody>
                </table>

                <table id="tabelDetailPembayaran" style="table-layout:fixed; width:470px; margin-left: 25px; border-collapse: collapse" class="black--text align-right">
                    <thead>
                        <tr>
                            <th class="text-right" style="width: 42.5%"></th>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody style="border-bottom: 3px black double">
                        <tr>
                            <td></td>
                            <td class="text-left" style="font-weight: bold; font-size: 12px;">Total</td>
                            <td class="text-right" style="font-weight: bold; font-size: 12px;">{{Helper::changeToCurrency($billing->total_biaya)}}</td>
                        </tr>
                    </tbody>
                </table>

                <p style="font-size: 11px; margin-top: 10px; margin-left: 25px" class="text-left"><b>Pembayaran dapat dilakukan melalui:</b></p>
                <p style="font-size: 11px; margin-top: -15px; margin-left: 25px" class="text-left">Nama Bank: <b>BCA</b></p>
                <p style="font-size: 11px; margin-top: -15px; margin-left: 25px" class="text-left">No. Rekening: <b>3310609462</b></p>
                <p style="font-size: 11px; margin-top: -15px; margin-left: 25px" class="text-left">A/N: <b>PT. BALTEN SEJAHTERA</b></p>
                <p style="font-size: 11px; margin-top: -15px; margin-left: 25px" class="text-left">Pembayaran dapat dilakukan sebelum tanggal <b>25 {{Helper::getBulan()}} 2021</b></p>
                <p style="font-size: 11px; margin-top: 25px; margin-right: 35px" class="text-right"><b>Dicetak pada {{Helper::getDate()}}, {{Helper::getTime()}} WIB</b></p>

                <table class="black--text" style="width: 470px; margin-left: 25px; margin-top: 15px; border-collapse: collapse; margin-bottom: 15px">
                    <thead style="border-top: 2.4px black dashed; ">
                        <th style="font-size: 13px" class="text-center">THANK YOU FOR YOUR ATTENTION</th>
                    </thead>
                    <tbody style="border-bottom: 2.4px black dashed;">
                        <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>

    <style>
        @page 
        { 
            margin-top: 20px;
            margin-right: 30px;
            margin-left: 30px;
            margin-bottom: 0px;
            padding:0;
        }
    </style>
</html>