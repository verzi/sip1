<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* C:\xampp\htdocs\sip1\cronito\vendor\cakephp\bake\src\Template\Bake\Plugin\.gitignore.twig */
class __TwigTemplate_b088975c30eba7028c78d9e81ab2742561ccb5fdfe071d4509ad4395c5eb1043 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa = $this->env->getExtension("WyriHaximus\\TwigView\\Lib\\Twig\\Extension\\Profiler");
        $__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa->enter($__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "C:\\xampp\\htdocs\\sip1\\cronito\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Plugin\\.gitignore.twig"));

        // line 1
        echo "/composer.lock
/phpunit.xml
/vendor
";
        
        $__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa->leave($__internal_770edd655cdeb606afc443e4edb1f19b4248a91788cb82e88bf8b9495a7c5cfa_prof);

    }

    public function getTemplateName()
    {
        return "C:\\xampp\\htdocs\\sip1\\cronito\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Plugin\\.gitignore.twig";
    }

    public function getDebugInfo()
    {
        return array (  33 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("/composer.lock
/phpunit.xml
/vendor
", "C:\\xampp\\htdocs\\sip1\\cronito\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Plugin\\.gitignore.twig", "C:\\xampp\\htdocs\\sip1\\cronito\\vendor\\cakephp\\bake\\src\\Template\\Bake\\Plugin\\.gitignore.twig");
    }
}
