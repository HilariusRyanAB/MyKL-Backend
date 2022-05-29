<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <title>Payment Report</title>
    </head>

    <body>
        <div id="BillingOwner" style="width: 500px; border: 2px black solid; overflow-y: hidden;">
            <table id="tabelTitle" class="black--text" style="table-layout:fixed; width: 470px; max-height: 145px; margin-top: 5px; margin-left: 6px; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th class="text-center mt-4">
                            <img contain height="130" width="150" src="https://mykl.klbizhubbilling.xyz/image/logoKLBizHub.jpg"></img>
                        </th>
                        <th class="text-center mt-1 mr-3" style="font-size: 12px; margin-top: 5px">
                            <p class="indigo--text text--darken-3" style="font-size: 26px; font-weight:bold">KL BIZ HUB</p>
                            <p class="mb-3 red--text" style=" margin-top: -20px; font-size: 14px">KOMPLEKS PERGUDANGAN</p>
                            <p style="margin-top: -18px; font-size: 12px">Jl. Perusahaan Raya No. 22-35 Malang</p>
                            <p style="margin-top: -18px; font-size: 12px">65153</p>
                            <p style="margin-top: -18px; font-size: 12px">Telp. (0341) 419000</p>
                            <p style="margin-top: -18px; font-size: 12px"><a href="http://klbizhub.com"><u>http://klbizhub.com</u></a></p>
                        </th>
                    </tr>
                </thead>
            </table>

            <div>
                <table id="tabelTitle" class="black--text" style="table-layout:fixed; width: 470px; margin-left: 13px; border-collapse: collapse;">
                    <thead style="border-top: 2.4px black dashed; margin-top: 5px">
                        <tr class="text-center">
                            <th></th>
                            <th>
                                PAYMENT REPORT
                            </th>
                            <th></th>
                        </tr>
                        <tr>
                            <th class="text-left" style="font-size: 12px; width: 265px">Property Number: {{$nomor_kavling}}</th>
                            <th></th>
                            <th class="text-left ml-5" style="font-size: 12px; vertical-align: text-top;">Period: {{$period}}</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div style="margin-bottom: 5px; margin-top: 2px">
                <table id="tabelDetail" style="table-layout:fixed; width: 470px; margin-left: 13px; border-collapse: collapse" class="black--text">
                    <thead style="border-bottom: 1px black solid; border-top: 3px black double">
                        <tr>
                            <th class="text-center" style="font-size: 12px;">No</th>
                            <th class="text-center" style="font-size: 12px;">Month</th>
                            <th class="text-center" style="font-size: 12px;">Total Payment</th>
                            <th class="text-center" style="font-size: 12px;">Payment Method</th>
                            <th class="text-right" style="font-size: 12px;">Payment Status</th>
                        </tr>
                    </thead>
                    <?php foreach($billings as $billing) { ?>
                        <tbody style="border-bottom: 0.5px black solid;">
                            <td class="text-center" style="font-size: 12px;"><?php echo $billing->id_month; ?></td>
                            <td class="text-center" style="font-size: 12px;"><?php echo $billing->month_name; ?></td>
                            <td class="text-center" style="font-size: 12px;"><?php echo Helper::changeToCurrency($billing->total_biaya); ?></td>
                            <td class="text-center" style="font-size: 12px;"> <?php 
                                    if($billing->metode_pembayaran != null)
                                    {
                                        echo $billing->metode_pembayaran;
                                    }
                                    else
                                    {
                                        echo "-";
                                    }
                                ?>
                            </td>
                            <td class="text-center" style="font-size: 12px;">
                                <?php 
                                    if($billing->status_pembayaran != null)
                                    {
                                        echo $billing->status_pembayaran;
                                    }
                                    else
                                    {
                                        echo "-";
                                    }
                                ?>
                            </td>
                        </tbody>
                    <?php } ?>
                </table>
                
                <p style="font-size: 11px; margin-top: 25px; margin-right: 15px" class="text-right"><b>Printed on {{Helper::getDate()}}, {{Helper::getTime()}} WIB</b></p>

                <table class="black--text" style="width: 470px; margin-left: 13px; margin-top: 15px; border-collapse: collapse; margin-bottom: 15px">
                    <thead style="border-top: 2.4px black dashed; ">
                        <th style="font-size: 13px" class="text-center">THANK YOU FOR YOUR ATTENTION</th>
                    </thead>
                    <tbody style="border-bottom: 2.4px black dashed;">
                        <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
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