document.addEventListener("DOMContentLoaded", function () {
  // ----------------- Order Type Toggle -----------------
  const orderSelect = document.getElementById("order");
  const addBtn = document.getElementById("add");
  const phoneInput = document.getElementById("phone");

  if(orderSelect) {
    orderSelect.addEventListener("change", function () {
      if (orderSelect.value === "delivery") {
        addBtn?.removeAttribute("disabled");
        phoneInput?.removeAttribute("disabled");
      } else {
        addBtn?.setAttribute("disabled", "disabled");
        phoneInput?.setAttribute("disabled", "disabled");
      }
    });
  }

  // ----------------- Category Filtering -----------------
  document.querySelectorAll('.item-hover').forEach(btn => {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.item-hover').forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      const filter = this.getAttribute('data-filter');
      document.querySelectorAll('.product-item').forEach(item => {
        const category = item.getAttribute('data-category');
        if (filter === 'all' || category === filter) {
          item.style.setProperty('display', '', 'important');
        } else {
          item.style.setProperty('display', 'none', 'important');
        }
      });
    });
  });

  // ----------------- Search Filtering -----------------
  const searchInput = document.getElementById('search');
  function filterItems(containerId, itemSelector, filterText) {
    const container = document.getElementById(containerId);
    if (!container) return;
    container.querySelectorAll(itemSelector).forEach(item => {
      const text = item.textContent.toLowerCase();
      item.style.setProperty('display', text.includes(filterText) ? '' : 'none', 'important');
    });
  }
  if(searchInput){
    searchInput.addEventListener('input', function () {
      const filter = this.value.toLowerCase();
      filterItems('table', 'tbody tr', filter);
      filterItems('menu', '.product-item', filter);
    });
  }

  // ----------------- Show/Hide Menu Form -----------------
  window.showneworder = function(orderId) {
    const formDiv = document.getElementById('menu-form-container-' + orderId);
    formDiv?.classList.toggle('d-none');
  }

  // ----------------- Add / Remove Menu Items -----------------
  document.addEventListener('click', function(e){
    // Add new menu item
    if(e.target.matches('.add-item')){
      const menuGroup = e.target.closest('.modal-content')?.querySelector('.menu-group');
      if(!menuGroup) return;

      const firstItem = menuGroup.querySelector('.menu-item');
      const newItem = firstItem.cloneNode(true);

      newItem.querySelectorAll('input, select').forEach(input => {
        if(input.name.includes('quantity')) input.value = 1;
        else if(input.name.includes('price')) input.value = 0;
        else if(input.tagName.toLowerCase() === 'select') input.selectedIndex = 0;
      });

      // Update price for the new item
      const selectElem = newItem.querySelector('select[name="product_id[]"]');
      if(selectElem){
        const price = selectElem.selectedOptions[0]?.dataset.price || 0;
        newItem.querySelector('input[name="price[]"]').value = price;
      }

      menuGroup.appendChild(newItem);
    }

    // Remove menu item
    if(e.target.classList.contains('remove-item')){
      const menuGroup = e.target.closest('.menu-group');
      const items = menuGroup.querySelectorAll('.menu-item');
      if(items.length > 1) e.target.closest('.menu-item').remove();
      else alert('At least one menu item is required.');
    }
  });

  // ----------------- Update price on select change -----------------
  document.addEventListener('change', function(e){
    if(e.target.matches('select[name="product_id[]"]')){
      const selectedOption = e.target.options[e.target.selectedIndex];
      const price = selectedOption?.dataset?.price || 0;
      const priceInput = e.target.closest('.menu-item').querySelector('input[name="price[]"]');
      if(priceInput) priceInput.value = price;
    }
  });

  // ----------------- Mark Paid & Print Receipt -----------------
  window.markPaidAndPrint = function(orderId, receiptId){
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if(!token) return;

    const numericId = parseInt(orderId.toString().replace(/^(delivery-|takeaway-)/, '')) || orderId;

    fetch('/orders/' + numericId + '/paid', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
      },
    })
    .then(res => res.json())
    .then(data => {
      if(data.success){
        const printContents = document.getElementById(receiptId)?.innerHTML;
        if(printContents){
          const originalContents = document.body.innerHTML;
          document.body.innerHTML = printContents;
          window.print();
           location.reload();
          document.body.innerHTML = originalContents;

 
          const statusEl = document.querySelector(`[data-order-id='${orderId}']`);
          if(statusEl) statusEl.textContent = 'paid';
        }
      }
    })
    .catch(err => console.error(err));
  }

  // ----------------- Toggle Select / Delivery -----------------
  function toggleSelect() {
    const isChecked = document.getElementById('checkDelivery')?.checked;
    document.getElementById('tableBox')?.style.setProperty('display', isChecked ? 'none' : 'block');
    document.getElementById('customerBox')?.style.setProperty('display', isChecked ? 'block' : 'none');
  }
  toggleSelect(); 
  document.getElementById('checkDelivery')?.addEventListener('change', toggleSelect);
});
