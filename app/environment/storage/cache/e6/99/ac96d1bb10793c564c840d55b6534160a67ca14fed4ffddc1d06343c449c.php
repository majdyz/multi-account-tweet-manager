<?php

/* admin/index.twig */
class __TwigTemplate_e699ac96d1bb10793c564c840d55b6534160a67ca14fed4ffddc1d06343c449c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("master.twig");

        $this->blocks = array(
            'body' => array($this, 'block_body'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "master.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "    <div id=\"wrapper\">
        ";
        // line 5
        echo twig_include($this->env, $context, "admin/topbar.twig");
        echo "
        ";
        // line 6
        echo twig_include($this->env, $context, "admin/sidebar.twig");
        echo "
        <div id=\"page-wrapper\">
            ";
        // line 8
        $this->displayBlock('content', $context, $blocks);
        // line 11
        echo "        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
";
    }

    // line 8
    public function block_content($context, array $blocks = array())
    {
        // line 9
        echo "                ";
        $this->env->loadTemplate("admin/dashboard.twig")->display($context);
        // line 10
        echo "            ";
    }

    public function getTemplateName()
    {
        return "admin/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  61 => 10,  58 => 9,  55 => 8,  46 => 11,  44 => 8,  39 => 6,  35 => 5,  32 => 4,  29 => 3,);
    }
}
