<?php

/* admin/login.twig */
class __TwigTemplate_a9f9ed02884843bc9ec1dd1eb0fb1445cbf8fd10cd59b8418ebdb5af3b0a848a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("master.twig");

        $this->blocks = array(
            'body' => array($this, 'block_body'),
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
        echo "    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-md-4 col-md-offset-4\">
                ";
        // line 7
        if ($this->getAttribute((isset($context["flash"]) ? $context["flash"] : null), "message")) {
            // line 8
            echo "                <div class=\"alert alert-danger alert-dismissable\" style=\"margin-top: 25px\">
                    <button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">×</button>
                    ";
            // line 10
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["flash"]) ? $context["flash"] : null), "message"), "html", null, true);
            echo "
                </div>
                ";
        }
        // line 13
        echo "                <div class=\"login-panel panel panel-default\" style=\"margin-top:40px\">
                    <div class=\"panel-heading\">
                        <h3 class=\"panel-title\">Please Sign In</h3>
                    </div>
                    <div class=\"panel-body\">
                        <form role=\"form\" method=\"post\" action=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->base(), "html", null, true);
        echo "/login\">
                            <input type=\"hidden\" name=\"redirect\" value=\"";
        // line 19
        echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["flash"]) ? $context["flash"] : null), "redirect")) ? ($this->getAttribute((isset($context["flash"]) ? $context["flash"] : null), "redirect")) : ((isset($context["redirect"]) ? $context["redirect"] : null))), "html", null, true);
        echo "\">
                            <fieldset>
                                <div class=\"form-group\">
                                    <input class=\"form-control\" placeholder=\"E-mail\" name=\"email\" type=\"email\" autofocus value=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["flash"]) ? $context["flash"] : null), "email"), "html", null, true);
        echo "\">
                                </div>
                                <div class=\"form-group\">
                                    <input class=\"form-control\" placeholder=\"Password\" name=\"password\" type=\"password\" value=\"\">
                                </div>
                                <div class=\"checkbox\">
                                    <label>
                                        <input name=\"remember\" type=\"checkbox\" value=\"Remember Me\" ";
        // line 29
        if ($this->getAttribute((isset($context["flash"]) ? $context["flash"] : null), "remember")) {
            echo "checked";
        }
        echo ">Remember Me
                                    </label>
                                </div>

                                <div class=\"form-group\">
                                    <div class=\"col-xs-6 text-center\">
                                        <button type=\"submit\" class=\"btn btn-md btn-success btn-block\">Login</button>
                                    </div>
                                    <div class=\"col-xs-6 text-center\">
                                        <a href=\"";
        // line 38
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->site("/"), "html", null, true);
        echo "\" class=\"btn btn-md btn-danger btn-block\">Cancel</a>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "admin/login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  89 => 38,  75 => 29,  65 => 22,  59 => 19,  55 => 18,  48 => 13,  42 => 10,  38 => 8,  36 => 7,  31 => 4,  28 => 3,);
    }
}
