<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
  <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
    <ul class="kt-menu__nav ">
      @if (Sentinel::getUser()->hasAccess(['home.dashboard']))
      <li class="kt-menu__item " aria-haspopup="true">
        <a href="{{url('dashboard')}}" class="kt-menu__link ">
          <span class="kt-menu__link-icon">
            <i class="fa fa-layer-group"></i>
          </span>
          <span class="kt-menu__link-text">@lang('global.app_dashboard')</span>
        </a>
      </li>
      @endif
      @if(Sentinel::getUser()->hasAnyAccess(['unit.index','barang.index','sumber.index']))
      <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
          <span class="kt-menu__link-icon">
            <i class="fa fa-briefcase"></i>
          </span>
          <span class="kt-menu__link-text">@lang('menu.m_master')</span>
          <i class="kt-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="kt-menu__submenu ">
          <span class="kt-menu__arrow"></span>
          <ul class="kt-menu__subnav">
            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
              <span class="kt-menu__link">
                <span class="kt-menu__link-text">@lang('menu.m_master')</span>
              </span>
            </li>
            @if(Sentinel::getUser()->hasAnyAccess(['unit.index']))
              <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{route('unit.index')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i><span class="kt-menu__link-text">@lang('menu.u_satbar')</span>
                </a>
              </li>
            @endif
            @if(Sentinel::getUser()->hasAnyAccess(['brand.index']))
              <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{route('brand.index')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i><span class="kt-menu__link-text">Merek Barang</span>
                </a>
              </li>
            @endif
            @if(Sentinel::getUser()->hasAnyAccess(['type.index']))
              <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{route('type.index')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i><span class="kt-menu__link-text">Jenis Barang</span>
                </a>
              </li>
            @endif
            @if(Sentinel::getUser()->hasAnyAccess(['jenis.index']))
              <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{route('jenis.index')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i><span class="kt-menu__link-text">Jenis Barang</span>
                </a>
              </li>
            @endif
            @if(Sentinel::getUser()->hasAnyAccess(['supplier.index']))
              <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{route('supplier.index')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i><span class="kt-menu__link-text">Supplier Barang</span>
                </a>
              </li>
            @endif
          </ul>
        </div>
      </li>
      @endif

      @if(Sentinel::getUser()->hasAnyAccess(['markets.index']))
      <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
        <a href="{{route('markets.index')}}" class="kt-menu__link kt-menu__toggle">
          <span class="kt-menu__link-icon">
            <i class="fa fa-store"></i>
          </span>
          <span class="kt-menu__link-text">Market Place</span>
        </a>     
      </li>
      @endif
      @if(Sentinel::getUser()->hasAnyAccess(['orders.index']))
      <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
        <a href="{{route('orders.index')}}" class="kt-menu__link kt-menu__toggle">
          <span class="kt-menu__link-icon">
            <i class="fa fa-shopping-cart"></i>
          </span>
          <span class="kt-menu__link-text">Keranjang</span>
        </a>     
      </li>
      @endif

      @if(Sentinel::getUser()->hasAnyAccess(['transaksi.index']))
      <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
          <span class="kt-menu__link-icon">
            <i class="fas fa-boxes"></i>
          </span>
          <span class="kt-menu__link-text">Market</span>
          <i class="kt-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="kt-menu__submenu ">
          <span class="kt-menu__arrow"></span>
          <ul class="kt-menu__subnav">
            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
              <span class="kt-menu__link">
                <span class="kt-menu__link-text">@lang('menu.m_inventory')</span>
              </span>
            </li>
            @if(Sentinel::getUser()->hasAnyAccess(['transaksi.index']))
              <li class="kt-menu__item kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i>
                  <span class="kt-menu__link-text">Transaksi</span>
                  <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu ">
                  <span class="kt-menu__arrow"></span>
                  <ul class="kt-menu__subnav">
                    <li class="kt-menu__item " aria-haspopup="true">
                      <a href="{{route('transaksi.index')}}?status=proses" class="kt-menu__link ">
                        <i class="kt-menu__link-bullet kt-menu__link-bullet--line">
                          <span></span>
                        </i>
                        <span class="kt-menu__link-text">@lang('menu.n_proses')</span>
                      </a>
                    </li>
                    <li class="kt-menu__item " aria-haspopup="true">
                      <a href="{{route('transaksi.index')}}?status=terima" class="kt-menu__link ">
                        <i class="kt-menu__link-bullet kt-menu__link-bullet--line">
                          <span></span>
                        </i>
                        <span class="kt-menu__link-text">@lang('menu.n_diterima')</span>
                      </a>
                    </li>
                    <li class="kt-menu__item " aria-haspopup="true">
                      <a href="{{route('transaksi.index')}}?status=tolak" class="kt-menu__link ">
                        <i class="kt-menu__link-bullet kt-menu__link-bullet--line">
                          <span></span>
                        </i>
                        <span class="kt-menu__link-text">Dibatalkan</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            @endif
            @if(Sentinel::getUser()->hasAnyAccess(['item.index']))
              <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{route('item.index')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i>
                  <span class="kt-menu__link-text">List Barang</span>
                </a>
              </li>
            @endif
          </ul>
        </div>
      </li>
      @endif
      @if(Sentinel::getUser()->hasAnyAccess(['regist.create']))
      <li class="kt-menu__item " aria-haspopup="true">
        <a href="{{route('regist.create')}}" class="kt-menu__link ">
          <span class="kt-menu__link-icon">
            <i class="fas fa-boxes"></i>
          </span>
          <span class="kt-menu__link-text">Regist</span>
        </a>
      </li>
      @endif
      @if(Sentinel::getUser()->hasAnyAccess(['roles.index','users.index','log-viewer::logs.dashboard','log-viewer::logs.list']))
      <li class="kt-menu__section ">
        <h4 class="kt-menu__section-text">@lang('global.app_system')</h4>
        <i class="kt-menu__section-icon flaticon-more-v2"></i>
      </li>
      @endif
      @if(Sentinel::getUser()->hasAnyAccess(['roles.index','users.index','satker.index']))
      <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
          <span class="kt-menu__link-icon">
            <i class="fa fa-user-alt"></i>
          </span>
          <span class="kt-menu__link-text">@lang('menu.m_user')</span>
          <i class="kt-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="kt-menu__submenu ">
          <span class="kt-menu__arrow"></span>
          <ul class="kt-menu__subnav">
            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
              <span class="kt-menu__link">
                <span class="kt-menu__link-text">@lang('menu.m_user')</span>
              </span>
            </li>
            @if(Sentinel::getUser()->hasAnyAccess(['roles.index']))
              <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{route('roles.index')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i><span class="kt-menu__link-text">@lang('menu.u_role')</span>
                </a>
              </li>
            @endif
            @if(Sentinel::getUser()->hasAnyAccess(['users.index']))
              <li class="kt-menu__item " aria-haspopup="true">
                <a href="{{route('users.index')}}" class="kt-menu__link ">
                  <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                  </i>
                  <span class="kt-menu__link-text">@lang('menu.m_user')</span>
                </a>
              </li>
            @endif
          </ul>
        </div>
      </li>
      @endif

      

    </ul>
  </div>
</div>
<!-- end:: Aside Menu -->
