@include('pdf.master')
<body>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header" style="text-align: center">
                        <center>
                            <img src="{{$setup->logo}}" style="width: 77px; max-height: 77px; border-radius: 50%">
                            <h6><span>{{$setup->site_name}}</span></h6>
                            <div>Owner: <span>{{$setup->admin}}</span></div>
                            <div>Email: <a href="mailto:{{$setup->email}}">{{$setup->email}}</a></div>
                            <div>Phone: <a href="tel:{{$setup->phone}}">{{$setup->phone}}</a></div>
                        </center>
                        <br>
                            <div style="color: deepskyblue; padding-top: 5px;" class="card-title">Name : <a
                                    href="{{route('dashboard.customer.payment',$customer->id)}}"></a>{{$customer->name}}</div>
                            <div>Phone: <a href="tel:{{$customer->phone}}">{{$customer->phone}}</a></div>
                            <div>Email: <a href="mailto:{{$customer->email}}">{{$customer->email}}</a></div>
                            <div>Address:{{$customer->address}}</div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th wire:click.prevent="FilterSerialize('product_id')">Product</th>
                                    <th wire:click.prevent="FilterSerialize('category_id')">Size</th>
                                    <th wire:click.prevent="FilterSerialize('quantity')">Quantity</th>
                                    <th wire:click.prevent="FilterSerialize('kg')">KG</th>
                                    <th wire:click.prevent="FilterSerialize('unit_price')">price</th>
                                    <th wire:click.prevent="FilterSerialize('total_price')">Total</th>
                                    <th wire:click.prevent="FilterSerialize('paid_price')">Paid</th>
                                    <th wire:click.prevent="FilterSerialize('due_price')">Due</th>
                                    <th wire:click.prevent="FilterSerialize('created_at')">Date</th>
                                    <th wire:click.prevent="FilterSerialize('price_status')">Paid Status</th>
                                </tr>
                                </thead>
                                <div class="progress"><div class="progress-bar" style="width:{{@$data['progressBar']}}%"></div></div>
                                <tbody>
                                @forelse($sells->reverse() as $key=>$sell)
                                    <tr  wire:key="row-{{ $sell->id }}">
                                        <td class="text-capitalize"><a href="{{route('dashboard.products')}}">{{ $sell->product->name }}</a></td>
                                        <td class="text-capitalize"><a href="{{route('dashboard.categories')}}">{{ $sell->category->name }}</a></td>
                                        <td class="text-capitalize">{{ $sell->quantity }}</td>
                                        <td class="text-capitalize">{{ $sell->kg }}</td>
                                        <td class="text-capitalize">{{ $sell->unit_price }}</td>
                                        <td class="text-capitalize">{{ $sell->total_price }}</td>
                                        <td class="text-capitalize">{{ $sell->paid_price }}</td>
                                        <td class="text-capitalize">{{ $sell->due_price }}</td>
                                        <td>
                                            <span class="text-capitalize p-3" style="@if($sell->price_status==='fullpaid') color:green @elseif($sell->price_status==='subpaid') color:sandybrown @else color:red @endif">{{ $sell->price_status }}</span>
                                        </td>
                                        <td class="text-capitalize">{{ \Carbon\Carbon::parse($sell->created_at)->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                    <th class="text-center" colspan="10">No sell found</th>
                                @endforelse
                                <tr class="text-center">
                                    <th  colspan="4">Total</th>
                                    <td colspan="8">{{$data['total']}}</td>
                                </tr>
                                <tr class="text-center">
                                    <th colspan="4">Paid</th>
                                    <td colspan="8">{{$data['paid']}}</td>
                                </tr>
                                <tr class="text-center">
                                    <th colspan="4">Due</th>
                                    <td colspan="8">{{$data['due']}}</td>
                                </tr>
                                <tr class="text-center bg-secondary">
                                    <th colspan="2">Date</th>
                                    <th colspan="5">Amount</th>
                                    <th colspan="5">Due</th>
                                </tr>
                                @php
                                    $due = 0;
                                @endphp
                                @foreach($payments->reverse() as $payment)
                                    @php
                                        $due += $payment->amount;
                                        $due2 = $data['total']-$due;
                                    @endphp
                                    <tr class="text-center">
                                        <td colspan="2">{{$payment->created_at}}</td>
                                        <td colspan="5">{{$payment->amount}}</td>
                                        <td colspan="5">{{$due2}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <h5>Signature:</h5>
                            <div>Date: <span>{{ date('d.m.Y H:i:s')}}</span></div>
                            <div>Location: <span>{{$setup->location}}</span></div>
                            <div>Website: <a href="{{$setup->site_url}}">{{$setup->site_url}}</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
