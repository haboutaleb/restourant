<!-- Main sidebar -->
<div class="sidebar sidebar-main sidebar-default">
	<div class="sidebar-content">

		<!-- User menu -->
		<div class="sidebar-user-material">
			<div class="category-content">
				<div class="sidebar-user-material-content">
					<a href="#"><img src="{{ getImage('admins', $auth->image) }}" class="img-circle img-responsive" alt=""></a>
					<h6>  </h6>
					<span class="text-size-small">  </span>
				</div>

				<div class="sidebar-user-material-menu">
					<a href="#user-nav" data-toggle="collapse"><span>حسابي</span> <i class="caret"></i></a>
				</div>
			</div>

			<div class="navigation-wrapper collapse" id="user-nav">
				<ul class="navigation">
					<li><a href=""><i class="icon-user-plus"></i> <span> حسابي </span></a></li>
					<li class="divider"></li>
					<li><a href=""><i class="icon-cog5"></i> <span> الإعدادات </span></a></li>
					<li><a href=""><i class="icon-switch2"></i> <span> نسجيل الخروج </span></a></li>
				</ul>
			</div>
		</div>
		<!-- /user menu -->

		<!-- Main navigation -->
		<div class="sidebar-category sidebar-category-visible">
			<div class="category-content no-padding">
				<ul class="navigation navigation-main navigation-accordion">

					<!-- Main -->
					<li class="navigation-header"><span> الرئيسية </span> <i class="icon-menu" title="Main pages"></i></li>
					<li><a href="{{ route('admin-panel') }}"><i class="icon-home4"></i> <span> الصفحة الرئيسية</span></a></li>

					@if(is_admin($auth->id) == 1)
					<li class="{{ Request::is('admin-panel/admins/*') || Request::is('admin-panel/admins') ? 'active' : '' }}">
						<a href="javascript:void(0);"><i class="icon-users4"></i> <span>المشرفين</span></a>
						<ul>
							<li class="{{ Request::is('admin-panel/admins') ? 'active' : '' }}">
								<a href="{{ route('admins.index') }}">عرض المشرفين</a>
							</li>
							<li class="{{ Request::is('admin-panel/admins/create') ? 'active' : '' }}">
								<a href="{{ route('admins.create') }}">إضافة مشرف</a>
							</li>
						</ul>
                    </li>
					@endif
					<li>
						<a href="#"><i class="icon-people"></i> <span> المستخدمين </span></a>
						<ul>
							<li><a href="">عرض المستخدمين</a></li>
							<li ><a href="">إضافة مستخدم جديد</a></li>
						</ul>
                    </li>

					<li class="{{ Request::is('admin-panel/categories/*') || Request::is('admin-panel/categories') ? 'active' : '' }}">
						<a href="javascript:void(0);"><i class="icon-stack2"></i> <span>الفئات</span></a>
						<ul>
							<li class="{{ Request::is('admin-panel/categories') ? 'active' : '' }}">
								<a href="{{ route('categories.index') }}">عرض الفئات</a>
							</li>
							<li class="{{ Request::is('admin-panel/categories/create') ? 'active' : '' }}">
								<a href="{{ route('categories.create') }}">إضافة فئة</a>
							</li>
						</ul>
					</li>
					
					<li class="{{ Request::is('admin-panel/tables/*') || Request::is('admin-panel/tables') ? 'active' : '' }}">
						<a href="javascript:void(0);"><i class="icon-checkbox-partial"></i> <span>الطاولات</span></a>
						<ul>
							<li class="{{ Request::is('admin-panel/tables') ? 'active' : '' }}">
								<a href="{{ route('tables.index') }}">عرض الطاولات</a>
							</li>
							<li class="{{ Request::is('admin-panel/tables/create') ? 'active' : '' }}">
								<a href="{{ route('tables.create') }}">إضافة طاولة</a>
							</li>
						</ul>
					</li>
					
					<li class="{{ Request::is('admin-panel/items/*') || Request::is('admin-panel/items') ? 'active' : '' }}">
						<a href="javascript:void(0);"><i class="icon-store"></i> <span>المأكولات</span></a>
						<ul>
							<li class="{{ Request::is('admin-panel/items') ? 'active' : '' }}">
								<a href="{{ route('items.index') }}">عرض المأكولات</a>
							</li>
							<li class="{{ Request::is('admin-panel/items/create') ? 'active' : '' }}">
								<a href="{{ route('items.create') }}">إضافة أكله</a>
							</li>
						</ul>
                    </li>

                    <li>
                        <a href="#"><i class="icon-city"></i> <span> الأقسام الأساسية</span></a>
                        <ul>
                            <li><a href="  " > كل الأقسام الأساسية</a></li>
                            <li ><a href="  " > إضافة قسم أساسي </a></li>
                        </ul>
                    </li>

					<li>
						<a href="#"><i class="icon-city"></i> <span> اللأقسام الفرعية </span></a>
						<ul>
							<li ><a href=""> كل الأقسام الفرعية </a></li>
							<li ><a href=""> إضافة قسم فرعي جديد </a></li>
						</ul>
					</li>



					<!-- /main -->

					<!-- others -->
					<li class="navigation-header"><span> أخري </span> <i class="icon-menu" title=" أخري "></i></li>

                    <li>
						<a href="#"><i class="icon-fire"></i> <span>  عناصر القائمة </span></a>
						<ul>
							<li ><a href=""> كل  عناصر القائمة  </a></li>
							<li><a href=""> إضافة عنصر جديد للقائمة </a></li>
						</ul>
					</li>



					<li>
						<a href="#"> <i class="icon-rocket"></i> <span> الطلبات </span></a>
						<ul>
                        <li ><a href="{{route('order')}}"> عرض كل الطلبات </a></li>
                        <li ><a href="{{route('order.create')}}"> إضافة طلب جديد </a></li>
						</ul>
                    </li>

					<li>
						<a href="#"><i class="icon-trophy3"></i> <span> الأماكن </span></a>
						<ul>
							<li ><a href=""> عرض كل الأماكن </a></li>
							<li ><a href=""> إضافة مكان جديد </a></li>
						</ul>
                    </li>




						<li ><a href=""><i class="icon-wrench3"></i> <span> إعدادت التطبيق </span></a></li>



					<!-- /others -->

				</ul>
			</div>
		</div>
		<!-- /main navigation -->

	</div>
</div>
<!-- /main sidebar -->
