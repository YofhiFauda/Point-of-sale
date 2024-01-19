@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
        @if (session()->has('success'))
            <div class="alert text-white bg-success" role="alert">
                <div class="iq-alert-text">{{ session('success') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
                </button>
            </div>
        @endif
        </div>
        {{-- <div class="col-lg-4">
            <div class="card card-transparent card-block card-stretch card-height border-none">
                <div class="card-body p-0 mt-lg-2 mt-0">
                    <h3 class="mb-3">Hi {{ auth()->user()->name }}, Good Morning</h3>
                    <p class="mb-0 mr-4">Your dashboard gives you views of key performance or business process.</p>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-info-light">
                                    <img src="../assets/images/product/1.png" class="img-fluid" alt="image">
                                </div>
                                <div>
                                    <p class="mb-2">Total Paid</p>
                                    {{-- <h4>$ {{ $total_paid }}</h4> --}}
                                    <h4>${{ number_format($total_paid, 2) }}</h4>
                                </div>
                            </div>
                            <div class="iq-progress-bar mt-2">
                                <span class="bg-info iq-progress progress-1" data-percent="85">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-danger-light">
                                    <img src="../assets/images/product/2.png" class="img-fluid" alt="image">
                                </div>
                                <div>
                                    <p class="mb-2">Total Due</p>
                                    {{-- <h4>$ {{ $total_due }}</h4> --}}
                                    <h4>${{ number_format($total_due, 2) }}</h4>
                                </div>
                            </div>
                            <div class="iq-progress-bar mt-2">
                                <span class="bg-danger iq-progress progress-1" data-percent="70">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-success-light">
                                    <img src="../assets/images/product/3.png" class="img-fluid" alt="image">
                                </div>
                                <div>
                                    <p class="mb-2">Complete Orders</p>
                                    <h4>{{ count($complete_orders) }}</h4>
                                </div>
                            </div>
                            <div class="iq-progress-bar mt-2">
                                <span class="bg-success iq-progress progress-1" data-percent="75">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-danger-light">
                                    <img src="../assets/images/product/2.png" class="img-fluid" alt="image">
                                </div>
                                <div>
                                    <p class="mb-2"> Pending Order</p>
                                    <h4>{{ count($order_status) }}</h4>
                                </div>
                            </div>
                            <div class="iq-progress-bar mt-2">
                                <span class="bg-danger iq-progress progress-1" data-percent="70">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="form-group row">
                    <label for="filterOption" class="col-sm- align-self-center">Sortir:</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="filterOption" onchange="filterOrders(this.value)">
                            <option value="all">Semua</option>
                            <option value="today">Hari ini</option>
                            <option value="this_week">Mingguan</option>
                            <option value="this_month">Bulanan</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="table-responsive rounded mb-3">
                <table class="table mb-0">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">
                            <th>No.</th>
                            <th>Photo</th>
                            <th>Nama Produk</th>
                            <th>Kode Produk</th>
                            <th>Order</th>
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
                            <td>${{ number_format($item->unitcost, 2) }}</td>
                            <td>${{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-block card-stretch card-height">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Produk Unggulan</h4>
                    </div>
                    <div class="card-header-toolbar d-flex align-items-center">
                        <div class="dropdown">
                            <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton006"
                                data-toggle="dropdown">
                                Bulan Ini<i class="ri-arrow-down-s-line ml-1"></i>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right shadow-none"
                                aria-labelledby="dropdownMenuButton006">
                                <a class="dropdown-item" href="#">Tahun</a>
                                <a class="dropdown-item" href="#">Bulan</a>
                                <a class="dropdown-item" href="#">Minggu</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled row top-product mb-0">
                    @foreach ($products as $product)
                        <li class="col-lg-3">
                            <div class="card card-block card-stretch card-height mb-0">
                                <div class="card-body">
                                    <div class="bg-warning-light rounded">
                                        <img src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}" class="style-img img-fluid m-auto p-3" alt="image">
                                    </div>
                                    <div class="style-text text-left mt-3">
                                        <h5 class="mb-1">{{ $product->product_name }}</h5>
                                        <p class="mb-0">{{ $product->product_store }} Item</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-transparent card-block card-stretch mb-4">
                <div class="card-header d-flex align-items-center justify-content-between p-0">
                    <div class="header-title">
                        <h4 class="card-title mb-0">Produk Baru</h4>
                    </div>
                    <div class="card-header-toolbar d-flex align-items-center">
                        <div><a href="#" class="btn btn-primary view-btn font-size-14">Lihat Semua</a></div>
                    </div>
                </div>
            </div>
            @foreach ($new_products as $product)

            <div class="card card-block card-stretch card-height-helf">
                <div class="card-body card-item-right">
                    <div class="d-flex align-items-top">
                        <div class="bg-warning-light rounded">
                            <img src="../assets/images/product/04.png" class="style-img img-fluid m-auto" alt="image">
                        </div>
                        <div class="style-text text-left">
                            <h5 class="mb-2">{{ $product->product_name }}</h5>
                            <p class="mb-2">Stock : {{ $product->product_store }}</p>
                            <p class="mb-0">Price : ${{ $product->selling_price }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Page end  -->
</div>
@endsection 

@section('specificpagescripts')
{{-- sortir --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the current filter value from the URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const filterOption = urlParams.get('filter');

        // Set the default value of the dropdown based on the filter parameter
        const dropdown = document.getElementById('filterOption');
        if (dropdown) {
            dropdown.value = filterOption || 'all';
        }
    });

    function filterOrders(option) {
        // Redirect to the same page with the selected filter option
        window.location.href = "?filter=" + option;
    }
</script>

<!-- Table Treeview JavaScript -->
<script src="{{ asset('assets/js/table-treeview.js') }}"></script>
<!-- Chart Custom JavaScript -->
<script src="{{ asset('assets/js/customizer.js') }}"></script>
<!-- Chart Custom JavaScript -->
<script async src="{{ asset('assets/js/chart-custom.js') }}"></script>
@endsection
