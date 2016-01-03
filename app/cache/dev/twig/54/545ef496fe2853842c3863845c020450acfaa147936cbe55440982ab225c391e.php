<?php

/* @WebProfiler/Collector/router.html.twig */
class __TwigTemplate_3ff121e300a4874beed9b1ac60656f2ecb18d6d331b25207977658cc87255530 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/router.html.twig", 1);
        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
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
        $__internal_41e34d66e59c1d03305021864684979b6884148895936d0a52dcd77786b15636 = $this->env->getExtension("native_profiler");
        $__internal_41e34d66e59c1d03305021864684979b6884148895936d0a52dcd77786b15636->enter($__internal_41e34d66e59c1d03305021864684979b6884148895936d0a52dcd77786b15636_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_41e34d66e59c1d03305021864684979b6884148895936d0a52dcd77786b15636->leave($__internal_41e34d66e59c1d03305021864684979b6884148895936d0a52dcd77786b15636_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_52272dcd7d272de40c1846d815ea1b01041612c651c992a54311d8bbbdf9a5b0 = $this->env->getExtension("native_profiler");
        $__internal_52272dcd7d272de40c1846d815ea1b01041612c651c992a54311d8bbbdf9a5b0->enter($__internal_52272dcd7d272de40c1846d815ea1b01041612c651c992a54311d8bbbdf9a5b0_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_52272dcd7d272de40c1846d815ea1b01041612c651c992a54311d8bbbdf9a5b0->leave($__internal_52272dcd7d272de40c1846d815ea1b01041612c651c992a54311d8bbbdf9a5b0_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_3b14b9ce547d84235336875f3a823f5fdc4c79a40ce9136b02957db85a89d243 = $this->env->getExtension("native_profiler");
        $__internal_3b14b9ce547d84235336875f3a823f5fdc4c79a40ce9136b02957db85a89d243->enter($__internal_3b14b9ce547d84235336875f3a823f5fdc4c79a40ce9136b02957db85a89d243_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_3b14b9ce547d84235336875f3a823f5fdc4c79a40ce9136b02957db85a89d243->leave($__internal_3b14b9ce547d84235336875f3a823f5fdc4c79a40ce9136b02957db85a89d243_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_5051fe2dc38ce357e8b7a634eee4846809bbe1cc3a6e9440beb37a302ef7c682 = $this->env->getExtension("native_profiler");
        $__internal_5051fe2dc38ce357e8b7a634eee4846809bbe1cc3a6e9440beb37a302ef7c682->enter($__internal_5051fe2dc38ce357e8b7a634eee4846809bbe1cc3a6e9440beb37a302ef7c682_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_router", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
        echo "
";
        
        $__internal_5051fe2dc38ce357e8b7a634eee4846809bbe1cc3a6e9440beb37a302ef7c682->leave($__internal_5051fe2dc38ce357e8b7a634eee4846809bbe1cc3a6e9440beb37a302ef7c682_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/router.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 13,  67 => 12,  56 => 7,  53 => 6,  47 => 5,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@WebProfiler/Profiler/layout.html.twig' %}*/
/* */
/* {% block toolbar %}{% endblock %}*/
/* */
/* {% block menu %}*/
/* <span class="label">*/
/*     <span class="icon">{{ include('@WebProfiler/Icon/router.svg') }}</span>*/
/*     <strong>Routing</strong>*/
/* </span>*/
/* {% endblock %}*/
/* */
/* {% block panel %}*/
/*     {{ render(path('_profiler_router', { token: token })) }}*/
/* {% endblock %}*/
/* */
