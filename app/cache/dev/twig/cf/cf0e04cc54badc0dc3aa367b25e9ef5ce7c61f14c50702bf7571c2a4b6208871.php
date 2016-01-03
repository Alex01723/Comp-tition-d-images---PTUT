<?php

/* base.html.twig */
class __TwigTemplate_fd79d951f38368bb23e1cc40e5e31dd0e9e30f7b2423e7a6861c051b41ce61b6 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_c58d6d5451a3bea543f43c7a28c7a5a13357a6a35fedfd677746deac67aaab5a = $this->env->getExtension("native_profiler");
        $__internal_c58d6d5451a3bea543f43c7a28c7a5a13357a6a35fedfd677746deac67aaab5a->enter($__internal_c58d6d5451a3bea543f43c7a28c7a5a13357a6a35fedfd677746deac67aaab5a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        ";
        // line 6
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 7
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
    </head>
    <body>
        ";
        // line 10
        $this->displayBlock('body', $context, $blocks);
        // line 11
        echo "        ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 12
        echo "    </body>
</html>
";
        
        $__internal_c58d6d5451a3bea543f43c7a28c7a5a13357a6a35fedfd677746deac67aaab5a->leave($__internal_c58d6d5451a3bea543f43c7a28c7a5a13357a6a35fedfd677746deac67aaab5a_prof);

    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        $__internal_3b0c8d743c66addd179f3e0f20b99ef0407ce7101cd987adedd034a572aba0bf = $this->env->getExtension("native_profiler");
        $__internal_3b0c8d743c66addd179f3e0f20b99ef0407ce7101cd987adedd034a572aba0bf->enter($__internal_3b0c8d743c66addd179f3e0f20b99ef0407ce7101cd987adedd034a572aba0bf_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Welcome!";
        
        $__internal_3b0c8d743c66addd179f3e0f20b99ef0407ce7101cd987adedd034a572aba0bf->leave($__internal_3b0c8d743c66addd179f3e0f20b99ef0407ce7101cd987adedd034a572aba0bf_prof);

    }

    // line 6
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_2dc9ab1d606da2261f9f3c13418d70ea6810e02c5e30995e08e4c50a1dd95c64 = $this->env->getExtension("native_profiler");
        $__internal_2dc9ab1d606da2261f9f3c13418d70ea6810e02c5e30995e08e4c50a1dd95c64->enter($__internal_2dc9ab1d606da2261f9f3c13418d70ea6810e02c5e30995e08e4c50a1dd95c64_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_2dc9ab1d606da2261f9f3c13418d70ea6810e02c5e30995e08e4c50a1dd95c64->leave($__internal_2dc9ab1d606da2261f9f3c13418d70ea6810e02c5e30995e08e4c50a1dd95c64_prof);

    }

    // line 10
    public function block_body($context, array $blocks = array())
    {
        $__internal_c721078d6345c56879677bc8a45592f3d89b569c8377fe276bba9127c6a23d14 = $this->env->getExtension("native_profiler");
        $__internal_c721078d6345c56879677bc8a45592f3d89b569c8377fe276bba9127c6a23d14->enter($__internal_c721078d6345c56879677bc8a45592f3d89b569c8377fe276bba9127c6a23d14_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_c721078d6345c56879677bc8a45592f3d89b569c8377fe276bba9127c6a23d14->leave($__internal_c721078d6345c56879677bc8a45592f3d89b569c8377fe276bba9127c6a23d14_prof);

    }

    // line 11
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_47616ee23577b58a1bf44c67b119ad9970caa851d93c8b6c0de911d4834052b2 = $this->env->getExtension("native_profiler");
        $__internal_47616ee23577b58a1bf44c67b119ad9970caa851d93c8b6c0de911d4834052b2->enter($__internal_47616ee23577b58a1bf44c67b119ad9970caa851d93c8b6c0de911d4834052b2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_47616ee23577b58a1bf44c67b119ad9970caa851d93c8b6c0de911d4834052b2->leave($__internal_47616ee23577b58a1bf44c67b119ad9970caa851d93c8b6c0de911d4834052b2_prof);

    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  93 => 11,  82 => 10,  71 => 6,  59 => 5,  50 => 12,  47 => 11,  45 => 10,  38 => 7,  36 => 6,  32 => 5,  26 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html>*/
/*     <head>*/
/*         <meta charset="UTF-8" />*/
/*         <title>{% block title %}Welcome!{% endblock %}</title>*/
/*         {% block stylesheets %}{% endblock %}*/
/*         <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />*/
/*     </head>*/
/*     <body>*/
/*         {% block body %}{% endblock %}*/
/*         {% block javascripts %}{% endblock %}*/
/*     </body>*/
/* </html>*/
/* */
