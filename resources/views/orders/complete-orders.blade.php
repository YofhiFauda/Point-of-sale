@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        {{-- Start of Complete List Order, Export and Clear --}}
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Daftar Pesanan Selesai</h4>
                </div>
                <div>
                    <a href="{{ route('order.exportData') }}" class="btn btn-success add-list">Export</a>
                    {{-- <button type="submit" class="btn btn-danger" name="delete_all" value="1" onclick="return confirm('Are you sure you want to delete all transactions?')">Hapus Semua Transaksi</button> --}}
                    <form action="{{ route('order.destroyAll') }}" method="post" class="d-inline">
                        @csrf
                        @method('HAPUS')
                         <button type="submit" class="btn btn-danger" name="delete_all" value="1" onclick="return confirm('Are you sure you want to delete all transactions?')">Hapus Semua Transaksi</button>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Of Complete Order List, Export and Clear Search --}}
        
        <div class="col-lg-12">
            <form action="{{ route('order.completeOrders') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="form-group row">
                        <label for="row" class="col-sm-3 align-self-center">Row:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="row">
                                <option value="10" @if(request('row') == '10')selected="selected"@endif>10</option>
                                <option value="25" @if(request('row') == '25')selected="selected"@endif>25</option>
                                <option value="50" @if(request('row') == '50')selected="selected"@endif>50</option>
                                <option value="100" @if(request('row') == '100')selected="selected"@endif>100</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3 align-self-center" for="search">Pencarian:</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" id="search" class="form-control" name="search" placeholder="Cari Pesanan" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="input-group-text bg-primary"><i class="fa-solid fa-magnifying-glass font-size-20"></i></button>
                                    <a href="{{ route('order.completeOrders') }}" class="input-group-text bg-danger"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('order.completeOrders') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-end">
                    <div class="form-group row">
                        <label class="control-label align-self-center" for="start_date">Tanggal Mulai:</label>
                        <div class="col-sm-3">
                            <input type="date" id="start_date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                        </div>
                        <label class="control-label align-self-center" for="end_date">Tanggal selesai:</label>
                        <div class="col-sm-3">
                            <input type="date" id="end_date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>
                    </div>
            
                    <div class="form-group row">
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="table-responsive rounded mb-3">
                <table class="table mb-0">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">
                            <th>No.</th>
                            <th>No Pesanan</th>
                            <th>@sortablelink('order_date', 'Tanggal Pesanan')</th>
                            <th>Total Pesanan</th>
                            <th>Harga</th>
                            <th>Harga + PPN</th>
                            <th>Bayar</th>
                            <th>Kembalian</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ (($orders->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>{{ $order->invoice_no }}</td>
                            <td>{{ $order->order_date }}</td>
                            <td>{{ $order->total_products }} pcs</td>
                            <td>${{ number_format($order->sub_total, 2) }}</td>
                            {{-- <td>${{ $order->pay }}</td> --}}
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td>${{ number_format($order->pay, 2) }}</td>
                            <td>${{ number_format($order->due, 2) }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td>
                                <span class="badge badge-success">{{ $order->order_status }}</span>
                            </td>
                            <td>
                                <form action="{{ route('order.destroy', $order->id) }}" method="POST" style="margin-bottom: 5px">
                                    @method('Hapus')
                                    @csrf
                                <div class="d-flex align-items-center list-action">
                                    <a class="btn btn-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Details" href="{{ route('order.orderDetails', $order->id) }}">
                                        Rincian
                                    </a>
                                    <a class="btn btn-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Print" href="{{ route('order.invoiceDownload', $order->id) }}">
                                        Cetak
                                    </a>
                                    <button type="submit" class="btn btn-warning mr-2 border-none" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="ri-delete-bin-line mr-0"></i></button>
                                </div>
                            </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="ligth-body">
                        <tr>
                            <th>Total</th>
                            <th></th>
                            <th></th>
                            <th>{{ $orders->sum('total_products') }} pcs </th>
                            <th></th>
                            <th> ${{ number_format($orders->sum('total'), 2) }}</th>
                            <th>${{ number_format($orders->sum('pay'), 2) }}</th>
                            <th>${{ number_format($orders->sum('due'), 2) }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            {{ $orders->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
