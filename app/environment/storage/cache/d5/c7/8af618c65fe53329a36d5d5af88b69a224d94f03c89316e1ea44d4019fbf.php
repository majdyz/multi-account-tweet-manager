<?php

/* @usergroup/user/form.twig */
class __TwigTemplate_d5c78af618c65fe53329a36d5d5af88b69a224d94f03c89316e1ea44d4019fbf extends Twig_Template
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
        echo "<form role=\"form\" class=\"form-horizontal\" id=\"user-form-data\">
    <input type=\"hidden\" id=\"user_id\" name=\"id\">

    <div class=\"form-group\">
        <label for=\"user_email\" class=\"col-lg-4 control-label\">Login Email</label>
        <div class=\"col-lg-8\">
            <input type=\"text\" class=\"input-sm form-control validate[required]\" name=\"email\" id=\"user_email\" placeholder=\"Login Email\">
        </div>
    </div>

    <div class=\"form-group\">
        <label for=\"first_name\" class=\"col-lg-4 control-label\">First Name</label>
        <div class=\"col-lg-8\">
            <input type=\"text\" class=\"input-sm form-control validate[required]\" name=\"first_name\" id=\"user_first_name\" placeholder=\"First Name\">
        </div>
    </div>

    <div class=\"form-group\">
        <label for=\"last_name\" class=\"col-lg-4 control-label\">Last Name</label>
        <div class=\"col-lg-8\">
            <input type=\"text\" class=\"input-sm form-control\" name=\"last_name\" id=\"user_last_name\" placeholder=\"Last Name\">
        </div>
    </div>

    <div class=\"form-group\">
        <label for=\"group\" class=\"col-lg-4 control-label\">Group</label>
        <div class=\"col-lg-8\">
            <select name=\"group\" id=\"group\" multiple=\"true\" class=\"input-sm form-control\">
                ";
        // line 29
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["groups"]) ? $context["groups"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["group"]) {
            // line 30
            echo "                <option value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["group"]) ? $context["group"] : null), "id"), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["group"]) ? $context["group"] : null), "name"), "html", null, true);
            echo "</option>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['group'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        echo "            </select>
        </div>
    </div>

    <div class=\"form-group\">
        <label for=\"password\" class=\"col-lg-4 control-label\">Password</label>
        <div class=\"col-lg-8\">
            <input type=\"password\" class=\"input-sm form-control validate[required,minSize[6],maxSize[50]]\" name=\"password\" id=\"password\" placeholder=\"Password\">
        </div>
    </div>

    <div class=\"form-group\">
        <label for=\"confirm_password\" class=\"col-lg-4 control-label\">Confirm Password</label>
        <div class=\"col-lg-8\">
            <input type=\"password\" class=\"input-sm form-control validate[required,equals[password]]\" name=\"confirm_password\" id=\"confirm_password\" placeholder=\"Confirm password\">
        </div>
    </div>
</form>";
    }

    public function getTemplateName()
    {
        return "@usergroup/user/form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  64 => 32,  53 => 30,  49 => 29,  19 => 1,  115 => 51,  113 => 50,  98 => 37,  88 => 33,  84 => 32,  79 => 30,  75 => 29,  71 => 28,  67 => 27,  62 => 26,  58 => 25,  35 => 5,  31 => 3,  28 => 2,);
    }
}
