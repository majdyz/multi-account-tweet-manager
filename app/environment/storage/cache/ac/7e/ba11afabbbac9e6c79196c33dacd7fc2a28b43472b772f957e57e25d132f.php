<?php

/* @usergroup/group/index.twig */
class __TwigTemplate_ac7eba11afabbbac9e6c79196c33dacd7fc2a28b43472b772f957e57e25d132f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("admin/index.twig");

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "admin/index.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = array())
    {
        // line 3
        echo "<div class=\"row page-header-box\">
    <div class=\"col-xs-10\">
        <h3>";
        // line 5
        echo twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
        echo "</h3>
    </div>
    <div class=\"col-xs-2\">
        <a href=\"#\" id=\"btn-user-add\" class=\"btn btn-success btn-sm pull-right\"><i class=\"fa fa-plus\"></i> Add Group</a>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@usergroup/group/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  35 => 5,  31 => 3,  28 => 2,);
    }
}
