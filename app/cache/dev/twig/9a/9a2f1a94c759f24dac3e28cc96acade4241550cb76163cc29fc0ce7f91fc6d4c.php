<?php

/* @Twig/Exception/exception_full.html.twig */
class __TwigTemplate_8e80503c97965d6ee0147d20ffdfc8f535d85fa555bded39d36819c0748867eb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Twig/layout.html.twig", "@Twig/Exception/exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@Twig/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_21528e9856d50ea0f73c5b035e30394393f67041b4858e621421796ccb4c14a5 = $this->env->getExtension("native_profiler");
        $__internal_21528e9856d50ea0f73c5b035e30394393f67041b4858e621421796ccb4c14a5->enter($__internal_21528e9856d50ea0f73c5b035e30394393f67041b4858e621421796ccb4c14a5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_21528e9856d50ea0f73c5b035e30394393f67041b4858e621421796ccb4c14a5->leave($__internal_21528e9856d50ea0f73c5b035e30394393f67041b4858e621421796ccb4c14a5_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_19ed8b9f1d9d7b91dd7ae95f96e5fac4ebdfc4f1e352961b5cd96023b082bcc8 = $this->env->getExtension("native_profiler");
        $__internal_19ed8b9f1d9d7b91dd7ae95f96e5fac4ebdfc4f1e352961b5cd96023b082bcc8->enter($__internal_19ed8b9f1d9d7b91dd7ae95f96e5fac4ebdfc4f1e352961b5cd96023b082bcc8_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_19ed8b9f1d9d7b91dd7ae95f96e5fac4ebdfc4f1e352961b5cd96023b082bcc8->leave($__internal_19ed8b9f1d9d7b91dd7ae95f96e5fac4ebdfc4f1e352961b5cd96023b082bcc8_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_34bbcbe2e11cbd7fc5a1c1f46f82fdbbafcf0e0d2021a6d9becff079c58e80b3 = $this->env->getExtension("native_profiler");
        $__internal_34bbcbe2e11cbd7fc5a1c1f46f82fdbbafcf0e0d2021a6d9becff079c58e80b3->enter($__internal_34bbcbe2e11cbd7fc5a1c1f46f82fdbbafcf0e0d2021a6d9becff079c58e80b3_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_34bbcbe2e11cbd7fc5a1c1f46f82fdbbafcf0e0d2021a6d9becff079c58e80b3->leave($__internal_34bbcbe2e11cbd7fc5a1c1f46f82fdbbafcf0e0d2021a6d9becff079c58e80b3_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_bc45f8cc97d54afa53c04fb6cdd4a7cdf08b2ea1946527d4818d3b4442bb8300 = $this->env->getExtension("native_profiler");
        $__internal_bc45f8cc97d54afa53c04fb6cdd4a7cdf08b2ea1946527d4818d3b4442bb8300->enter($__internal_bc45f8cc97d54afa53c04fb6cdd4a7cdf08b2ea1946527d4818d3b4442bb8300_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("@Twig/Exception/exception.html.twig", "@Twig/Exception/exception_full.html.twig", 12)->display($context);
        
        $__internal_bc45f8cc97d54afa53c04fb6cdd4a7cdf08b2ea1946527d4818d3b4442bb8300->leave($__internal_bc45f8cc97d54afa53c04fb6cdd4a7cdf08b2ea1946527d4818d3b4442bb8300_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@Twig/layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     <link href="{{ absolute_url(asset('bundles/framework/css/exception.css')) }}" rel="stylesheet" type="text/css" media="all" />*/
/* {% endblock %}*/
/* */
/* {% block title %}*/
/*     {{ exception.message }} ({{ status_code }} {{ status_text }})*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/*     {% include '@Twig/Exception/exception.html.twig' %}*/
/* {% endblock %}*/
/* */
