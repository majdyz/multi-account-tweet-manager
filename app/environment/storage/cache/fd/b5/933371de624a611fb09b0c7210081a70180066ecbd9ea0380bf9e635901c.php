<?php

/* admin/sidebar.twig */
class __TwigTemplate_fdb5933371de624a611fb09b0c7210081a70180066ecbd9ea0380bf9e635901c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<nav class=\"navbar-default navbar-static-side\" role=\"navigation\">
    <div class=\"sidebar-collapse\">
        ";
        // line 3
        echo $this->env->getExtension('menu_renderer')->renderMenu("admin_sidebar", "ul", array("attributes" => array("class" => "nav", "id" => "side-menu"), "active" => array("class" => "menu_active", "prepend" => "<div class='pointer'><div class='arrow'></div><div class='arrow_border'></div></div>")));
        // line 14
        echo "
        <!-- /#side-menu -->
    </div>
    <!-- /.sidebar-collapse -->
</nav>
<!-- /.navbar-static-side -->";
    }

    public function getTemplateName()
    {
        return "admin/sidebar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  25 => 14,  23 => 3,  63 => 34,  47 => 21,  34 => 11,  30 => 10,  19 => 1,  61 => 10,  58 => 9,  55 => 8,  46 => 11,  44 => 8,  39 => 6,  35 => 5,  32 => 4,  29 => 3,);
    }
}
