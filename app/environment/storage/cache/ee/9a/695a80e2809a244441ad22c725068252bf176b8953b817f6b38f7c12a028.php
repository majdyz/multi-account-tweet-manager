<?php

/* @usergroup/user/index.twig */
class __TwigTemplate_ee9a695a80e2809a244441ad22c725068252bf176b8953b817f6b38f7c12a028 extends Twig_Template
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
        <a href=\"#\" id=\"btn-user-add\" class=\"btn btn-success btn-sm pull-right\"><i class=\"fa fa-plus\"></i> Add User</a>
    </div>
</div>
<div class=\"row\">
    <div class=\"col-lg-12\">
        <div class=\"table-responsive\">
            <table class=\"table table-striped table-condensed\">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email Address</th>
                        <th style=\"width:15%\" class=\"text-center\">Action</th>
                    </tr>
                </thead>
                <tbody id=\"user-table\">
                    ";
        // line 25
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["users"]) ? $context["users"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
            // line 26
            echo "                    <tr id=\"user-row-";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "id"), "html", null, true);
            echo "\">
                        <td>";
            // line 27
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "id"), "html", null, true);
            echo "</td>
                        <td>";
            // line 28
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "first_name"), "html", null, true);
            echo "</td>
                        <td>";
            // line 29
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "last_name"), "html", null, true);
            echo "</td>
                        <td>";
            // line 30
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "email"), "html", null, true);
            echo "</td>
                        <td class=\"text-center\">
                            <a data-id=\"";
            // line 32
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "id"), "html", null, true);
            echo "\" class=\"btn btn-xs btn-primary btn-user-edit\" href=\"#\"><i class=\"fa fa-edit fa-fw\"></i>Edit</a>
                            <a data-id=\"";
            // line 33
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "id"), "html", null, true);
            echo "\" class=\"btn btn-xs btn-danger btn-user-delete\" href=\"#\"><i class=\"fa fa-times fa-fw\"></i>Remove</a>
                        </td>
                    </tr>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['user'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 37
        echo "                </tbody>
            </table>
        </div>
    </div>
</div>
<div class=\"modal fade\" id=\"user-modal\">
    <div class=\"modal-dialog\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
                <h4 class=\"modal-title\" id=\"modal-title\">User Form</h4>
            </div>
            <div class=\"modal-body\">
                ";
        // line 50
        $this->env->loadTemplate("@usergroup/user/form.twig")->display($context);
        // line 51
        echo "            </div>
            <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-default btn-sm\" data-dismiss=\"modal\">Cancel</button>
                <button type=\"button\" class=\"btn btn-success btn-sm\" id=\"btn-user-save\" data-method=\"\">Save</button>
            </div>
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@usergroup/user/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  115 => 51,  113 => 50,  98 => 37,  88 => 33,  84 => 32,  79 => 30,  75 => 29,  71 => 28,  67 => 27,  62 => 26,  58 => 25,  35 => 5,  31 => 3,  28 => 2,);
    }
}
