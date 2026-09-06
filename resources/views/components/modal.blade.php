
<!-- Modal -->
<div class="modal fade" id="{{$id ?? 'exampleModal'}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="{{ $class ?? 'modal-dialog modal-dialog-centered modal-lg' }}">
    <div class="modal-content">
      <div class="modal-header">
        {{ $header ?? '' }}
       
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="{{ $method ?? 'post' }}" action="{{ $action ?? '#' }}" id="{{ $formid ?? '' }}"  enctype="{{ $enctype ?? '' }}" class="d-flex">
        @csrf
        {{$slot}}
        
      </div>
      <div class="modal-footer">
        {{$footer ?? ''}}
      </div>
        </form>
    </div>
  </div>
</div>
<!-- end of Modal -->

@if ($errors->any() && session('modal') === $id)
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let myModal = new bootstrap.Modal(document.getElementById("{{ $id }}"));
        myModal.show();
    });
</script>
@endif