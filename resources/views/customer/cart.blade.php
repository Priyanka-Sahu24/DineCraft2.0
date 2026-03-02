@extends('customer.layout')

@section('content')

<div class="container py-5">

    <h2 class="mb-4 text-orange fw-bold">Your Cart</h2>

    @if(session('cart') && count($cart) > 0)

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
                                <img src="{{ asset('storage/'.$item['image']) }}"
                                     width="70"
                                     class="rounded me-3">
                                {{ $item['name'] }}
                            </div>
                        </td>

                        <td>₹ {{ $item['price'] }}</td>

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

                        <td>₹ {{ $total }}</td>

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
                <h4>Total: <span class="text-orange">₹ {{ $grandTotal }}</span></h4>

                <a href="/checkout" class="btn btn-orange btn-lg mt-3">
                    Proceed to Checkout
                </a>
            </div>

        </div>

    @else

        <div class="alert alert-warning">
            Your cart is empty.
        </div>

    @endif

</div>

@endsection