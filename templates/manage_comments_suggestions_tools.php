<?php
    /**
     * Template Name: manage_comments_suggestions
     *
     */

    // Se añaden estilos
    wp_enqueue_style( 'style',get_template_directory_uri().'/css/td_manage_comments_suggestions.css',false,'1.1','all');
    wp_enqueue_style( 'datatables.min.css',get_template_directory_uri().'/js/tools_dintev/datatables/datatables.min.css');

    get_header();

?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<div class="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <?php
                if ( is_user_logged_in() ) {

                    global $current_user;

                    $args = array(
                    'class' => 'img-responsive img-circle',
                    );

                    $items .= '<li>';
                    $items .= '<div class="row">';
                    $items .= '<div class=""><center>'.get_avatar( $current_user->ID, 52, '', '', $args).'</center></div>';
                    $items .= '<div class="col-sm-12"><center>'.$current_user->display_name.'<br><a href="' . wp_logout_url() . '" id="a-log-out"> Cerrar sesión</a></center></div>';
                    $items .= '</div>';

                    echo $items;
            ?>
                    <hr class="col-sm-12">
                    <li>
                        <a href="#">
                            <span class="fa fa-object-group"></span>
                            Nueva categoria
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="fa fa-wrench"></span>
                            Nueva herramienta
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="fa fa-comment"></span>
                            Comentarios por herramienta</a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="fa fa-comments"></span>
                            Comentarios del sitio
                        </a>
                    </li>
            <?php
                }else {
                    $items .= '<li><a href="' . wp_login_url() . '">' .'Login In'. '</a></li>';
                    $items .= '<li><a href="' . wp_registration_url() . '">' .'Sign Up'. '</a></li>';
                    echo $items;
                }
            ?>

        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h3>Comentarios por herramienta</h3>
                    <div class="col-sm-12">
                        <table id="comments_tools_table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Comentario</th>
                                    <th>Nombre</th>
                                    <th>Correo electrónico</th>
                                    <th>Herramienta</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $comments = td_get_comments_by_tool();
                                print_r($comments);
                                foreach($comments as $comment){

                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- .wrap -->

<?php
    wp_enqueue_script( 'manage_comments_suggestions_tools.js', get_template_directory_uri().'/js/tools_dintev/manage_comments_suggestions_tools.js');
    wp_enqueue_script( 'datatables.min.js', get_template_directory_uri().'/js/tools_dintev/datatables/datatables.min.js');
    get_footer();
?>