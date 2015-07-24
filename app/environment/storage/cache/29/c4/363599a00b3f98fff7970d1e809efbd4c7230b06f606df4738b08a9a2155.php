<?php

/* admin/topbar.twig */
class __TwigTemplate_29c4363599a00b3f98fff7970d1e809efbd4c7230b06f606df4738b08a9a2155 extends Twig_Template
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
        echo "<nav class=\"navbar navbar-inverse navbar-static-top\" role=\"navigation\" style=\"margin-bottom: 0\">
    <div class=\"navbar-header\">
        <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".sidebar-collapse\">
            <span class=\"sr-only\">Toggle navigation</span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
        </button>

        <img src=\"";
        // line 10
        echo twig_escape_filter($this->env, (isset($context["assetUrl"]) ? $context["assetUrl"] : null), "html", null, true);
        echo "images/logo.png\" alt=\"xsanisty logo\" class=\"navbar-logo\">
        <a class=\"navbar-brand hidden-xs\" href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->site("/"), "html", null, true);
        echo "\">
            Slim Starter Application
        </a>
    </div>
    <!-- /.navbar-header -->

    <ul class=\"nav navbar-top-links navbar-right hidden-xs\">
        <!-- /.dropdown -->
        <li>
            <label for=\"\" class=\"loader label label-info\" id=\"loader\">
                Loading <img src=\"";
        // line 21
        echo twig_escape_filter($this->env, (isset($context["assetUrl"]) ? $context["assetUrl"] : null), "html", null, true);
        echo "images/loader.gif\" alt=\"\">
            </label>
        </li>
        <li class=\"dropdown\">
            <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">
                <i class=\"fa fa-user fa-fw\"></i>  <i class=\"fa fa-caret-down\"></i>
            </a>
            <ul class=\"dropdown-menu dropdown-user\">
                <li><a href=\"#\"><i class=\"fa fa-user fa-fw\"></i> User Profile</a>
                </li>
                <li><a href=\"#\"><i class=\"fa fa-gear fa-fw\"></i> Settings</a>
                </li>
                <li class=\"divider\"></li>
                <li><a href=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->urlFor("logout"), "html", null, true);
        echo "\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

</nav>
<!-- /.navbar-static-top -->";
    }

    public function getTemplateName()
    {
        return "admin/topbar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  63 => 34,  47 => 21,  34 => 11,  30 => 10,  19 => 1,  61 => 10,  58 => 9,  55 => 8,  46 => 11,  44 => 8,  39 => 6,  35 => 5,  32 => 4,  29 => 3,);
    }
}
