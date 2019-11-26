<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>In đơn hàng</title>

    <style>

        @media print {
            body *, #main * { display:none; }
            #main, #main #printarea, #main #printarea * { display:block; }
        }
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }


    </style>
</head>
<body>
<div id="main">
<div id="printarea">
    <h3><strong>THÔNG TIN MÃ THẺ</strong></h3>
    Mã đơn: {{$order->id}}
    <br>
    <br>
        @if(count($listcard) > 0)
        #  | Tên sản phẩm  |  Mã nạp thẻ  |   Serial  |  Ngày hết hạn <br>
        @foreach($listcard as $key => $item)

            {{$key + 1 }}  | {{ $item->name }}  |  {{ $item->code }}   |   {{ $item->serial }}   |  {{ $item->expire }} <br>

        @endforeach
            @endif
</div>
</div>
    <br>
    <button onclick="myFunction()">In mã thẻ</button>

    <script>
        function myFunction() {
            window.print();
        }
    </script>

</body>

</html>