<!-- Right side container -->
<div class="d-flex flex-column" style="height: 100vh;">

    <!-- White cart panel with scroll -->
    <div class="bg-light shadow rounded-2 flex-grow-1 d-flex flex-column">
    <div class="p-2">
        <div class="d-flex flex-nowrap align-items-center justify-content-between gap-2 overflow-auto">
  <!-- + Add Customer -->
  <div>
  <button class="btn btn-secondary d-flex align-items-center text-nowrap" data-bs-toggle="modal" data-bs-target="#customerModalCreate">
    <span class="d-none d-lg-inline me-1">+ Add</span>
    Customer
  </button>
</div>


  <!-- Customer <select> -->
  <div class="flex-grow-1 px-1" style="flex: 0 0 100px;" id="tableBox">
    <select class="form-control" id="tableSelect">
      @foreach($table as $t)
        <option value="{{$t->id}}">Table {{ $t->table_name }}</option>
      @endforeach
    </select>
  </div>
   <!-- Delivery and takeaway <select> -->
  <div class="flex-grow-1 px-1" style="display:none;" id="customerBox">
    <select class="form-control" id="customerSelect">
      <option>Delivery</option>
      @foreach($customer as $customers)
        <option value="{{$customers->id}}">{{ $customers->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-check">
  <input class="form-check-input" type="checkbox" id="checkDelivery" onchange="toggleSelect()">
  <label class="form-check-label" for="checkDelivery">
    Delivery/Takeaway
  </label>
</div>
  

  <!-- Action buttons -->
  <div class="d-flex gap-2">
    @if(session('role')==='Admin')
    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">+</button>
    @endif
    <button class="btn btn-secondary"><i class="fa-solid fa-money-bill"></i></button>
    <button class="btn btn-secondary" onClick="clearCart()"><i class="fa-solid fa-rotate-right"></i></button>
  </div>
</div>

        <hr class="my-2">
    </div>

    <!-- Scrollable cart content -->
    <div id="cart-area" class="px-2 overflow-y-auto" style="max-height: 300px; flex-grow: 1;">
        <div id="cart"></div>
    </div>
    </div>


    <!-- Sticky Total Section OUTSIDE white cart area -->
    <div class="bg-white shadow  p-3">
        <div class="bg-warning p-2 mb-2">
            Add &nbsp;&nbsp;&nbsp;&nbsp;Discount Coupon Code Note
        </div>
        <div class="cashier-total">
            <div class="d-flex justify-content-between">
                <span>Subtotal</span>
                <span id="subtotal">$0.00</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Tax(10%)</span>
                <span id="tax">$0.00</span>
            </div>
            <div class="d-flex justify-content-between fw-bold">
                <span>Payoutable Amount</span>
                <span id="total">$0.00</span>
            </div>
            <div class="mt-3 d-flex">
                <button class="btn btn-warning w-50">Hold Order</button>
                <button class="btn btn-success w-50 ms-2 p-4" id="proceed">Proceed</button>
            </div>
        </div>
    </div>
</div>
