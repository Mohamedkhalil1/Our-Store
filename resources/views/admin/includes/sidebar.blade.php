<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
  <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

        
          <li class="nav-item open"><a href=""><i class="la la-home"></i>
              <span class="menu-title" data-i18n="nav.dash.main">لغات الموقع </span>
              <span
              class="badge badge badge-info badge-pill float-right mr-2"></span>
          </a>
              <ul class="menu-content">
                  <li class="active"><a class="menu-item" href=""
                                        data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                  </li>
                  <li><a class="menu-item" href="" data-i18n="nav.dash.crypto">أضافة
                      لغه جديد </a>
                  </li>
              </ul>
          </li>


          <li class="nav-item"><a href=""><i class="la la-group"></i>
              <span class="menu-title" data-i18n="nav.dash.main">الاقسام الرئيسية </span>
              <span
                  class="badge badge badge-danger badge-pill float-right mr-2">{{App\Models\Category::parent()->count()}}</span>
          </a>
              <ul class="menu-content">
                  <li class="active"><a class="menu-item" href="{{route('admin.maincategories',App\Http\Enumerations\CategoryType::category)}}"
                                        data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                  </li>
                  <li><a class="menu-item" href="{{route('admin.maincategories.create',App\Http\Enumerations\CategoryType::category)}}" data-i18n="nav.dash.crypto">أضافة
                      قسم جديد </a>
                  </li>
              </ul>
          </li>

          <li class="nav-item"><a href=""><i class="la la-male"></i>
              <span class="menu-title" data-i18n="nav.dash.main">الاقسام الفرعيه</span>
              <span
                  class="badge badge badge-danger badge-pill float-right mr-2">{{App\Models\Category::child()->count()}}</span>
          </a>
              <ul class="menu-content">
                  <li class="active"><a class="menu-item" href="{{route('admin.maincategories',App\Http\Enumerations\CategoryType::subCategory)}}"
                                        data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                  </li>
                  <li><a class="menu-item" href="{{route('admin.maincategories.create',App\Http\Enumerations\CategoryType::subCategory)}}" data-i18n="nav.dash.crypto">أضافة
                      قسم فرعي  </a>
                  </li>
              </ul>
          </li>


          <li class="nav-item"><a href=""><i class="la la-male"></i>
              <span class="menu-title" data-i18n="nav.dash.main">الماركات</span>
              <span
                  class="badge badge badge-warning  badge-pill float-right mr-2">{{App\Models\Brand::all()->count()}}</span>
          </a>
              <ul class="menu-content">
                     <li class="active"><a class="menu-item" href="{{route('admin.brands')}}"
                                        data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                  </li>
                  <li><a class="menu-item" href="{{route('admin.brands.create')}}" data-i18n="nav.dash.crypto">أضافة
                      ماركه جديده </a>
                  </li>
              </ul>
          </li>

          <li class="nav-item"><a href=""><i class="la la-male"></i>
              <span class="menu-title" data-i18n="nav.dash.main">التاجات</span>
              <span
                  class="badge badge badge-warning  badge-pill float-right mr-2">{{App\Models\Tag::all()->count()}}</span>
          </a>
              <ul class="menu-content">
                     <li class="active"><a class="menu-item" href="{{route('admin.tags')}}"
                                        data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                  </li>
                  <li><a class="menu-item" href="{{route('admin.tags.create')}}" data-i18n="nav.dash.crypto">أضافة
                      تاج جديده </a>
                  </li>
              </ul>
          </li>

          <li class="nav-item"><a href=""><i class="la la-tags"></i>
              <span class="menu-title" data-i18n="nav.dash.main">المنتجات</span>
              <span
                  class="badge badge badge-warning  badge-pill float-right mr-2">{{App\Models\Product::all()->count()}}</span>
          </a>
              <ul class="menu-content">
                     <li class="active"><a class="menu-item" href="{{route('admin.products')}}"
                                        data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                  </li>
                  <li><a class="menu-item" href="{{route('admin.products.general.create')}}" data-i18n="nav.dash.crypto">أضافة
                      منتج جديد </a>
                  </li>
              </ul>
          </li>


          <li class="nav-item">
              <a href=""><i class="la la-male"></i>
                  <span class="menu-title" data-i18n="nav.dash.main">تذاكر المراسلات   </span>
                  <span
                      class="badge badge badge-danger  badge-pill float-right mr-2">0</span>
              </a>
              <ul class="menu-content">
                  <li class="active"><a class="menu-item" href=""
                                        data-i18n="nav.dash.ecommerce"> تذاكر الطلاب </a>
                  </li>
              </ul>
          </li>


          <li class=" nav-item"><a href="#"><i class="la la-television"></i><span class="menu-title"
                                                                                  data-i18n="nav.templates.main">{{trans('admin/side.settings')}}</span></a>
              <ul class="menu-content">
                  <li><a class="menu-item" href="#" data-i18n="nav.templates.vert.main">{{__('admin/side.methods')}}</a>
                      <ul class="menu-content">
                          <li><a class="menu-item" href="../vertical-menu-template"
                                 data-i18n="nav.templates.vert.classic_menu"></a>
                          </li>
                          <li><a class="menu-item" href="{{route('edit.shipping.methods','free')}}">{{__('admin/side.free')}}</a>
                          </li>
                          <li><a class="menu-item" href="{{route('edit.shipping.methods','inner')}}"
                                 data-i18n="nav.templates.vert.compact_menu"> {{__('admin/side.inner')}}</a>
                          </li>
                          <li><a class="menu-item" href="{{route('edit.shipping.methods','outer')}}"
                                 data-i18n="nav.templates.vert.content_menu"> {{__('admin/side.outer')}}</a>
                          </li>
                      </ul>
                  </li>
              </ul>
          </li>
      </ul>
  </div>
</div>
