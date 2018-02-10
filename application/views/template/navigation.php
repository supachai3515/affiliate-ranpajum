<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url();?>">B-Boy Computer</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo ucfirst($this->session->userdata('username')); ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li class="divider"></li>
                <li>
                    <a href="<?php echo base_url('signout');?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
        <?php foreach ($menus_list as $menu) {

                if($menu['parent_id'] == "0" ) {
                    
                    echo $menu['id'] == $menu_id ? '<li class="active">' : '<li>';
                    echo'<a href="javascript:;" data-toggle="collapse" data-target="#'.$menu['name'].'"><i class="'.$menu['icon'].'"></i> '.$menu['name'].' <i class="fa fa-fw fa-caret-down"></i></a>';
                        echo '<ul id="'.$menu['name'].'" class="collapse">';
                            foreach ($menus_list as $supmenu) {
                                    if($supmenu['parent_id'] == $menu['id'])
                                    {

                                        echo "<li>";
                                        echo'<a href="'.base_url().$supmenu['link'].'"><i class="'.$supmenu['icon'].'"></i> '.$supmenu['name'].'</a>';
                                        echo "</li>";
                                                                               
                                    }
                                
                            }
                        echo "</ul>";
                    echo "</li>";
                }

                if($menu['parent_id'] == "99"){

                    echo $menu['id'] == $menu_id ? '<li class="active">' : '<li>';

                    echo'<a href="'.base_url().$menu['link'].'"><i class="'.$menu['icon'].'"></i> '.$menu['name'].'</a>';
                    echo'</li>';
                }

            } ?> 
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>

