<x-layout>
  <x-slot name="header">
    Table Page
  </x-slot>

  <div class="container-fluid">
    <div class="row gx-3">

      <!-- Category Column -->
      <div class="col-12 col-md-4 col-lg-3 mt-1 order-md-2">
        <div class="card w-100 shadow rounded-3">
          <div class="card-body p-2" style="overflow-x: auto;"> 
            <div class="d-flex flex-row justify-content-between">
              <h5 class="card-title fw-semibold">Categories</h5>
              <span class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">+</span>
            </div>
            <div style="overflow-x: auto;">
              <table class="table table-hover mb-0" style="white-space: nowrap; min-width: 100%;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($cate as $cates)
                  <tr>
                    <td>{{ $cates->id }}</td>
                    <td>{{ $cates->name }}</td>
                    <td>
                      <button class="btn btn-primary categoryUpdate btn-sm">Update</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Product Column -->
      <div class="col-12 col-md-8 col-lg-9 mt-1 order-md-1">
        <div class="card w-100 shadow rounded-3">
          <div class="card-body p-2"> 
            <h5 class="card-title fw-semibold">Products</h5>
            <div style="overflow-x: auto;">
              <table class="table table-hover" id="table" style="white-space: nowrap; min-width: 100%;">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Product Picture</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Category</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($pro as $pros)
                  <tr>
                    <td>{{ $pros->id }}</td>
                    <td>
                      <img class="card-img-top" src="{{ $pros->pro_pic }}" style="width:5rem; height:5rem; object-fit: cover;" alt="Product Image" />
                    </td>
                    <td>{{ $pros->pro_name }}</td>
                    <td>{{ $pros->pro_price }}</td>
                    <td>{{ $pros->cate_id }}</td>
                    <td>
                      <button class="btn btn-primary btn-edit">Update</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            {{ $pro->links('pagination::bootstrap-5') }}
          </div>
        </div>
      </div>

    </div>
  </div>

</x-layout>

<!-- Product Modal -->
<x-modal id="updateProduct">
  <x-slot name="header">
    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Product's Details</h1>
  </x-slot>
  <div class="col-5 px-2 d-flex flex-column justify-content-between">
    <input type="hidden" id="update_id" />
    <label>Image</label>
    <img id="previewImage" src="#" alt="Image Preview" class="img-fluid mt-2 d-none" style="max-height: 200px;" />
    <input type="file" name="pic" id="imageInput" class="form-control"/>
  </div>

  <div class="col-7">
    <label>Name</label>
    <input type="text" class="form-control" id="update_name" name="name" />
    <label>Price</label>
    <input type="text" class="form-control" name="price" id="update_price" />
    <label>Category</label>
    <select class="form-control" name="category" id="update_cate">
      @foreach($cate as $cates)
      <option value="{{$cates->id}}">{{$cates->name}}</option>
      @endforeach
    </select>
  </div>

  <x-slot name="footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="btnUpdateProduct">Update</button>
    <button type="button" class="btn btn-danger" id="btnDeleteProduct">Delete</button>
  </x-slot>
</x-modal>

<!-- Category Create Modal -->
<x-modal id="categoryModal" method="post" action="/categoryCreate">
  <x-slot name="header">
    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Category</h1>
  </x-slot>
  <div class="mb-3 col-12">
    <label for="category" class="form-label">Category</label>
    <input type="text" class="form-control" id="category" name="category" />
    @error('category')
    <div class="text-danger">{{ $message }}</div>
    @enderror
  </div>

  <x-slot name="footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Create</button>
  </x-slot>
</x-modal>

<!-- Category Update Modal -->
<x-modal id="categoryModalUpdate">
  <x-slot name="header">
    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Category</h1>
  </x-slot>
  <div class="mb-3 col-12">
    <label for="category" class="form-label">Category</label>
    <input type="text" class="form-control" id="cateName" name="category" />
    <input type="hidden" id="cateId"/>
  </div>

  <x-slot name="footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="UpdateCategory">Update</button>
    <button type="button" class="btn btn-danger" id="DeleteCategory">Delete</button>
  </x-slot>
</x-modal>
