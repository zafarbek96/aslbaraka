<link rel="stylesheet" type="text/css" href="{{ asset('css/export.css') }}">
<table class="nav">

    <thead>
    @for($i = 1; $i <= 5; $i++)
        <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> </tr>
    @endfor
    <tr>
        @for($i = 1; $i <= 3; $i++)
            <td></td>
        @endfor
        <td>{{ $orders[0]->buy->user_name }}</td>
        <td ></td>
        <td ></td>
        <td ></td>
        <td >{{ $orders[0]->buy->meneger }}</td>
        <td ></td>

    </tr>
    <tr >
        @for($i = 1; $i <= 3; $i++)
            <th></th>
        @endfor
        <th style="border: 1px solid #000000; text-align: center;"> № </th>
        <th style="border: 1px solid #000000; width: 25px;">Товар</th>
        <th style="border: 1px solid #000000;text-align: center;">кг/шт</th>
        <th style="border: 1px solid #000000;">Кол-во</th>
        <th style="border: 1px solid #000000;">Цена</th>
        <th style="border: 1px solid #000000;">Сумма</th>
    </tr>
    </thead>
    <tbody>

@php
    $j = 1 ;
@endphp

    @foreach($orders as $order)
        <tr>
            @for($i = 1; $i <= 3; $i++)
                <td></td>
            @endfor
            <td style="border: 1px solid #000000; text-align: center;">{{ $j++ }}</td>
            <td style="border: 1px solid #000000; width: 25px;">{{ $order->product->name }}</td>
            <td style="border: 1px solid #000000;text-align: center;">{{ $order->tovar}}</td>
            <td style="border: 1px solid #000000;">{{ $order->count}}</td>
            <td style="border: 1px solid #000000;">{{ $order->product_price}}</td>
            <td style="border: 1px solid #000000;">{{ $order->all_price}}</td>

        </tr>

    @endforeach
<tr>
    @for($i = 1; $i <= 3; $i++)
        <td></td>
    @endfor
    <td style="border: 1px solid #000000;"> </td>
    <td style="border: 1px solid #000000;" >ИТОГО : </td>
    <td style="border: 1px solid #000000;"></td>
    <td style="border: 1px solid #000000;">{{$orders->sum('count')}}</td>
    <td style="border: 1px solid #000000;"></td>
    <td style="border: 1px solid #000000;">{{ $order->buy->summa }}</td>
</tr>
<tr>
    @for($i = 1; $i <= 3; $i++)
        <td></td>
    @endfor
    <td style="border: 1px solid #000000;"></td>
    <td style="border: 1px solid #000000;"></td>
    <td style="border: 1px solid #000000;"></td>
    <td style="border: 1px solid #000000;"></td>
    <td style="border: 1px solid #000000;"></td>
    <td style="border: 1px solid #000000;"></td>
</tr>
    </tbody>
</table>

