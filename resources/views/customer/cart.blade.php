@extends('customer.layout')

@section('content')
@php
    $showCart = false;
    if(auth()->check() && auth()->user()->hasRole('customer')) {
        $showCart = true;
    }
@endphp

@if(!$showCart)
    <script>window.addEventListener('DOMContentLoaded', function() { showLoginModal(); });</script>
@else
    <div class="container py-5">
        <h2 class="mb-4 text-orange fw-bold">Your Cart</h2>
        @php
            $cart = session('cart', []);
        @endphp
        @if(count($cart) > 0)
            <div class="card shadow-lg p-4">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th width="180">Quantity</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php
                            $total = $item['price'] * $item['quantity'];
                            $grandTotal += $total;
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ isset($item['image']) ? asset('storage/'.$item['image']) : 'https://cdn-icons-png.flaticon.com/512/1170/1170678.png' }}"
                                         width="70"
                                         class="rounded me-3">
                                    {{ $item['name'] }}
                                </div>
                            </td>
                            <td>₹ {{ number_format($item['price'],2) }}</td>
                            <td>
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex">
                                    @csrf
                                    <input type="number"
                                           name="quantity"
                                           value="{{ $item['quantity'] }}"
                                           min="1"
                                           class="form-control me-2">
                                    <button class="btn btn-orange btn-sm">Update</button>
                                </form>
                            </td>
                            <td>₹ {{ number_format($total,2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <hr>
                <div class="text-end">
                    <h4>Total: <span class="text-orange">₹ {{ number_format($grandTotal,2) }}</span></h4>
                    <a href="/checkout" class="btn btn-orange btn-lg mt-3">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        @else
            <div class="alert alert-warning text-center py-5">
                <i class="bi bi-cart-x display-4 mb-3 text-muted"></i><br>
                <span class="fs-5">Your cart is empty.</span>
            </div>
        @endif
    </div>
@endif
@endsection