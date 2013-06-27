<?php

/* GREReviewVocabBundle:Main:index.html.php */
class __TwigTemplate_9b031b37221961132b9ded58cebfb9e7 extends Twig_Template
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
        echo "<?php var_dump(\$view['assets']) ?>
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html>
  <head>
    <title>Bootstrap 101 Template</title>
    <!-- Bootstrap -->
    <link href=\"<?php echo \$view['assets']->getUrl('css/bootstrap.min.css') ?>\" rel=\"stylesheet\" type=\"text/css\" />
    <link href=\"css/bootstrap.min.css\" rel=\"stylesheet\">
  </head>
  <body>
    <h1>Hello, world!</h1>
    <script src=\"js/bootstrap.min.js\"></script>
  </body>
</html>";
    }

    public function getTemplateName()
    {
        return "GREReviewVocabBundle:Main:index.html.php";
    }

    public function getDebugInfo()
    {
        return array (  17 => 1,);
    }
}
