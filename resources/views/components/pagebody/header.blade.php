@props(['pagetitle'=>'','pageurl'=>''])
<div class="container-fluid px-4">

    <h3 class="mt-1">{{$pagetitle}}</h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"><a href="{{$pageurl}}" style="text-decoration: none">{{$pagetitle}}</a></li>
    </ol>


</div>
