@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Informasi Detail Pesanan</h4>
                    </div>
                </div>

                <div class="card-body">
                    <!-- begin: Show Data -->
                    <div class="form-group row align-items-center">
                        <div class="col-md-12">
                            <div class="profile-img-edit">
                                <div class="crm-profile-img-edit">
                                    <img class="crm-profile-pic rounded-circle avatar-100" id="image-preview" src="{{ $order->customer->photo ? asset('storage/customers/'.$order->customer->photo) : asset('storage/customers/default.png') }}" alt="profile-pic">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        {{-- <div class="form-group col-md-12">
                            <label>Customer Name</label>
                            <input type="text" class="form-control bg-white" value="{{ $order->customer->name }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer Email</label>
                            <input type="text" class="form-control bg-white" value="{{ $order->customer->email }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer Phone</label>
                            <input type="text" class="form-control bg-white" value="{{ $order->customer->phone }}" readonly>
                        </div> --}}
                        <div class="form-group col-md-6">
                            <label>Tanggal Pesanan</label>
                            <input type="text" class="form-control bg-white" value="{{ $order->order_date }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nomor Pesanan</label>
                            <input class="form-control bg-white" id="buying_date" value="{{ $order->invoice_no }}" readonly/>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Status Pembayaran</label>
                            <input class="form-control bg-white" id="expire_date" value="{{ $order->payment_status }}" readonly />
                        </div>
                        <div class="form-group col-md-6">
                            <label>jumlah Pembayaran</label>
                            <input type="text" class="form-control bg-white" value="{{ $order->pay }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Total Kembalian</label>
                            <input type="text" class="form-control bg-white" value="{{ $order->due }}" readonly>
                        </div>
                    </div>
                    <!-- end: Show Data -->

                    @if ($order->order_status == 'pending')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex align-items-center list-action">
                                    <form action="{{ route('order.updateStatus') }}" method="POST" style="margin-bottom: 5px">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $order->id }}">
                                        <button type="submit" class="btn btn-success mr-2 border-none" data-toggle="tooltip" data-placement="top" title="" data-original-title="Complete">Pesanan Selesai</button>

                                        <a class="btn btn-danger mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cancel" href="{{ route('order.pendingOrders') }}">Batal</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>


        <!-- end: Show Data -->
        <div class="col-lg-12">
            <div class="table-responsive rounded mb-3">
                <table class="table mb-0">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">
                            <th>No.</th>
                            <th>Photo</th>
                            <th>Nama Produk</th>
                            <th>Kode Produk</th>
                            <th>Jumlah Pesanan</th>
                            <th>Harga</th>
                            <th>Total(+PPN)</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @foreach ($orderDetails as $item)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>
                                <img class="avatar-60 rounded" src="{{ $item->product->product_image ? asset('storage/products/'.$item->product_image) : asset('storage/products/default.webp') }}">
                            </td>
                            <td>{{ $item->product->product_name }}</td>
                            <td>{{ $item->product->product_code }}</td>
                            <td>{{ $item->quantity }}</td>
                            {{-- <td>${{ $item->unitcost }}</td>
                            <td>${{ $item->total }}</td> --}}
                            <td>Rp {{ number_format($item->unitcost) }}</td>
                            <td>Rp {{ number_format($item->total) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>

@include('components.preview-img-form')
@endsection
