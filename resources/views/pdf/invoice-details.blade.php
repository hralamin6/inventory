@include('pdf.master')
<body style="">
<table class="" style="border-collapse: collapse; width: 100%; margin-bottom: 8px;">
    <tr>
        <td width="60%"><span style="font-size: 15px; font-weight: bold;">@lang('Company info'):</span></td>
        <td width="40%"><span style="font-size: 15px; font-weight: bold;">@lang('Customer info'):</span></td>
    </tr>

    <tr style="font-weight: lighter;">
        <td width="60%">
            <span>@lang('Name') : {{$setup->name}}</span><br>
            <span>@lang('Email') : {{$setup->email}}</span><br>
            <span>@lang('Phone') : {{$setup->phone}}</span><br>
            <span>@lang('Address') : {{$setup->location}}</span>
        </td>
        <td width="40%">
            <span>@lang('Name') : {{$invoice->customer->name}}</span><br>
            <span>@lang('Email') : {{$invoice->customer->email}}</span><br>
            <span>@lang('Phone') : {{$invoice->customer->phone}}</span><br>
            <span>@lang('Address') : {{$invoice->customer->address}}</span>
        </td>

    </tr>
</table>
<hr style="margin-bottom: 0px;">
<table width="100%">
    <tr>
        <td colspan="3" style="text-align: center; padding: 8px;">
            <u><strong><span style="font-size: 18px; font-weight: bold; text-align:center;">@lang('Invoice Details')</span></strong></u><br>
            <strong>@lang('Invoice No'): # {{$invoice->invoice_no}}</strong>

        </td>
    </tr>
</table>

<table style="border-collapse: collapse; width: 100%;">
    <tr style="border: 1px solid #dddddd; text-align: left; padding: 8px;">
        <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">@lang('SL')</th>
        <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">@lang('Item')</th>
        <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">@lang('Description')</th>
        <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">@lang('Quantity')</th>
        <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">@lang('Price')</th>
        <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">@lang('Total')</th>
    </tr>
    @foreach($items as $i=> $item)
        <tr style="border: 1px solid #dddddd; text-align: left; padding: 8px;">
            <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">{{$i+1}}</td>
            <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">{{$item->product->name}}</td>
            <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">{{$item->product->category->name}}</td>
            <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">{{$item->quantity}}</td>
            <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">{{$item->unit_price}}</td>
            <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">{{$item->total_price}}</td>
        </tr>
    @endforeach

    <tr style="border: 1px solid #dddddd; text-align: left; padding: 8px;">
        <td colspan="5" style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><strong>@lang('Sub Total')</strong></td>
        <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">{{$payment->discount_amount+$payment->total_amount}}</td>
    </tr>
    <tr style="border: 1px solid #dddddd; text-align: left; padding: 8px;">
        <td colspan="5" style="border: 1px solid #dddddd; text-align: left; padding: 8px;">@lang('Discount')</td>
        <td style="border: 1px solid #dddddd; text-align: left; padding: 8px; color:green;">{{$payment->discount_amount}}</td>
    </tr>
    <tr style="border: 1px solid #dddddd; text-align: left; padding: 8px;">
        <td colspan="5" style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><strong>@lang('Grand Total')</strong></td>
        <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">{{$payment->total_amount}}</td>
    </tr>
    <tr style="border: 1px solid #dddddd; text-align: left; padding: 8px;">
        <td colspan="5" style="border: 1px solid #dddddd; text-align: left; padding: 8px;">@lang('Paid Amount')</td>
        <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;color:green;">{{$payment->paid_amount}}</td>
    </tr>
    <tr style="border: 1px solid #dddddd; text-align: left; padding: 8px;">
        <td colspan="5" style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><strong>@lang('Due Amount')</strong></td>
        <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;color:red;">{{$payment->due_amount}}</td>
    </tr>
    <tr style="border: 1px solid #dddddd; text-align: left; padding: 8px;">
        <td colspan="6" style="border: 1px solid #dddddd; text-align: center; padding: 8px;"><strong>@lang('Paid Summary')</strong></td>
    </tr>
    <tr style="border: 1px solid #dddddd; text-align: left; padding: 8px;">
        <td width="11%" colspan="3" style="border: 1px solid #dddddd; text-align: center; padding: 8px;"><strong>@lang('Date')</strong></td>
        <td width="10%" colspan="3" style="border: 1px solid #dddddd; text-align: center; padding: 8px;"><strong>Amount</strong></td>
    </tr>
    @foreach($paymentDetails as $key=> $item)

        <tr style="border: 1px solid #dddddd; text-align: left; padding: 8px;">
            <td width="11%" colspan="3" style="border: 1px solid #dddddd; text-align: center; padding: 8px;">
                {{$item->date}}</td>
            <td width="10%" colspan="3" style="border: 1px solid #dddddd; text-align: center; padding: 8px;">
                {{$item->current_paid_amount}}</td>
        </tr>
    @endforeach
</table>
<table class="" style="border-collapse: collapse; width: 100%; margin-top: 24px;">
    <tr style="font-weight: lighter">
        <td >@lang('Date'): {{date('M d, Y, h:j')}}</td>
        <td style="">@lang('owner signature'):</td>
        <td style="">@lang('Customer signature'):</td>
    </tr>
</table>
</body>
</html>
