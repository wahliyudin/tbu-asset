<!DOCTYPE html>
<html>

<head>
    <title>TBU</title>
</head>

<body>
    <div class="greeting" style="margin-bottom : 20px">
        <span>
            <strong>Dear Mr/Mrs {{ $employee->nama_karyawan }},</strong>
        </span>
    </div>
    <div class="body">
        Asset Transfer {{ $transfer->no_transaksi }} Needs to be approved by you, Please click link this to detail
        <br>
        <a href="{{ $url }}">Detail</a>
    </div><br>

    <div class="thanks" style="margin-top:20px">
        <span>
            Best Regards,<br><strong>ASSET Alert System</strong>
        </span>
    </div>
</body>

</html>
