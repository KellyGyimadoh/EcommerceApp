<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
            <x-sidebar.sidemenu href="/dashboard" :collapsed="false" item='Dashboard' icon='fas fa-tachometer-alt'/>

                    @can('viewAny', 'App\\Models\User')
                        <x-sidebar.sideheader header='Product/Category' />
                        <x-sidebar.sidemenu href="#" :collapsed="true" target='collapseLayouts' item='Manage Category'
                            icon='fas fa-columns'>
                            <x-sidebar.subitem id="collapseLayouts">
                                <x-sidebar.sidebarlink href="/categories" class="nav-link">View
                                    Categories</x-sidebar.sidebarlink>
                                <x-sidebar.sidebarlink href="/categories-add" class="nav-link">Add new
                                    category</x-sidebar.sidebarlink>
                            </x-sidebar.subitem>
                        </x-sidebar.sidemenu>
                        <x-sidebar.sidemenu href="#" :collapsed="true" target='collapseProducts' item='Manage Product'
                            icon='fas fa-columns'>
                            <x-sidebar.subitem id="collapseProducts">
                                <x-sidebar.sidebarlink href="/products" class="nav-link">View
                                    Products</x-sidebar.sidebarlink>
                                <x-sidebar.sidebarlink href="/products-add" class="nav-link">Add new
                                    Product</x-sidebar.sidebarlink>
                            </x-sidebar.subitem>
                        </x-sidebar.sidemenu>
                    @endcan
                <x-sidebar.sideheader header='View Catalog/Buy Items' />
                <x-sidebar.sidemenu href="#" :collapsed="true" target='collapseCatalog' item='View Catalog'
                    icon='fas fa-columns'>
                    <x-sidebar.subitem id="collapseCatalog">
                        <x-sidebar.sidebarlink href="/add-carts" class="nav-link">Buy Items</x-sidebar.sidebarlink>
                        @if (session('cartid'))
                            <x-sidebar.sidebarlink href="/cartitems/{{ session('cartid') }}" class="nav-link">View My
                                Cart</x-sidebar.sidebarlink>
                        @endif

                    </x-sidebar.subitem>
                </x-sidebar.sidemenu>
                <x-sidebar.sideheader header='Orders' />
                <x-sidebar.sidemenu href="#" :collapsed="true" target='collapseOrders' item='Manage Orders'
                    icon='fas fa-columns'>
                    <x-sidebar.subitem id="collapseOrders">

                        <x-sidebar.sidebarlink href="/orders" class="nav-link">View My Orders</x-sidebar.sidebarlink>

                    </x-sidebar.subitem>
                </x-sidebar.sidemenu>





            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ Auth::user()->account_type }}
        </div>
    </nav>
</div>
