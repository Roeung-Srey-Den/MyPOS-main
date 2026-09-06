<x-layout>
  <x-slot name="header">
    Report page
  </x-slot>
  <div class="container">
  <div class="row mt-2">
 
    <div class="col-md-3 col-sm-6">
    <div class="card shadow-sm p-3 mb-3 w-100">
    <div class="d-flex flex-wrap align-items-center ">
      <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle text-white" 
        style="width:80px; height:80px; font-size:32px; 
                background: linear-gradient(135deg, #02a902ff 0%, #49ef54ff 100%);
                box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
      <i class="fas fa-dollar-sign"></i>
      </div>
      <div class="ms-3">
        <h5 class="card-title mb-1">Today's Sales</h5>
        <p class="mb-0 text-muted">daily</p>
        <h4 class="mt-2"> {{$todaySale}} $</h4>
      </div>
    </div>
     
  </div>
  </div>

  
  <div class="col-md-3 col-sm-6">
  <div class="card shadow-sm p-3 mb-3 w-100">
    <div class="d-flex flex-wrap align-items-center">
      <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle text-white" 
        style="width:80px; height:80px; font-size:32px; 
                background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
      <i class="fas fa-shopping-cart"></i>
      </div>

      <div class="ms-3">
        <h5 class="card-title mb-1">Today Orders</h5>
        <p class="mb-0 text-muted">This month</p>
        <h4 class="mt-2">{{$todayOrder}}</h4>
      </div>
    </div>
</div>
</div>

  <div class="col-md-3 col-sm-6">
  <div class="card shadow-sm p-3 mb-3 w-100" >
    <div class="d-flex flex-wrap align-items-center">
      <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle text-white" 
        style="width:80px; height:80px; font-size:32px; 
                background: linear-gradient(135deg, #d01f1fff 0%, #f27777ff 100%);
                box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
      <i class="fas fa-clock"></i>
      </div>
      <div class="ms-3">
        <h5 class="card-title mb-1">Pending Table</h5>
        <p class="mb-0 text-muted">This month</p>
        <h4 class="mt-2">{{$pendingTable}}</h4>
      </div>
    </div>
</div>
</div>

  <div class="col-md-3 col-sm-6">
  <div class="card shadow-sm p-3 mb-3 w-100">
    <div class="d-flex flex-wrap align-items-center">
      <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle text-white" 
        style="width:80px; height:80px; font-size:32px; 
                background: linear-gradient(135deg, #f8981bff 0%, #e1bc39ff 100%);
                box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
      <i class="fas fa-utensils"></i>
      </div>

      <div class="ms-3 flex-grow-1">
        <h5 class="card-title mb-1">Best Selling</h5>
        <p class="mb-0 text-muted">This month</p>
        <h6 class="mt-2  text-truncate">Grilled Chicken</h6>
      </div>

    </div>
</div>
</div>

  </div>

  <div class="row g-3" >
  
  <div class="col-md-6 col-sm-12">
  <div class="card shadow-sm w-100">
    <div class="card-body">
      <h5 class="card-title">Monthly Sales</h5>
      <div style="height:325px;">
      <canvas id="monthlyChart"></canvas>
      </div>
    </div>
  </div>
  </div>

  <div class="col-md-6 col-sml-12">
  <div class="card shadow-sm w-100">
    <div class="card-body">
      <h5 class="card-title">Weekly Sales</h5>
      <div style="height:325px;">
      <canvas id="weeklyChart"></canvas>
      </div>
    </div>
  </div>
  </div>

  <div class="col-md-6 col-sm-12">
  <div class="card shadow-sm w-100">
    <div class="card-body">
      <h5 class="card-title">Daily Sales</h5>
      <div style="height:325px;">
      <canvas id="dailyChart"></canvas>
      </div>
    </div>
  </div>
  </div>

  <div class="col-md-6 col-sm-12 d-none">
  <div class="card shadow-sm w-100">
    <div class="card-body">
      <h5 class="card-title">Monthly Sales</h5>
      <div style="height:325px;">
      <canvas id="verticalBarChart"></canvas>
      </div>
    </div>
  </div>
  </div>

</div>


</x-layout>

<script>
  window.monthSales = @json($monthSales);
  window.dailySales = @json($dailySales);
  window.weekSales = @json($weekSales);
</script>
<script src="/js/chart.js"></script>