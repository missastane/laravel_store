<aside id="sidebar" class="sidebar">
    <section class="sidebar-container">
        <section class="sidebar-wrapper">

        <a href="{{route('customer.home')}}" class="sidebar-link" target="_blank">
                <i class="fas fa-store"></i>
                <span>فروشگاه</span>
            </a>
            <a href="{{route('admin.home')}}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>خانه</span>
            </a>

            <section class="sidebar-part-title">بخش فروش</section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-window-restore icon"></i>
                    <span>ویترین</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{route('admin.market.category.index')}}">دسته بندی</a>
                    <a href="{{route('admin.market.property.index')}}">فرم کالا</a>
                    <a href="{{route('admin.market.brand.index')}}">برندها</a>
                    <a href="{{route('admin.market.product.index')}}">کالاها</a>
                    <a href="{{route('admin.market.store.index')}}">انبار</a>
                    <a href="{{route('admin.market.comment.index')}}">نظرات</a>
                </section>
            </section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fa fa-file icon"></i>
                    <span>سفارش ها</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{route('admin.market.order.newOrder')}}"> جدید</a>
                    <a href="{{route('admin.market.order.sendingOrder')}}">در حال ارسال</a>
                    <a href="{{route('admin.market.order.unpaidOrder')}}">پرداخت نشده</a>
                    <a href="{{route('admin.market.order.canceledOrder')}}">باطل شده</a>
                    <a href="{{route('admin.market.order.returnedOrder')}}">مرجوعی</a>
                    <a href="{{route('admin.market.order.all')}}">تمام سفارش ها</a>
                </section>
            </section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-money-bill icon"></i>
                    <span>پرداخت ها</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{route('admin.market.payment.all')}}">تمام پرداخت ها</a>
                    <a href="{{route('admin.market.payment.online')}}">پرداخت های آنلاین</a>
                    <a href="{{route('admin.market.payment.offline')}}">پرداخت های آفلاین</a>
                    <a href="{{route('admin.market.payment.cash')}}">پرداخت در محل</a>
                </section>
            </section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>تخفیف ها</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{route('admin.market.discount.copan')}}">کوپن تخفیف</a>
                    <a href="{{route('admin.market.discount.commonDiscount')}}">تخفیف عمومی</a>
                    <a href="{{route('admin.market.discount.amazingSale')}}">فروش شگفت انگیز</a>
                </section>
            </section>

            <a href="{{route('admin.market.delivery.index')}}" class="sidebar-link">
                <i class="fas fa-envelope"></i>
                <span>روش های ارسال</span>
            </a>

            <a href="{{route('admin.market.delivery-province.index')}}" class="sidebar-link">
                <i class="fas fa-city"></i>
                <span>مناطق تحت پوشش ارسال</span>
            </a>

            <section class="sidebar-part-title">بخش محتوی</section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-file-image icon"></i>
                    <span>ایجاد محتوا</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{route('admin.content.category.index')}}">دسته بندی پست ها</a>
                    <a href="{{route('admin.content.post.index')}}">پست ها</a>
                    <a href="{{route('admin.content.banner.index')}}">بنرها</a>
                    <a href="{{route('admin.content.menu.index')}}">منو</a>
                    <a href="{{route('admin.content.faq.index')}}">سؤالات متداول</a>
                    <a href="{{route('admin.content.page.index')}}">صفحه ساز</a>
                   
                </section>
            </section>

            <a href="{{route('admin.content.comment.index')}}" class="sidebar-link">
                <i class="fas fa-comment"></i>
                <span>نظرات</span>
            </a>
           

            <section class="sidebar-part-title">بخش کاربران</section>
            <a href="{{route('admin.user.admin-user.index')}}" class="sidebar-link">
                <i class="fas fa-user-secret"></i>
                <span>کاربران ادمین</span>
            </a>
            <a href="{{route('admin.user.customer.index')}}" class="sidebar-link">
                <i class="fas fa-users"></i>
                <span>مشتریان</span>
            </a>
            <a href="{{route('admin.user.permission.index')}}" class="sidebar-link">
                <i class="fa fa-archive"></i>
                <span>دسترسی ها</span>
            </a>
            <a href="{{route('admin.user.role.index')}}" class="sidebar-link">
                <i class="fas fa-user-cog"></i>
                <span>نقش های کاربران</span>
            </a>


            <section class="sidebar-part-title">تیکت ها</section>
          
            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-envelope-open-text icon"></i>
                    <span>تیکت ها</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{route('admin.ticket.admin.index')}}">ادمین های تیکت</a>
                    <a href="{{route('admin.ticket.priority.index')}}">اولویت تیکت ها</a>
                    <a href="{{route('admin.ticket.category.index')}}">دسته بندی تیکت ها</a>
                    <a href="{{route('admin.ticket.index')}}">همه تیکت ها</a>
                    <a href="{{route('admin.ticket.newTickets')}}">تیکت های جدید</a>
                    <a href="{{route('admin.ticket.openTickets')}}">تیکت های باز</a>
                    <a href="{{route('admin.ticket.closeTickets')}}">تیکت های بسته</a>
                </section>
            </section>
           

            <section class="sidebar-part-title">اطلاع رسانی</section>
            <a href="{{route('admin.notify.email.index')}}" class="sidebar-link">
                <i class="fas fa-mail-bulk"></i>
                <span>اطلاعیه ایمیلی</span>
            </a>
            <a href="{{route('admin.notify.sms.index')}}" class="sidebar-link">
                <i class="fas fa-sms"></i>
                <span>اطلاعیه پیامکی</span>
            </a>



            <section class="sidebar-part-title">تنظیمات</section>
            <a href="{{route('admin.setting.index')}}" class="sidebar-link">
                <i class="fas fa-cogs"></i>
                <span>تنظیمات</span>
            </a>

        </section>
    </section>
</aside>
