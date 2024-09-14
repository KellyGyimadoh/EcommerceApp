<x-layout pagetitle="Activity" pageurl="/activity">

    <div class="row mx-3 auto">

        <div class="col-md-4 mb-4">
            <div class="card border-primary ">
                <div class="card-body">
                    <h5 class="card-title">Total Products Available | <span class="fs-6 text-sm">All products</span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-basket-fill"></i>
                        </div>
                        <div class="ps-3">
                            <h4 class="text-info">{{ $productsTotal }}</h4>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-info">
                <div class="card-body">
                    <h5 class="card-title">Total Categories Available | <span class="fs-6 text-sm">All Categories</span>
                    </h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-list-stars"></i>
                        </div>
                        <div class="ps-3">
                            <h4  class="text-info">{{ $categoriesTotal }}</h4>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-secondary">
            <div class="card-body">
                <h5 class="card-title">Total Orders Available|<span class="fs-6 text-sm">All orders</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-card-checklist "></i>
                    </div>
                    <div class="ps-3">
                        <h4  class="text-info">{{$ordersAll}}</h4>

                    </div>
                </div>
            </div>
            </div>

        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-danger">
            <div class="card-body">
                <h5 class="card-title">Total Orders Pending|<span class="fs-6 text-sm">pending</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div class="ps-3">
                        <h4  class="text-info">{{$ordersPending}}</h4>

                    </div>
                </div>
            </div>
            </div>

        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-warning">
            <div class="card-body">
                <h5 class="card-title">Total Orders Processing|<span class="fs-6 text-sm">processing</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-gear"></i>
                    </div>
                    <div class="ps-3">
                        <h4  class="text-info">{{$ordersProcessing}}</h4>

                    </div>
                </div>
            </div>
            </div>


        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-success">
            <div class="card-body">
                <h5 class="card-title">Total Orders Completed|<span class="fs-6 text-sm">completed</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-gear"></i>
                    </div>
                    <div class="ps-3">
                        <h4  class="text-info">{{$ordersCompleted}}</h4>

                    </div>
                </div>
            </div>
            </div>

        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-success">
            <div class="card-body">
                <h5 class="card-title">Total Sales|<span class="fs-6 text-sm">All sales</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-gear"></i>
                    </div>
                    <div class="ps-3">
                        <h4  class="text-info">GH&#8373;{{number_format($totalSalesAll,2)}}</h4>

                    </div>
                </div>
            </div>
            </div>

        </div>

    </div>

</x-layout>
