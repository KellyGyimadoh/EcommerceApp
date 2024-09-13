@props(['method'=>'GET','action'=>''])

<form method="{{$method}}" action="{{$action}}" {{$attributes}}>
    @csrf
    @if (strtoupper($method)!=="GET")
        @method($method)
    @endif
   {{$slot}}
</form>
