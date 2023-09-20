<div id="kt_app_sidebar" class="app-sidebar  flex-column " data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <div class="app-sidebar-logo h-100px px-6" id="kt_app_sidebar_logo">
        <a href="{{ route('home') }}">
            <img alt="Logo" src="{{ asset('assets/media/logos/tbu.png') }}" style="width: 90%;"
                class=" app-sidebar-logo-default bg-white px-4 py-2 rounded" />
        </a>

        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-sm h-30px w-30px rotate active"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">

            <i class="ki-duotone ki-double-left fs-2 rotate-180"><span class="path1"></span><span
                    class="path2"></span></i>
        </div>
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">
            <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-category fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>
                @permission('category_read|cluster_read|sub_cluster_read|sub_cluster_item_read|catalog_read|dealer_read|leasing_read|unit_read|uom_read|lifetime_read')
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-dropbox fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                    <i class="path4"></i>
                                    <i class="path5"></i>
                                </i>
                            </span>
                            <span class="menu-title">Master</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div
                            class="menu-sub menu-sub-accordion {{ request()->routeIs('masters.categories.index', 'masters.clusters.index', 'masters.sub-clusters.index', 'masters.sub-cluster-items.index', 'masters.catalogs.index', 'masters.dealers.index', 'masters.leasings.index', 'masters.units.index', 'masters.uoms.index') ? 'hover show' : '' }}">
                            @permission('category_read')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('masters.categories.index') ? 'active' : '' }}"
                                        href="{{ route('masters.categories.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Category</span>
                                    </a>
                                </div>
                            @endpermission
                            @permission('cluster_read')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('masters.clusters.index') ? 'active' : '' }}"
                                        href="{{ route('masters.clusters.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Cluster</span>
                                    </a>
                                </div>
                            @endpermission
                            @permission('sub_cluster_read')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('masters.sub-clusters.index') ? 'active' : '' }}"
                                        href="{{ route('masters.sub-clusters.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Sub Cluster</span>
                                    </a>
                                </div>
                            @endpermission
                            @permission('sub_cluster_item_read')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('masters.sub-cluster-items.index') ? 'active' : '' }}"
                                        href="{{ route('masters.sub-cluster-items.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Sub Cluster Item</span>
                                    </a>
                                </div>
                            @endpermission
                            @permission('catalog_read')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('masters.catalogs.index') ? 'active' : '' }}"
                                        href="{{ route('masters.catalogs.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Catalog</span>
                                    </a>
                                </div>
                            @endpermission
                            @permission('dealer_read')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('masters.dealers.index') ? 'active' : '' }}"
                                        href="{{ route('masters.dealers.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Dealer</span>
                                    </a>
                                </div>
                            @endpermission
                            @permission('leasing_read')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('masters.leasings.index') ? 'active' : '' }}"
                                        href="{{ route('masters.leasings.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Leasing</span>
                                    </a>
                                </div>
                            @endpermission
                            @permission('unit_read')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('masters.units.index') ? 'active' : '' }}"
                                        href="{{ route('masters.units.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Unit</span>
                                    </a>
                                </div>
                            @endpermission
                            @permission('uom_read')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('masters.uoms.index') ? 'active' : '' }}"
                                        href="{{ route('masters.uoms.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Uom</span>
                                    </a>
                                </div>
                            @endpermission
                            @permission('lifetime_read')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('masters.lifetimes.index') ? 'active' : '' }}"
                                        href="{{ route('masters.lifetimes.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Lifetime</span>
                                    </a>
                                </div>
                            @endpermission
                        </div>
                    </div>
                @endpermission
                @permission('asset_master_read')
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('asset-masters.index', 'asset-masters.show') ? 'active' : '' }}"
                            href="{{ route('asset-masters.index') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-lots-shopping fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                    <i class="path4"></i>
                                    <i class="path5"></i>
                                    <i class="path6"></i>
                                    <i class="path7"></i>
                                    <i class="path8"></i>
                                </i>
                            </span>
                            <span class="menu-title">Asset Master</span>
                        </a>
                    </div>
                @endpermission
                @permission('asset_register_read')
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('asset-registers.index', 'asset-registers.create') ? 'active' : '' }}"
                            href="{{ route('asset-registers.index') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-dropbox fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                    <i class="path4"></i>
                                    <i class="path5"></i>
                                </i>
                            </span>
                            <span class="menu-title">Asset Register</span>
                        </a>
                    </div>
                @endpermission
                @permission('asset_request_read')
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('asset-requests.index', 'asset-requests.create', 'asset-requests.show', 'asset-requests.edit') ? 'active' : '' }}"
                            href="{{ route('asset-requests.index') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-call fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                    <i class="path4"></i>
                                    <i class="path5"></i>
                                    <i class="path6"></i>
                                    <i class="path7"></i>
                                    <i class="path8"></i>
                                </i>
                            </span>
                            <span class="menu-title">Asset Request</span>
                        </a>
                    </div>
                @endpermission
                @permission('asset_transfer_read')
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('asset-transfers.index', 'asset-transfers.create', 'asset-transfers.show', 'asset-transfers.edit') ? 'active' : '' }}"
                            href="{{ route('asset-transfers.index') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-share fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                    <i class="path4"></i>
                                    <i class="path5"></i>
                                    <i class="path6"></i>
                                </i>
                            </span>
                            <span class="menu-title">Asset Transfer</span>
                        </a>
                    </div>
                @endpermission
                @permission('asset_dispose_read')
                    <div class="menu-item">
                        <a class="menu-link {{ request()->routeIs('asset-disposes.index', 'asset-disposes.create', 'asset-disposes.show', 'asset-disposes.edit') ? 'active' : '' }}"
                            href="{{ route('asset-disposes.index') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-disconnect fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                    <i class="path4"></i>
                                    <i class="path5"></i>
                                </i>
                            </span>
                            <span class="menu-title">Asset Dispose</span>
                        </a>
                    </div>
                @endpermission
                @permission('asset_request_approv|asset_request_reject|asset_transfer_approv|asset_transfer_reject|asset_dispose_approv|asset_dispose_reject')
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-check fs-2"></i>
                            </span>
                            <span class="menu-title">Approval</span>
                            <span class="menu-badge">
                                <span class="badge badge-success" id="grand-total">0</span>
                            </span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div
                            class="menu-sub menu-sub-accordion {{ request()->routeIs('approvals.cers.index', 'approvals.cers.show', 'approvals.transfers.index', 'approvals.transfers.show', 'approvals.disposes.index', 'approvals.disposes.show') ? 'hover show' : '' }}">
                            @permission('asset_request_approv|asset_request_reject')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('approvals.cers.index', 'approvals.cers.show') ? 'active' : '' }}"
                                        href="{{ route('approvals.cers.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Asset Request</span>
                                        <span class="menu-badge">
                                            <span class="badge badge-success" id="asset-request">0</span>
                                        </span>
                                    </a>
                                </div>
                            @endpermission
                            @permission('asset_transfer_approv|asset_transfer_reject')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('approvals.transfers.index', 'approvals.transfers.show') ? 'active' : '' }}"
                                        href="{{ route('approvals.transfers.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Asset Transfer</span>
                                        <span class="menu-badge">
                                            <span class="badge badge-success" id="asset-transfer">0</span>
                                        </span>
                                    </a>
                                </div>
                            @endpermission
                            @permission('asset_dispose_approv|asset_dispose_reject')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('approvals.disposes.index', 'approvals.disposes.show') ? 'active' : '' }}"
                                        href="{{ route('approvals.disposes.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Asset Dispose</span>
                                        <span class="menu-badge">
                                            <span class="badge badge-success" id="asset-dispose">0</span>
                                        </span>
                                    </a>
                                </div>
                            @endpermission
                        </div>
                    </div>
                @endpermission
                @permission('asset_request_report|asset_transfer_report|asset_dispose_report')
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-notepad-bookmark fs-2">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                    <i class="path4"></i>
                                    <i class="path5"></i>
                                    <i class="path6"></i>
                                </i>
                            </span>
                            <span class="menu-title">Report</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            @permission('asset_request_report')
                                <div class="menu-item">
                                    <a class="menu-link" href="">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Asset Request</span>
                                    </a>
                                </div>
                            @endpermission
                            @permission('asset_transfer_report')
                                <div class="menu-item">
                                    <a class="menu-link" href="">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Asset Transfer</span>
                                    </a>
                                </div>
                            @endpermission
                            @permission('asset_dispose_report')
                                <div class="menu-item">
                                    <a class="menu-link" href="">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Asset Dispose</span>
                                    </a>
                                </div>
                            @endpermission
                        </div>
                    </div>
                @endpermission
                {{-- @permission('approval_read|access_permission_read') --}}
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-setting fs-2">
                                <i class="path1"></i>
                                <i class="path2"></i>
                            </i>
                        </span>
                        <span class="menu-title">Setting</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div
                        class="menu-sub menu-sub-accordion {{ request()->routeIs('settings.approval.index', 'settings.access-permission.index') ? 'hover show' : '' }}">
                        @permission('approval_read')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('settings.approval.index') ? 'active' : '' }}"
                                    href="{{ route('settings.approval.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Approval</span>
                                </a>
                            </div>
                        @endpermission
                        {{-- @permission('access_permission_read') --}}
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('settings.access-permission.index') ? 'active' : '' }}"
                                href="{{ route('settings.access-permission.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Access Permission</span>
                            </a>
                        </div>
                        {{-- @endpermission --}}
                    </div>
                </div>
                {{-- @endpermission --}}
            </div>
        </div>
    </div>
</div>
