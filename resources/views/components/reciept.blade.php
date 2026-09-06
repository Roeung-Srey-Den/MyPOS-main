<div id="{{ $attributes->get('id') }}" class="container my-4 d-flex justify-content-center d-none" style="font-family: monospace;">
  <div id="receipt" class="border p-3 w-100" style="max-width: 800px;">
    <h5 class="text-center fw-bold mb-1">POS Restaurant</h5>
    <p class="text-center mb-1">Street 123, Phnom Penh</p>
    <p class="text-center mb-1">Tel: 000 000 000</p>
    <p class="text-center mb-3">Date: {{ now()->format('Y-m-d H:i') }}</p>

    <hr class="my-2">

    <div>
      {{ $slot }}
    </div>

    <hr class="my-2">

    <p class="text-center small mb-0">Thank you! Come again. 🙏</p>
  </div>
</div>
