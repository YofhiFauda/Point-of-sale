@extends('dashboard.body.main')

@section('container')

@php
    $group_names = [
        [
            'slug' => 'pos',
            'name' => 'POS'
        ],
        [
            'slug' => 'employee',
            'name' => 'Employee'
        ],
        [
            'slug' => 'customer',
            'name' => 'Customer'
        ],
        [
            'slug' => 'supplier',
            'name' => 'Supplier'
        ],
        [
            'slug' => 'category',
            'name' => 'Category'
        ],
        [
            'slug' => 'product',
            'name' => 'Product'
        ],
        [
            'slug' => 'orders',
            'name' => 'Orders'
        ],
        [
            'slug' => 'stock',
            'name' => 'Stock'
        ],
        [
            'slug' => 'roles',
            'name' => 'Roles'
        ],
        [
            'slug' => 'user',
            'name' => 'User'
        ],
    ]
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit Permission</h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('permission.update', $permission->id) }}" method="POST">
                    @method('put')
                    @csrf
                        <!-- begin: Input Data -->
                        <div class=" row align-items-center">
                            <div class="form-group col-md-6">
                                <label for="name">Nama Permission <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $permission->name) }}" required autocomplete="off">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="group_name">Nama Group <span class="text-danger">*</span></label>
                                <select class="form-control @error('group_name') is-invalid @enderror" name="group_name" required>
                                    <option disabled>-- Pilih Group --</option>
                                    @foreach ($group_names as $item)
                                        <option value="{{ $item['slug'] }}" {{ $permission->group_name == $item['slug'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('group_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- end: Input Data -->
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                            <a class="btn bg-danger" href="{{ route('permission.index') }}">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>
@endsection
