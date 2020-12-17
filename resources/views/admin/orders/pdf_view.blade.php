<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


    <title>{{ $order->id }}</title>

    <style>

        * {
            font-family: DejaVu Sans, sans-serif;
        }

        /********************/
        .invoice-title h2, .invoice-title h3 {
            display: inline-block;
        }

        .table > tbody > tr > .no-line {
            border-top: none;
        }

        .table > thead > tr > .no-line {
            border-bottom: none;
        }

        .table > tbody > tr > .thick-line {
            border-top: 2px solid;
        }

        .page-break {
            page-break-after: always;
        }

    </style>
</head>
<body>


<div class="container">

    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-title text-right">
                <p class="pull-right">رقم الطلب # {{$order->id}}</p>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-4 text-left">
                    <address >
                        <strong>دفع إلى:</strong><br>
                        {{$order->user->name}}<br>
                        1234 Main<br>
                        Apt. 4B<br>
                        Springfield, ST 54321
                    </address>
                </div>
                <div class="col-xs-4 text-center">
                    <address>
                        <strong>طريقة الدفع:</strong><br>
                        الدفع عند التوصيل<br>
                        {{$order->user->phone_number}}
                    </address>
                </div>
                <div class="col-xs-4 text-right">
                    <address>
                        <strong>تاريخ الطلب:</strong><br>
                        {{$order->created_at}}<br><br>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-title text-right"><strong>ملخص الطلب</strong></p>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <td><strong>المنتج</strong></td>
                                <td class="text-center"><strong>اللون</strong></td>
                                <td class="text-center"><strong>الحجم</strong></td>
                                <td class="text-center"><strong>السعر</strong></td>
                                <td class="text-center"><strong>الكمية</strong></td>
                                <td class="text-right"><strong>القيمة</strong></td>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($order->OrderProducts as  $order_product)
                                <tr>
                                    <td>
                                        {{ $order_product->ProductVariant->product->name}}
                                    </td>
                                    <td>
                                        {{ $order_product->ProductVariant->variant->color}}
                                    </td>

                                    <td>
                                        {{ $order_product->ProductVariant->variant->size}}
                                    </td>

                                    <td>
                                        {{ $order_product->ProductVariant->variant->price}}
                                    </td>

                                    <td>
                                        {{ $order_product->quantity}}
                                    </td>

                                    @php($total_price_per_item = $order_product->ProductVariant->variant->price * $order_product->quantity)

                                    <td>
                                        {{ $total_price_per_item}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    لا يوجد
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-break"></div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <td></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-right"></td>
                            </tr>
                            </thead>
                            <tbody class="text-right">
                            <tr>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line text-right">
                                    جنيه
                                    <del>{{$order->subtotal}} </del>
                                </td>
                                <td class="thick-line text-center"><strong> السعر </strong></td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-right">
                                    {{$order->discount}}
                                    جنيه
                                </td>
                                <td class="no-line text-center"><strong>قيمة التخفيض</strong></td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-right">
                                    {{$order->total}}
                                    جنيه

                                </td>
                                <td class="no-line text-center"><strong>المبلغ المطلوب</strong></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{--<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>--}}
{{--<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>--}}
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

</body>
</html>
