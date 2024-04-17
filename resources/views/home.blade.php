@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Success:</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Success:</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <h5><stroge>Product Import</stroge><h5>
                    <form method="post" name="product" id="product" action="{{ route('import-product') }}" enctype="multipart/form-data">
                        @csrf()
                        <input type="file" name="file">
                        @error('file')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <br>
                        <br>
                        <button type="submit" class="btn btn-primary" name="Import Product" id="import-product">Import Product</button>
                    </form>
                    <br>
                    <br>
                    <hr>
                    <h5><stroge>Add Sale Item Product</stroge><h5>
                    <form method="post" action="{{ route('sale-item') }}" name="sale-item" id="sale-item">
                        @csrf()
                        <!-- Add your form fields here if needed -->
                        <button type="submit" class="btn btn-primary" name="saleItem" id="saleItem">Add Sale Item </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
