<x-layout>
  <x-slot name="header">
    Cashier Page
  </x-slot>

  <div class="container pt-2">
    <div class="row g-3"> 

      <!-- First Cashier Column -->
      <div class="col-12 col-md-6"> 
        <div class="card w-100 shadow rounded-3">
          <div class="card-body p-2">
            <div class="d-flex justify-content-between align-items-center w-100">
              <h5 class="card-title fw-semibold mx-auto">Account</h5>
              <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#cashierModalCreate">
                + Add an account
              </button>
            </div>

            <div style="overflow-x: auto;">
              <table class="table table-hover" style="white-space: nowrap; min-width: 100%;">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Account's Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($cashier as $cashiers)
                  <tr>
                    <td>{{ $cashiers->id }}</td>
                    <td>{{ $cashiers->name }}</td>
                    <td>{{ $cashiers->email }}</td>
                    <td>{{ $cashiers->role }}</td>
                    <td>
                      <button class="btn btn-primary cashierUpdate">Update</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Second Cashier Column -->
      <div class="col-12 col-md-6"> 
        <div class="card w-100 shadow rounded-3">
          <div class="card-body p-2">
            <div class="d-flex justify-content-between align-items-center w-100">
              <h5 class="card-title fw-semibold mx-auto">Account</h5>
              <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#cashierModalCreate">
                + Add an account
              </button>
            </div>

            <div style="overflow-x: auto;">
              <table class="table table-hover" style="white-space: nowrap; min-width: 100%;">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Account's Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($admin as $admins)
                  <tr>
                    <td>{{ $admins->id }}</td>
                    <td>{{ $admins->name }}</td>
                    <td>{{ $admins->email }}</td>
                    <td>{{ $admins->role }}</td>
                    <td>
                      <button class="btn btn-primary cashierUpdate">Update</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</x-layout>

<x-modal id="cashierModalCreate" class="modal-dialog modal-dialog-centered" method="post" action="/cashierCreate">
  <x-slot name="header">
    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Account</h1>
  </x-slot>
  <div class="d-flex flex-column col-auto w-100">
  <label>Account's Name</label>
  <input type="text" class="form-control" name="name" />
  @error('name')
  <div class="text-danger">{{ $message }}</div>
  @enderror
  <label>Email</label>
  <input type="email" class="form-control" name="email" />
   @error('email')
  <div class="text-danger">{{ $message }}</div>
  @enderror
  <label>Password</label>
  <input type="text" class="form-control" name="password" />
   @error('password')
  <div class="text-danger">{{ $message }}</div>
  @enderror
  <label>Role</label>
  <select name="role" class="form-control">
    <option value="Admin">Admin</option>
    <option value="Cashier">Cashier</option>
  </select>
  </div>
  <x-slot name="footer">
    <button type="button" class="btn btn-secondary">Close</button>
    <button type="submit" class="btn btn-primary">Create</button>
  </x-slot>
</x-modal>

<!-- Update Modal -->
 <x-modal class="modal-dialog modal-dialog-centered" id="cashierModalUpdate">
  <x-slot name="header">
    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Account's Detail</h1>
  </x-slot>

  <div class="d-flex flex-column col-auto w-100">
    <input type="hidden" id="id"/>
  <label>Account's Name</label>
  <input type="text" class="form-control" id="name" />
  <label>Email</label>
  <input type="text" class="form-control" id="email" />
  <label>Password</label>
  <input type="text" class="form-control" id="password" />
  <label>Role</label>
  <select id="role" class="form-control">
    <option value="Admin">Admin</option>
    <option value="Cashier">Cashier</option>
  </select>
  </div>
  <x-slot name="footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="cashierUpdate">Update</button>
    <button type="button" class="btn btn-danger" id="cashierDelete">Delete</button>
  </x-slot>
</x-modal>