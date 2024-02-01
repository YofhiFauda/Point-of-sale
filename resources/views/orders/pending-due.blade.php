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
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Daftar Pembayaran Tertunda</h4>
                </div>
                <div>
                    <a href="{{ route('order.pendingDue') }}" class="btn btn-danger add-list"><i class="fa-solid fa-trash mr-3"></i>Hapus Pencarian</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('order.pendingDue') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="form-group row">
                        <label for="row" class="col-sm-3 align-self-center">Baris:</label>
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
                                </div>
                            </div>
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
                            <td>{{ (($orders->currentPage() * 10) - 10) + $loop->iteration }}</td>
                            <td>{{ $order->invoice_no }}</td>
                            <td>{{ $order->order_date }}</td>
                            <td>{{ $order->total_products }} pcs</td>
                            <td>Rp {{ number_format($order->total) }}</td>
                            <td>Rp {{ number_format($order->pay) }}</td>
                            <td>Rp {{ number_format($order->due) }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td>
                                <span class="badge badge-success">{{ $order->order_status }}</span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary-dark btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="payDue({{ $order->id }})">Bayar</button>
                                </div>
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

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('order.updateDue') }}" method="post">
                @csrf
                <input type="hidden" name="order_id" id="order_id">
                <div class="modal-body">
                    <h3 class="modal-title text-center mx-auto">Bayar Hutang</h3>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="due">Bayar Sekarang</label>
                            <input type="text" class="form-control bg-white @error('due') is-invalid @enderror" id="due" name="due">
                            @error('due')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Bayar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function payDue(id){
        $.ajax({
            type: 'GET',
            url : '/order/due/' + id,
            dataType: 'json',
            success: function(data) {
                $('#due').val(data.due);
                $('#order_id').val(data.id);
            }
        });
    }
</script>

@endsection