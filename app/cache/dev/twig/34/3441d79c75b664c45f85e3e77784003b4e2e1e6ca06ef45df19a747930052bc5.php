<?php

/* @WebProfiler/Collector/exception.html.twig */
class __TwigTemplate_98235485dca3827466fc88c9d86b8d977d62cd2be61f1503b6a33e9bf017e435 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/exception.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_32bfe59ae8a133ccb7f1f1cd5b908a8d5d4de6ba9365c12595546b535c4272ff = $this->env->getExtension("native_profiler");
        $__internal_32bfe59ae8a133ccb7f1f1cd5b908a8d5d4de6ba9365c12595546b535c4272ff->enter($__internal_32bfe59ae8a133ccb7f1f1cd5b908a8d5d4de6ba9365c12595546b535c4272ff_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/exception.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_32bfe59ae8a133ccb7f1f1cd5b908a8d5d4de6ba9365c12595546b535c4272ff->leave($__internal_32bfe59ae8a133ccb7f1f1cd5b908a8d5d4de6ba9365c12595546b535c4272ff_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_96414997cf6ff49a2cf9e9036989fd0c5783312f62037bef0df133928dde752f = $this->env->getExtension("native_profiler");
        $__internal_96414997cf6ff49a2cf9e9036989fd0c5783312f62037bef0df133928dde752f->enter($__internal_96414997cf6ff49a2cf9e9036989fd0c5783312f62037bef0df133928dde752f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    ";
        if ($this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "hasexception", array())) {
            // line 5
            echo "        <style>
            ";
            // line 6
            echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_exception_css", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
            echo "
        </style>
    ";
        }
        // line 9
        echo "    ";
        $this->displayParentBlock("head", $context, $blocks);
        echo "
";
        
        $__internal_96414997cf6ff49a2cf9e9036989fd0c5783312f62037bef0df133928dde752f->leave($__internal_96414997cf6ff49a2cf9e9036989fd0c5783312f62037bef0df133928dde752f_prof);

    }

    // line 12
    public function block_menu($context, array $blocks = array())
    {
        $__internal_ca0b20dc5f54b3f2b2cea686f5006838eed993fcdf03f4f3e93f0331aa137631 = $this->env->getExtension("native_profiler");
        $__internal_ca0b20dc5f54b3f2b2cea686f5006838eed993fcdf03f4f3e93f0331aa137631->enter($__internal_ca0b20dc5f54b3f2b2cea686f5006838eed993fcdf03f4f3e93f0331aa137631_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 13
        echo "    <span class=\"label ";
        echo (($this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "hasexception", array())) ? ("label-status-error") : ("disabled"));
        echo "\">
        <span class=\"icon\">";
        // line 14
        echo twig_include($this->env, $context, "@WebProfiler/Icon/exception.svg");
        echo "</span>
        <strong>Exception</strong>
        ";
        // line 16
        if ($this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "hasexception", array())) {
            // line 17
            echo "            <span class=\"count\">
                <span>1</span>
            </span>
        ";
        }
        // line 21
        echo "    </span>
";
        
        $__internal_ca0b20dc5f54b3f2b2cea686f5006838eed993fcdf03f4f3e93f0331aa137631->leave($__internal_ca0b20dc5f54b3f2b2cea686f5006838eed993fcdf03f4f3e93f0331aa137631_prof);

    }

    // line 24
    public function block_panel($context, array $blocks = array())
    {
        $__internal_92ded7d3b66626edce70a084ff4d044f02da3ca0eed0ae5d083367155d3612b2 = $this->env->getExtension("native_profiler");
        $__internal_92ded7d3b66626edce70a084ff4d044f02da3ca0eed0ae5d083367155d3612b2->enter($__internal_92ded7d3b66626edce70a084ff4d044f02da3ca0eed0ae5d083367155d3612b2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 25
        echo "    <h2>Exceptions</h2>

    ";
        // line 27
        if ( !$this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "hasexception", array())) {
            // line 28
            echo "        <div class=\"empty\">
            <p>No exception was thrown and caught during the request.</p>
        </div>
    ";
        } else {
            // line 32
            echo "        <div class=\"sf-reset\">
            ";
            // line 33
            echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_exception", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
            echo "
        </div>
    ";
        }
        
        $__internal_92ded7d3b66626edce70a084ff4d044f02da3ca0eed0ae5d083367155d3612b2->leave($__internal_92ded7d3b66626edce70a084ff4d044f02da3ca0eed0ae5d083367155d3612b2_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/exception.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  117 => 33,  114 => 32,  108 => 28,  106 => 27,  102 => 25,  96 => 24,  88 => 21,  82 => 17,  80 => 16,  75 => 14,  70 => 13,  64 => 12,  54 => 9,  48 => 6,  45 => 5,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@WebProfiler/Profiler/layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     {% if collector.hasexception %}*/
/*         <style>*/
/*             {{ render(path('_profiler_exception_css', { token: token })) }}*/
/*         </style>*/
/*     {% endif %}*/
/*     {{ parent() }}*/
/* {% endblock %}*/
/* */
/* {% block menu %}*/
/*     <span class="label {{ collector.hasexception ? 'label-status-error' : 'disabled' }}">*/
/*         <span class="icon">{{ include('@WebProfiler/Icon/exception.svg') }}</span>*/
/*         <strong>Exception</strong>*/
/*         {% if collector.hasexception %}*/
/*             <span class="count">*/
/*                 <span>1</span>*/
/*             </span>*/
/*         {% endif %}*/
/*     </span>*/
/* {% endblock %}*/
/* */
/* {% block panel %}*/
/*     <h2>Exceptions</h2>*/
/* */
/*     {% if not collector.hasexception %}*/
/*         <div class="empty">*/
/*             <p>No exception was thrown and caught during the request.</p>*/
/*         </div>*/
/*     {% else %}*/
/*         <div class="sf-reset">*/
/*             {{ render(path('_profiler_exception', { token: token })) }}*/
/*         </div>*/
/*     {% endif %}*/
/* {% endblock %}*/
/* */
