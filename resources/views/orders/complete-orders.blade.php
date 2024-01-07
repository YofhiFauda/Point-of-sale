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
                    <h4 class="mb-3">Complete Order List</h4>
                </div>
                <div>
                    <a href="{{ route('order.exportData') }}" class="btn btn-success add-list">Export</a>
                    {{-- <button type="submit" class="btn btn-danger" name="delete_all" value="1" onclick="return confirm('Are you sure you want to delete all transactions?')">Delete All Transactions</button> --}}
                    <form action="{{ route('order.destroyAll') }}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                         <button type="submit" class="btn btn-danger" name="delete_all" value="1" onclick="return confirm('Are you sure you want to delete all transactions?')">Delete All Transactions</button>
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
                        <label class="control-label col-sm-3 align-self-center" for="search">Search:</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" id="search" class="form-control" name="search" placeholder="Search order" value="{{ request('search') }}">
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
                        <label class="control-label align-self-center" for="start_date">Start Date:</label>
                        <div class="col-sm-4">
                            <input type="date" id="start_date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                        </div>
                        <label class="control-label align-self-center" for="end_date">End Date:</label>
                        <div class="col-sm-4">
                            <input type="date" id="end_date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>
                    </div>
            
                    <div class="form-group row">
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
                            <th>Invoice No</th>
                            <th>@sortablelink('customer.name', 'name')</th>
                            <th>@sortablelink('order_date', 'order date')</th>
                            <th>@sortablelink('pay')</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ (($orders->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>{{ $order->invoice_no }}</td>
                            <td>{{ $order->customer->name }}</td>
                            <td>{{ $order->order_date }}</td>
                            <td>{{ $order->pay }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td>
                                <span class="badge badge-success">{{ $order->order_status }}</span>
                            </td>
                            <td>
                                <form action="{{ route('order.destroy', $order->id) }}" method="POST" style="margin-bottom: 5px">
                                    @method('delete')
                                    @csrf
                                <div class="d-flex align-items-center list-action">
                                    <a class="btn btn-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Details" href="{{ route('order.orderDetails', $order->id) }}">
                                        Details
                                    </a>
                                    <a class="btn btn-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Print" href="{{ route('order.invoiceDownload', $order->id) }}">
                                        Print
                                    </a>
                                    <button type="submit" class="btn btn-warning mr-2 border-none" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="ri-delete-bin-line mr-0"></i></button>
                                </div>
                            </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $orders->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
