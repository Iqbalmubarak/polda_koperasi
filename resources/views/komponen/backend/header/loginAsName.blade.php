<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
  <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
    <span class="kt-menu__link-text">{{Sentinel::getUser()->roles()->first()->name}} @if(Sentinel::getUser()->roles()->first()->id==3) {{Sentinel::getUser()->satker->name}} @endif </span>
    <i class="kt-menu__ver-arrow la la-angle-right"></i>
  </a>
</li>
