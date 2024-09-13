@props(['target'=>'','action'=>'','modaltitle'=>'','formtarget'=>''])
<div class="modal fade" tabindex="-1" aria-hidden="true" id="{{$target}}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{$modaltitle}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>{{$slot}}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button id="submit-form" form="{{$formtarget}}" class="btn btn-primary">{{$action}}</button>
        </div>
      </div>
    </div>
  </div>
