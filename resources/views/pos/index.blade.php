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
            <div>
                <h4 class="mb-3">Point of Sale</h4>
            </div>
        </div>

        <div class="col-lg-6 col-md-12">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <form action="#" method="get">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <div class="form-group row">
                                <label for="row" class="align-self-center mx-2">Row:</label>
                                <div>
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
                                <div class="input-group col-sm-8">
                                    <input type="text" id="search" class="form-control" name="search" placeholder="Search product" value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="input-group-text bg-primary"><i class="fa-solid fa-magnifying-glass font-size-20"></i></button>
                                        <a href="{{ route('products.index') }}" class="input-group-text bg-danger"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="table-responsive rounded mb-3 border-none">
                        <table class="table mb-0">
                            <thead class="bg-white text-uppercase">
                                <tr class="ligth ligth-data">
                                    <th>No.</th>
                                    <th>Photo</th>
                                    <th>@sortablelink('product_name', 'nama')</th>
                                    <th>@sortablelink('selling_price', 'harga')</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="ligth-body">
                                @forelse ($products as $product)
                                <tr>
                                    <td>{{ (($products->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                                    <td>
                                        <img class="avatar-60 rounded" src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}">
                                    </td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->selling_price }}</td>
                                    <td>
                                        <form action="{{ route('pos.addCart') }}" method="POST"  style="margin-bottom: 5px">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <input type="hidden" name="name" value="{{ $product->product_name }}">
                                            <input type="hidden" name="price" value="{{ $product->selling_price }}">

                                            <button type="submit" class="btn btn-primary border-none" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add"><i class="far fa-plus mr-0"></i></button>
                                        </form>
                                    </td>
                                </tr>

                                @empty
                                <div class="alert text-white bg-danger" role="alert">
                                    <div class="iq-alert-text">Data not Found.</div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ri-close-line"></i>
                                    </button>
                                </div>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 mb-3">
            <table class="table">
                <thead>
                    <tr class="ligth">
                        <th scope="col">Nama</th>
                        <th scope="col">Order</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productItem as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td style="min-width: 140px;">
                            <form action="{{ route('pos.updateCart', $item->rowId) }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="number" class="form-control" name="qty" required value="{{ old('qty', $item->qty) }}" min=0>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success border-none" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sumbit"><i class="fas fa-check"></i></button>
                                    </div>
                                </div>
                            </form>
                        </td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->subtotal }}</td>
                        <td>
                            <a href="{{ route('pos.deleteCart', $item->rowId) }}" class="btn btn-danger border-none" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa-solid fa-trash mr-0"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="container row text-center">
                <div class="form-group col-sm-6">
                    <p class="h4 text-primary">Total Order: {{ Cart::count() }}</p>
                </div>
                <div class="form-group col-sm-6">
                    <p class="h4 text-primary">Harga: {{ Cart::subtotal() }}</p>
                </div>
                <div class="form-group col-sm-6">
                    <p class="h4 text-primary">PPN: {{ Cart::tax() }}</p>
                </div>
                <div class="form-group col-sm-6">
                    <p class="h4 text-primary">Total: {{ Cart::total() }}</p>
                </div>
            </div>

            <form action="{{ route('pos.createInvoice') }}" method="POST">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ $customers->first()->id }}">

                    <div class="col-md-12 mt-4">
                        <div class="d-flex flex-wrap align-items-center justify-content-center">
                            <button type="submit" class="btn btn-success add-list mx-1">Buat Pesanan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection