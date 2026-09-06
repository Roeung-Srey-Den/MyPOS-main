<div class="container">
<div class="menu-container mt-2 shadow rounded-2 p-2 w-100">
  <div class="overflow-auto">
    <div class="d-flex justify-content-center flex-nowrap gap-3" style="min-width: max-content;">
      <div class="item-hover active text-nowrap" data-filter="all">All</div>
      @foreach($cate as $cates)
        <div class="item-hover text-nowrap" data-filter="{{ $cates->id }}">{{ $cates->name }}</div>
      @endforeach
    </div>
  </div>
</div>



<div class="row justify-content-center gx-3" id="menu">
  @foreach($pro as $pros)
    <div class="col-6 col-sm-6 col-md-6 col-lg-3 d-flex mt-4 product-item" data-category="{{ $pros->cate_id ?? '' }}">
      <div class="card card-style w-100 h-100" onclick="addToCart('{{ $pros->id }}', '{{ $pros->pro_name }}', {{ $pros->pro_price }})">
        <img src="{{ $pros->pro_pic }}" class="card-img-top" alt="{{ $pros->pro_name }}" style="height:10rem; object-fit:cover" />
        <div class="card-body text-center">
          <h5 class="card-title">{{ $pros->pro_name }}</h5>
          <p class="card-text">{{ $pros->pro_price }}$</p>
        </div>
      </div>
    </div>
  @endforeach
</div>
</div>
