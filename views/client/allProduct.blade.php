@extends('client.layouts.main')

@section('content')

    <!-- Header-->
    @include('client.layouts.partials.header')
    
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($products['data'] as $item)
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src="{{file_url($item['p_img_thumbnail'])}}" alt="..." />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">{{$item['p_name']}}</h5>
                                <!-- Product price-->
                                <s>{{ number_format($item['p_price'] * 1, 0, '.', '.')}}đ</s> - {{number_format($item['p_price_sale'] * 1, 0, '.', '.')}}đ
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="/detail/{{$item['p_slug']}}">View
                                    options</a></div>
                        </div>
                    </div>
                </div>
                @endforeach
   
            </div>
            <nav aria-label="Page navigation" class="d-flex">
                <ul class="pagination">
                    @for ($i = 1; $i <= $products['totalPage']; ++$i)
                        <li class="page-item @if ($product['page'] == $i) active @endif">
                            <a class="page-link" href="/allproducts/?page={{ $i }}&limit={{ $products['limit'] }}">{{ $i }}</a>
                        </li>
                    @endfor
                </ul>
            </nav>
        </div>
    </section>
@endsection