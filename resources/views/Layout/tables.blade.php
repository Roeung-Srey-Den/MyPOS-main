<x-layout>
  <x-slot name="header">
    Customers Page
  </x-slot>

<div class="container">

  {{-- Dine In Section --}}
  <div class="col-12 mb-4">
    <h3>Dine In</h3>
    <div class="d-flex flex-wrap gap-2">
      @foreach($order as $orders)
        <div class="card rounded mx-2 mt-1" style="width: 13rem;height:13rem;" data-bs-toggle="modal" data-bs-target="#table{{ $orders->id}}">
          <div class="card-body" style="cursor:pointer;">
            <h5 class="card-title">Table Number</h5>
            <h4 class="card-subtitle mb-2 text-muted">{{ $orders->tableNumber->table_name }}</h4>
            <p>Click to view</p>
            <p class="text-danger paid-status" data-order-id="{{ $orders->id }}" >{{$orders->status}}</p>
          </div>
        </div>

        {{-- Modal --}}
        <x-modal id="table{{$orders->id}}" data-order-id="{{ $orders->id }}" class="modal-dialog modal-dialog-centered" method="POST" action="{{ route('order.add.bulk') }}">
          <x-slot name="header">
            Table {{ $orders->tableNumber->table_name }}
          </x-slot>

          <div style="width: 100%;">
            <ul style="list-style:none; padding:0;">
              <li>Note: {{ $orders->note }}</li>
              <li>Tax: {{ $orders->tax }}</li>
              <li>Total: {{ $orders->total }}</li>
            </ul>

            <div class="mt-3 d-none" id="menu-form-container-{{ $orders->id }}">
              @csrf
              <input type="hidden" name="order_type" value="dinein">
              <input type="hidden" name="table_number_id" value="{{ $orders->tableNumber->id }}">

              <div class="menu-group">
                <div class="menu-item border-bottom p-2 mb-2">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Product</label>
                      <select name="product_id[]" class="form-control" required>
                        @foreach($products as $product)
                          <option value="{{ $product->id }}" data-price="{{ $product->pro_price }}">{{ $product->pro_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label>Quantity</label>
                      <input type="number" name="quantity[]" min="1" value="1" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                      <label>Price</label>
                      <input type="number" name="price[]" min="0" step="0.01" value="0" class="form-control" readonly>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                      <button type="button" class="btn btn-danger remove-item">Remove</button>
                    </div>
                  </div>
                </div>
              </div>

              <button type="button" class="btn btn-secondary my-2 add-item" data-order-id="{{ $orders->id }}">Add Another Menu</button>
              <button type="submit" class="btn btn-success">Add All Menus</button>
            </div>
          </div>

          <x-slot name="footer">
            <button type="button" class="btn btn-secondary me-2" onclick="showneworder({{ $orders->id }})">Add Menu</button>
            <button class="btn btn-primary" type="button"
              onclick="markPaidAndPrint({{ $orders->id }}, 'receipt-{{ $orders->id }}')">
             Cash Out
          </button>
          </x-slot> 
        </x-modal>

        {{-- Receipt --}}
        <x-reciept id="receipt-{{ $orders->id }}">
          <p><strong>Table:</strong> {{ $orders->tableNumber->table_name }}</p>
          <p><strong>Order ID:</strong> {{ $orders->id }}</p>
          <hr class="w-100">
          @foreach ($orders->orderItems as $item)
          <div class="d-flex justify-content-between">
            <span>{{ $item->product->pro_name }} x{{ $item->quantity }}</span>
            <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
          </div>
          @endforeach
          <hr class="w-100">
          <div class="d-flex justify-content-between"><strong>Subtotal:</strong> <span>${{ number_format($orders->subtotal, 2) }}</span></div>
          <div class="d-flex justify-content-between"><strong>Tax (10%):</strong> <span>${{ number_format($orders->tax, 2) }}</span></div>
          <div class="d-flex justify-content-between"><strong>Total:</strong> <span>${{ number_format($orders->total, 2) }}</span></div>
        </x-reciept>

      @endforeach
    </div>
  </div>

  <hr class="my-3 w-100">

  {{-- Delivery Section --}}
  <div class="col-12 mb-4">
    <h3>Delivery</h3>
    <div class="d-flex flex-wrap gap-2">
      @foreach($delivery as $deliverys)
        <div class="card rounded mx-2 mt-1" style="width: 13rem;height:13rem;" data-bs-toggle="modal" data-bs-target="#delivery{{ $deliverys->id}}">
          <div class="card-body">
            <h5 class="card-title">Delivery</h5>
            <h4 class="card-subtitle mb-2 text-muted">{{ $deliverys->customer->name}}</h4>
            <p>Click to view</p>
            <p class="text-danger paid-status" data-order-id="delivery-{{ $deliverys->id }}" >unpaid</p>

          </div>
        </div>

        {{-- Modal --}}
        <x-modal id="delivery{{$deliverys->id}}" data-order-id="{{ $deliverys->id }}" class="modal-dialog modal-dialog-centered" method="POST" action="{{ route('order.add.bulk') }}">
          @csrf
          <input type="hidden" name="order_type" value="delivery">
          <input type="hidden" name="customer_id" value="{{ $deliverys->customer->id }}">
          
          <ul style="list-style:none; padding:0;">
            <li>Customer: {{ $deliverys->customer->name }}</li>
            <li>Note: {{ $deliverys->note }}</li>
            <li>Tax: {{ $deliverys->tax }}</li>
            <li>Total: {{ $deliverys->total }}</li>
          </ul>

          <div class="mt-3 d-none" id="menu-form-container-delivery-{{ $deliverys->id }}">
            <div class="menu-group">
              <div class="menu-item border-bottom p-2 mb-2">
                <div class="row">
                  <div class="col-md-4">
                    <label>Product</label>
                    <select name="product_id[]" class="form-control" required>
                      @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->pro_price }}">{{ $product->pro_name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label>Quantity</label>
                    <input type="number" name="quantity[]" min="1" value="1" class="form-control" required>
                  </div>
                  <div class="col-md-3">
                    <label>Price</label>
                    <input type="number" name="price[]" min="0" step="0.01" value="0" class="form-control" readonly>
                  </div>
                  <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-item">Remove</button>
                  </div>
                </div>
              </div>
            </div>

            <button type="button" class="btn btn-secondary my-2 add-item" data-order-id="delivery-{{ $deliverys->id }}">Add Another Menu</button>
            <button type="submit" class="btn btn-success">Add All Menus</button>
          </div>

          <x-slot name="footer">
            <button type="button" class="btn btn-secondary me-2" onclick="showneworder('delivery-{{ $deliverys->id }}')">Add Menu</button>
            <button class="btn btn-primary" type="button"
              onclick="markPaidAndPrint('delivery-{{ $deliverys->id }}', 'receipt-delivery-{{ $deliverys->id }}')">
              Cash Out
          </button>
            </x-slot>
        </x-modal>

        <x-reciept id="receipt-delivery-{{ $deliverys->id }}">
          <p><strong>Customer:</strong> {{ $deliverys->customer->name }}</p>
          <p><strong>Order ID:</strong> {{ $deliverys->id }}</p>
          <hr class="w-100">
          @foreach ($deliverys->orderItems as $item)
            <div class="d-flex justify-content-between">
              <span>{{ $item->product->pro_name }} x{{ $item->quantity }}</span>
              <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
            </div>
          @endforeach
          <hr class="w-100">
          <div class="d-flex justify-content-between"><strong>Subtotal:</strong> <span>${{ number_format($deliverys->subtotal, 2) }}</span></div>
          <div class="d-flex justify-content-between"><strong>Tax:</strong> <span>${{ number_format($deliverys->tax, 2) }}</span></div>
          <div class="d-flex justify-content-between"><strong>Total:</strong> <span>${{ number_format($deliverys->total, 2) }}</span></div>
        </x-reciept>

      @endforeach
    </div>
  </div>

  <hr class="my-3 w-100">

  {{-- Takeaway Section --}}
  <div class="col-12 mb-4">
    <h3>Takeaway</h3>
    <div class="d-flex flex-wrap gap-2">
      @foreach($TakeawayOrders as $takeaway)
        <div class="card rounded mx-2 mt-1" style="width: 13rem;height:13rem;" data-bs-toggle="modal" data-bs-target="#takeaway{{ $takeaway->id}}">
          <div class="card-body">
            <h5 class="card-title">Takeaway</h5>
            <h4 class="card-subtitle mb-2 text-muted">{{ $takeaway->customer->name}}</h4>
            <p>Click to view</p>
           <p class="text-danger paid-status" data-order-id="takeaway-{{ $takeaway->id }}" >unpaid</p>

          </div>
        </div>

        {{-- Modal --}}
        <x-modal id="takeaway{{$takeaway->id}}" data-order-id="{{ $takeaway->id }}" class="modal-dialog modal-dialog-centered" method="POST" action="{{ route('order.add.bulk') }}">
          @csrf
          <input type="hidden" name="order_type" value="takeaway">
          <input type="hidden" name="customer_id" value="{{ $takeaway->customer->id }}">
          
          <ul style="list-style:none; padding:0;">
            <li>Customer: {{ $takeaway->customer->name }}</li>
            <li>Note: {{ $takeaway->note }}</li>
            <li>Tax: {{ $takeaway->tax }}</li>
            <li>Total: {{ $takeaway->total }}</li>
          </ul>

          <div class="mt-3 d-none" id="menu-form-container-takeaway-{{ $takeaway->id }}">
            <div class="menu-group">
              <div class="menu-item border-bottom p-2 mb-2">
                <div class="row">
                  <div class="col-md-4">
                    <label>Product</label>
                    <select name="product_id[]" class="form-control" required>
                      @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->pro_price }}">{{ $product->pro_name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label>Quantity</label>
                    <input type="number" name="quantity[]" min="1" value="1" class="form-control" required>
                  </div>
                  <div class="col-md-3">
                    <label>Price</label>
                    <input type="number" name="price[]" min="0" step="0.01" value="0" class="form-control" readonly>
                  </div>
                  <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-item">Remove</button>
                  </div>
                </div>
              </div>
            </div>

            <button type="button" class="btn btn-secondary my-2 add-item" data-order-id="takeaway-{{ $takeaway->id }}">Add Another Menu</button>
            <button type="submit" class="btn btn-success">Add All Menus</button>
          </div>

          <x-slot name="footer">
            <button type="button" class="btn btn-secondary me-2" onclick="showneworder('takeaway-{{ $takeaway->id }}')">Add Menu</button>
            <button class="btn btn-primary" type="button"
             onclick="markPaidAndPrint('takeaway-{{ $takeaway->id }}', 'receipt-takeaway-{{ $takeaway->id }}')">
            Cash Out
        </button>
          </x-slot>
        </x-modal>

        <x-reciept id="receipt-takeaway-{{ $takeaway->id }}">
          <p><strong>Customer:</strong> {{ $takeaway->customer->name }}</p>
          <p><strong>Order ID:</strong> {{ $takeaway->id }}</p>
          <hr class="w-100">
          @foreach ($takeaway->orderItems as $item)
            <div class="d-flex justify-content-between">
              <span>{{ $item->product->pro_name }} x{{ $item->quantity }}</span>
              <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
            </div>
          @endforeach
          <hr class="w-100">
          <div class="d-flex justify-content-between"><strong>Subtotal:</strong> <span>${{ number_format($takeaway->subtotal, 2) }}</span></div>
          <div class="d-flex justify-content-between"><strong>Tax:</strong> <span>${{ number_format($takeaway->tax, 2) }}</span></div>
          <div class="d-flex justify-content-between"><strong>Total:</strong> <span>${{ number_format($takeaway->total, 2) }}</span></div>
        </x-reciept>

      @endforeach
    </div>
  </div>

</div>

</x-layout>
