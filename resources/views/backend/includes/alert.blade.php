@if(session('flashData'))
<div class="alert
    @if(session('flashData')['status']==1)
alert-success 
    @else
alert-danger
    @endif
    alert-dismissible fade show" role="alert">
    {{session('flashData')['message']}}
    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
@endif
