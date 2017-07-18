<!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <i class="fa fa-user fa-5x"></i>
            </div>
            <div class="pull-left info">
              <p>Alexander Pierce</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="index.html"><i class="fa fa-circle-o"></i> Update</a></li>
                <li class="active"><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
              </ul>
            </li>
            <!--product menu-->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Product</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{!!URL::to('/admin/posts')!!}"><i class="fa fa-circle-o"></i>All Product</a></li>
                <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i>Add New</a></li>
                <li><a href="{!!URL::to('/admin/categories/')!!}"><i class="fa fa-circle-o"></i>Categpries</a></li>
                <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i>Tags</a></li>
              </ul>
            </li>
            <!--Article Menu-->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Articles</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i>All Article</a></li>
                <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i>Add New</a></li>
                <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i>Categpries</a></li>
                <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i>Tags</a></li>
              </ul>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->