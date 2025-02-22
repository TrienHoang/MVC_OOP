@extends('client.layouts.main')

@section('content')
    <!-- Header-->
    @include('client.layouts.partials.header')

    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ file_url($product['p_img_thumbnail']) }}" class="img-fluid rounded" alt="Ảnh sản phẩm">
                </div>
                <div class="col-md-6">
                    <h2 class="fw-bold ">{{ $product['p_name'] }}</h2>
                    <p class="text-muted mb-4 ">Danh mục: <span class="text-primary">{{ $product['c_name'] }}</span></p>
                    <p class="text-danger fs-4 mt-5">Giá: <del
                            class="text-muted">{{ number_format($product['p_price'] * 1, 0, '.', '.') }}đ</del>
                        <strong>{{ number_format($product['p_price_sale'] * 1, 0, '.', '.') }}đ</strong>
                    </p>
                    <p class="text-secondary">{{ $product['p_overview'] }}</p>
                   <div class="col-auto">
                        <a class="btn btn-primary" href="">Thêm vào giỏ hàng</a>
                        <a class="btn btn-outline-secondary" href="">Mua ngay</a>
                    </div>
                </div>
 
            </div>
        </div>
        <div class="row mt-4 p-5">
            <div class="col-12">
                <h3>Mô tả chi tiết</h3>
                <p>{!! $product['p_content'] !!}</p>
                {{-- <p>Chúng tôi cam kết cung cấp sản phẩm chính hãng với giá cả cạnh tranh nhất. Hãy đặt hàng ngay hôm nay để tận hưởng những ưu đãi hấp dẫn!</p> --}}
            </div>
        </div>
    </section>
@endsection
