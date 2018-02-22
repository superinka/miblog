<!-- Main sidebar -->
<div class="sidebar sidebar-main">
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="category-content">
                <div class="media">
                    <a href="#" class="media-left"></a>
                    <div class="media-body">
                        <span class="media-heading text-semibold">{{Auth::user()->email}}</span>
                        <div class="text-size-mini text-muted">
                            <i class="icon-pin text-size-small"></i> &nbsp;{{Auth::user()->name}}
                        </div>
                    </div>

                    <div class="media-right media-middle">
                        <ul class="icons-list">
                            <li>
                                <a href="#"><i class="icon-cog3"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->

        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">

                    <!-- Main -->
                    <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
                    <li class="active"><a href="{{url('admin')}}"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
                    <li>
                        <a href="#"><i class="icon-stack2"></i> <span>Bài viết</span></a>
                        <ul>
                            <li><a href="{{ url('admin/post') }}">Quản lý</a></li>
                            <li><a href="layout_navbar_sidebar_fixed.html">Viết bài mới</a></li>
                            <li><a href="{{ url('admin/postcategory') }}">Danh mục</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="icon-copy"></i> <span>Thành viên</span></a>
                        <ul>
                            <li><a href="../index.html" id="layout1">Quản lý</a></li>
                            <li><a href="index.html" id="layout2">Thêm mới <span class="label bg-warning-400">Current</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="icon-droplet2"></i> <span>Menu</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-stack"></i> <span>Quiz</span></a>
                        <ul>
                            <li><a href="starters/horizontal_nav.html">Nhóm Câu Hỏi</a></li>
                            <li><a href="starters/1_col.html">Câu Hỏi</a></li>
                            <li><a href="starters/2_col.html">Đề Thi</a></li>
                            <li><a href="starters/1_col.html">Bài Thi</a></li>
                            <li><a href="starters/2_col.html">Báo cáo thống kê</a></li>
                        </ul>
                    <!-- /main -->
                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>
<!-- /main sidebar -->