  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
          <img src="" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          {{-- <span class="brand-text font-weight-light">Website</span> --}}
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{ asset('images/admin_images/admin_photos/' . Auth::guard('admin')->user()->image) }}"
                      class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">{{ ucwords(Auth::guard('admin')->user()->name) }}</a>
              </div>
          </div>
          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  @if (Session::get('page') == 'dashboard')
                      <?php $active = 'active'; ?>
                  @else
                      <?php $active = ''; ?>
                  @endif
                  <li class="nav-item">
                      <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $active }}">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>

                  <!-- Setting -->
                  @if (Session::get('page') == 'settings' || Session::get('page') == 'update-admin-details')
                      <?php $active = 'active'; ?>
                  @else
                      <?php $active = ''; ?>
                  @endif
                  <li class="nav-item has-treeview menu-open">
                      <a href="#" class="nav-link {{ $active }}">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Setting
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          @if (Session::get('page') == 'settings')
                              <?php $active = 'active'; ?>
                          @else
                              <?php $active = ''; ?>
                          @endif
                          <li class="nav-item">
                              <a href="{{ route('admin.settings') }}" class="nav-link {{ $active }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Update Admin Password</p>
                              </a>
                          </li>
                          @if (Session::get('page') == 'update-admin-details')
                              <?php $active = 'active'; ?>
                          @else
                              <?php $active = ''; ?>
                          @endif
                          <li class="nav-item">
                              <a href="{{ route('admin.update.admin.details') }}"
                                  class="nav-link {{ $active }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Update Admin Details</p>
                              </a>
                          </li>

                            @if (Session::get('page') == 'update_other_setting')
                                <?php $active = 'active'; ?>
                            @else
                                <?php $active = ''; ?>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('admin.update.other.settings') }}"
                                    class="nav-link {{ $active }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Update Other Setting</p>
                                </a>
                            </li>

                            @if (Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == 'admin' )

                                @if (Session::get('page') == 'admins_subadmins')
                                    <?php $active = 'active'; ?>
                                @else
                                    <?php $active = ''; ?>
                                @endif
                                <li class="nav-item">
                                    <a href="{{ route('admin.admins.subadmins') }}" class="nav-link {{ $active }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Admins/Subadmins</p>
                                    </a>
                                </li>
                            @endif


                      </ul>
                  </li>

                  <!-- Categories -->

                  @if (Session::get('page') == 'sections' || Session::get('page') == 'brands' || Session::get('page') == 'categories'|| Session::get('page') == 'products')
                      <?php $active = 'active'; ?>
                  @else
                      <?php $active = ''; ?>
                  @endif
                  <li class="nav-item has-treeview menu-open">
                      <a href="#" class="nav-link {{ $active }}">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Categories
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          @if (Session::get('page') == 'sections')
                              <?php $active = 'active'; ?>
                          @else
                              <?php $active = ''; ?>
                          @endif
                          <li class="nav-item">
                              <a href="{{ route('admin.sections') }}" class="nav-link {{ $active }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Sections</p>
                              </a>
                          </li>
                            @if (Session::get('page') == 'brands')
                                <?php $active = 'active'; ?>
                            @else
                                <?php $active = ''; ?>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('admin.brands') }}" class="nav-link {{ $active }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Brands</p>
                                </a>
                            </li>
                          @if (Session::get('page') == 'categories')
                              <?php $active = 'active'; ?>
                          @else
                              <?php $active = ''; ?>
                          @endif
                          <li class="nav-item">
                              <a href="{{ route('admin.categories') }}" class="nav-link {{ $active }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Categories</p>
                              </a>
                          </li>
                          @if (Session::get('page') == 'products')
                              <?php $active = 'active'; ?>
                          @else
                              <?php $active = ''; ?>
                          @endif
                          <li class="nav-item">
                              <a href="{{ route('admin.products') }}" class="nav-link {{ $active }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Products</p>
                              </a>
                          </li>
                          @if (Session::get('page') == 'banners')
                              <?php $active = 'active'; ?>
                          @else
                              <?php $active = ''; ?>
                          @endif
                          <li class="nav-item">
                              <a href="{{ route('admin.banners') }}" class="nav-link {{ $active }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Banners</p>
                              </a>
                          </li>

                          @if (Session::get('page') == 'coupons')
                              <?php $active = 'active'; ?>
                          @else
                              <?php $active = ''; ?>
                          @endif
                          <li class="nav-item">
                              <a href="{{ route('admin.coupons') }}" class="nav-link {{ $active }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Coupons</p>
                              </a>
                          </li>

                          @if (Session::get('page') == 'orders')
                              <?php $active = 'active'; ?>
                          @else
                              <?php $active = ''; ?>
                          @endif
                          <li class="nav-item">
                              <a href="{{ route('admin.orders') }}" class="nav-link {{ $active }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Orders</p>
                              </a>
                          </li>


                            @if (Session::get('page') == 'users')
                                <?php $active = 'active'; ?>
                            @else
                                <?php $active = ''; ?>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('admin.users') }}" class="nav-link {{ $active }}">
                                    <i class="far fa-user nav-icon"></i>
                                    <p>Users</p>
                                </a>
                            </li>


                            @if (Session::get('page') == 'cmsPages')
                                <?php $active = 'active'; ?>
                            @else
                                <?php $active = ''; ?>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('admin.cms.pages') }}" class="nav-link {{ $active }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>CMS Pages</p>
                                </a>
                            </li>


                          @if (Session::get('page') == 'shipping-charges')
                              <?php $active = 'active'; ?>
                          @else
                              <?php $active = ''; ?>
                          @endif
                          <li class="nav-item">
                              <a href="{{ route('admin.shipping.charges') }}" class="nav-link {{ $active }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Shipping Charges</p>
                              </a>
                          </li>

                          @if (Session::get('page') == 'currencies')
                              <?php $active = 'active'; ?>
                          @else
                              <?php $active = ''; ?>
                          @endif
                          <li class="nav-item">
                              <a href="{{ route('admin.currencies') }}" class="nav-link {{ $active }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Currencies</p>
                              </a>
                          </li>


                          @if (Session::get('page') == 'ratings')
                              <?php $active = 'active'; ?>
                          @else
                              <?php $active = ''; ?>
                          @endif
                          <li class="nav-item">
                              <a href="{{ route('admin.ratings') }}" class="nav-link {{ $active }}">
                                  <i class="far fa-eye nav-icon"></i>
                                  <p>Ratings / Reviews</p>
                              </a>
                          </li>


                          @if (Session::get('page') == 'return_requests')
                              <?php $active = 'active'; ?>
                          @else
                              <?php $active = ''; ?>
                          @endif
                          <li class="nav-item">
                              <a href="{{ route('admin.return.requests') }}" class="nav-link {{ $active }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Return / Requests</p>
                              </a>
                          </li>


                          @if (Session::get('page') == 'exchange_requests')
                              <?php $active = 'active'; ?>
                          @else
                              <?php $active = ''; ?>
                          @endif
                          <li class="nav-item">
                              <a href="{{ route('admin.exchange.requests') }}" class="nav-link {{ $active }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Exchange / Requests</p>
                              </a>
                          </li>



                          @if (Session::get('page') == 'newsletter_subscriber')
                              <?php $active = 'active'; ?>
                          @else
                              <?php $active = ''; ?>
                          @endif
                          <li class="nav-item">
                              <a href="{{ route('admin.newsletter.subscriber') }}" class="nav-link {{ $active }}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Newsletter Subscriber</p>
                              </a>
                          </li>


                      </ul>
                  </li>


              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
