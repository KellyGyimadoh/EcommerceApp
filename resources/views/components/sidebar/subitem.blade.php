@props(['id'=>''])


<div {{$attributes->merge(['id'=>$id])}} class="collapse subitem"  aria-labelledby="headingOne"
    data-bs-parent="#sidenavAccordion">
    <nav class="sb-sidenav-menu-nested nav">
       {{$slot}}

    </nav>
</div>

