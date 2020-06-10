<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* default/index.html.twig */
class __TwigTemplate_a0ec6aeb93e095c169c4ab9fb6c7db168dadd180016961bf7167e8cf4cedf648 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'stylesheets' => [$this, 'block_stylesheets'],
            'body' => [$this, 'block_body'],
            'javascripts' => [$this, 'block_javascripts'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "default/index.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "default/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "default/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo "Hello DefaultController!";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 5
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 6
        echo "    <script src=\"js/jquery-3.4.1.min.js\"></script>
    <script src=\"js/popper.min.js\"></script>
    <link rel=\"stylesheet\" href=\"css/bootstrap.min.css\">
    <script src=\"js/bootstrap.min.js\"></script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 12
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 13
        echo "<nav class=\"navbar navbar-dark bg-dark\">
      <a class=\"navbar-brand\" href=\"#\">Point K</a>
      </button>

      <!-- <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
        <ul class=\"navbar-nav mr-auto\">
          <li class=\"nav-item active\">
            <a class=\"nav-link\" href=\"#\">Home <span class=\"sr-only\">(current)</span></a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"#\">Achats <span class=\"sr-only\">(current)</span></a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"#\">Commandes <span class=\"sr-only\">(current)</span></a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"#\">Utilisateurs <span class=\"sr-only\">(current)</span></a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"#\">Historique achats <span class=\"sr-only\">(current)</span></a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"#\">Compte <span class=\"sr-only\">(current)</span></a>
          </li>
        </ul>
      </div> -->
      <button class=\"btn btn-danger\">Déconnexion</button>
    </nav>

    <div class=\"container\">
      <div class=\"row\">
        <div class=\"col-md-6\">
          <div class=\"card m-4\">
            <div class=\"card-header\">Achats</div>
            <div class=\"card-body\" id=\"formHe\">
              <p class=\"card-text\">Produits disponibles :</p>
              <form method=\"post\" action=\"/\">
                <div class=\"form-row\">
                  <div class=\"col\">
                    <div class=\"input-group\">
                      <input class=\"form-control\" type=\"text\" value=\"Café\" readonly />
                      <input class=\"form-control tim\" type=\"text\" value=2 readonly />
                    </div>
                  </div>
                  <div class=\"col\">
                    <div class=\"input-group\">
                      <div class=\"input-group-prepend\">
                        <button class=\"btn btn-outline-danger moins\">-</button>
                      </div>
                      <input class=\"form-control nb\" type=\"text\" value=0 name=\"nCafe\" readonly />
                      <div class=\"input-group-append\">
                        <button class=\"btn btn-outline-success plus\">+</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class=\"form-row\">
                  <div class=\"col\">
                    <div class=\"input-group\">
                      <input class=\"form-control\" type=\"text\" value=\"Thé\" readonly />
                      <input class=\"form-control tim\" type=\"text\" value=0.5 readonly />
                    </div>
                  </div>
                  <div class=\"col\">
                    <div class=\"input-group\">
                      <div class=\"input-group-prepend\">
                        <button class=\"btn btn-outline-danger moins\">-</button>
                      </div>
                      <input class=\"form-control nb\" type=\"text\" value=0 name=\"nThe\" readonly />
                      <div class=\"input-group-append\">
                        <button class=\"btn btn-outline-success plus\">+</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class=\"input-group mt-3\">
                  <input class=\"form-control col\" type=\"text\" value=\"A payer\" readonly />
                  <input class=\"form-control col-3 total\" type=\"text\" value=0 readonly />
                </div>
                <center><input type=\"submit\" class=\"btn btn-primary mt-3\" value=\"Commander\" /></center>
              </form>
            </div>
          </div>
        </div>


        <div class=\"col-md-6\">
          <div class=\"card m-4\">
            <div class=\"card-header\">Commandes</div>
            <div class=\"card-body\" id=\"command\">
              <p class=\"card-text\">Commandes en cours :</p>
              <div class=\"input-group\">
                <input class=\"form-control\" type=\"text\" value=\"Commande 1\" disabled />
                <div class=\"input-group-append\">
                  <button class=\"btn btn-secondary modify\">Modifier</button>
                </div>
              </div>
              <div class=\"input-group\">
                <input class=\"form-control\" type=\"text\" value=\"Commande 2\" disabled />
                <div class=\"input-group-append\">
                  <button class=\"btn btn-secondary modify\">Modifier</button>
                </div>
              </div>

              <p class=\"card-text mt-4\">Commandes terminées :</p>
              <div class=\"input-group\">
                <input class=\"form-control\" type=\"text\" value=\"Commande 3\" disabled />
                <div class=\"input-group-append\">
                  <button class=\"btn btn-secondary affich\">Afficher</button>
                </div>
              </div>
              <div class=\"input-group\">
                <input class=\"form-control\" type=\"text\" value=\"Commande 4\" disabled />
                <div class=\"input-group-append\">
                  <button class=\"btn btn-secondary affich\">Afficher</button>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class=\"col-md-6\">
          <div class=\"card m-4\">
            <div class=\"card-header\">Utilisateur</div>
            <div class=\"card-body\">
              <div style=\"display: flex; justify-content: space-between;\" id=\"tab\">
                <div>Nom :</div>
                <div id=\"name\">Andy Swider</div>
              </div>
              <div style=\"display: flex; justify-content: space-between;\">
                <div>Compte restant :</div>
                <div style=\"color: green;\">3,50 Châtaignes</div>
              </div>

              <center><button class=\"btn btn-primary mt-3\" id=\"mod\">Modifier</button></center>
            </div>
          </div>
        </div>


        <div class=\"col-md-6\">
          <div class=\"card m-4\">
            <div class=\"card-header\">Four</div>
            <div class=\"card-body\">
              Find four
            </div>
          </div>
        </div>
      </div>
    </div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 167
    public function block_javascripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        // line 168
        echo "    <script type=\"text/javascript\">
      var x = \$(\"#command\")[0].childNodes;
      var y = [];
      for (var i = 0; i < x.length; i++) {
        y.push(x[i].cloneNode(true));
      }
      const z = y;
      \$(\".moins\").click(function(e) {
        var targ = e.target.parentNode.nextElementSibling;
        if (targ.value > 0) targ.value--;
        var formHe = \$(\"#formHe\")[0];
        var table = formHe.lastElementChild.childNodes;
        var tableEl = [];
        for (var i = 0; i < table.length; i++) {
          if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
        }
        var tot = 0;
        for (var i = 0; i < tableEl.length - 1; i++) {
          var a = tableEl[i].firstElementChild.firstElementChild;
          a = a.lastElementChild.value;
          var b = tableEl[i].lastElementChild.firstElementChild;
          b = b.firstElementChild.nextElementSibling.value;
          tot += a * b;
        }
        var c = tableEl[tableEl.length - 1].lastElementChild;
        c.value = tot;
        e.preventDefault();
      });

      \$(\".plus\").click(function(e) {
        var targ = e.target.parentNode.previousElementSibling;
        targ.value++;
        var formHe = \$(\"#formHe\")[0];
        var table = formHe.lastElementChild.childNodes;
        var tableEl = [];
        for (var i = 0; i < table.length; i++) {
          if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
        }
        var tot = 0;
        for (var i = 0; i < tableEl.length - 1; i++) {
          var a = tableEl[i].firstElementChild.firstElementChild;
          a = a.lastElementChild.value;
          var b = tableEl[i].lastElementChild.firstElementChild;
          b = b.firstElementChild.nextElementSibling.value;
          tot += a * b;
        }
        var c = tableEl[tableEl.length - 1].lastElementChild;
        c.value = tot;
        e.preventDefault();
      });

      \$(\"#mod\").click(function() {
        var a, v;
        if (\$(\"#name\")[0].nodeName == 'DIV') {
          a = document.createElement('input');
          v = \$(\"#name\")[0].innerHTML;
          a.id = 'name';
          a.value = v;
          a.setAttribute('class', \"form-control col-sm-6\");
        } else {
          a = document.createElement('div');
          v = \$(\"#name\")[0].value;
          a.id = \"name\";
          a.innerHTML = v;
        }
        \$(\"#tab\")[0].removeChild(\$(\"#name\")[0]);
        \$(\"#tab\")[0].appendChild(a);
      });

      \$(\".modify\").click(function(e) {
        var targ = e.target.parentNode.previousElementSibling;
        var a = \$(\"#formHe\")[0].cloneNode(true);
        a.setAttribute('class', '')
        a.id = \"formCom\";
        a.firstElementChild.innerHTML = targ.value;
        var chil = a.lastElementChild.childNodes;
        var chilDiv = [];

        for (var i = 0; i < chil.length; i++)
          if (chil[i].nodeName == 'DIV') chilDiv.push(chil[i]);
        chilDiv.pop();

        var cha = {
          \"Commande 1\": [3, 1],
          \"Commande 2\": [2, 2],
        };
        
        for (var i = chilDiv.length - 1; i >= 0; i--) {
          var val = chilDiv[i].lastElementChild;
          val = val.firstElementChild;
          val.setAttribute('class', 'input-group inCom');
          val = val.firstElementChild.nextElementSibling;

          val.value = cha[targ.value][i];
        }

        var com = \$(\"#command\")[0];
        while (com.childNodes.length > 0)
          com.removeChild(com.firstChild);

        com.appendChild(a);

        var tot = 0;
        var formCom = \$(\"#formCom\")[0];
        var table = formCom.lastElementChild.childNodes;
        var tableEl = [];
        for (var i = 0; i < table.length; i++) {
          if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
        }
        var tot = 0;
        for (var i = 0; i < tableEl.length - 1; i++) {
          var a = tableEl[i].firstElementChild.firstElementChild;
          a = a.lastElementChild.value;
          var b = tableEl[i].lastElementChild.firstElementChild;
          b = b.firstElementChild.nextElementSibling.value;
          tot += a * b;
        }
        var c = tableEl[tableEl.length - 1].lastElementChild;
        c.value = tot;
        var i = table[table.length - 2].firstElementChild;
        i.value = \"Modifier\";

        \$(\".inCom div .moins\").click(function(e) {
          var targ = e.target.parentNode.nextElementSibling;
          if (targ.value > 0) targ.value--;
          var formCom = \$(\"#formCom\")[0];
          var table = formCom.lastElementChild.childNodes;
          var tableEl = [];
          for (var i = 0; i < table.length; i++) {
            if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
          }
          var tot = 0;
          for (var i = 0; i < tableEl.length - 1; i++) {
            var a = tableEl[i].firstElementChild.firstElementChild;
            a = a.lastElementChild.value;
            var b = tableEl[i].lastElementChild.firstElementChild;
            b = b.firstElementChild.nextElementSibling.value;
            tot += a * b;
          }
          var c = tableEl[tableEl.length - 1].lastElementChild;
          c.value = tot;
          e.preventDefault();
        });

        \$(\".inCom div .plus\").click(function(e) {
          var targ = e.target.parentNode.previousElementSibling;
          targ.value++;
          var formCom = \$(\"#formCom\")[0];
          var table = formCom.lastElementChild.childNodes;
          var tableEl = [];
          for (var i = 0; i < table.length; i++) {
            if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
          }
          var tot = 0;
          for (var i = 0; i < tableEl.length - 1; i++) {
            var a = tableEl[i].firstElementChild.firstElementChild;
            a = a.lastElementChild.value;
            var b = tableEl[i].lastElementChild.firstElementChild;
            b = b.firstElementChild.nextElementSibling.value;
            tot += a * b;
          }
          var c = tableEl[tableEl.length - 1].lastElementChild;
          c.value = tot;
          e.preventDefault();
        });

        e.preventDefault();
      });

      \$(\".affich\").click(function(e) {
        var targ = e.target.parentNode.previousElementSibling;
        var a = \$(\"#formHe\")[0].cloneNode(true);
        a.setAttribute('class', '')
        a.id = \"formCom\"
        a.firstElementChild.innerHTML = targ.value;
        var chil = a.lastElementChild.childNodes;
        var chilDiv = [];

        for (var i = 0; i < chil.length; i++)
          if (chil[i].nodeName == 'DIV') chilDiv.push(chil[i]);
        chilDiv.pop();

        var cha = {
          \"Commande 3\": [1, 3],
          \"Commande 4\": [2, 0],
        };
        
        for (var i = chilDiv.length - 1; i >= 0; i--) {
          var val = chilDiv[i].lastElementChild;
          val = val.firstElementChild;
          val.setAttribute('class', 'input-group inCom');
          val = val.firstElementChild.nextElementSibling;

          val.value = cha[targ.value][i];
        }

        var com = \$(\"#command\")[0];
        while (com.childNodes.length > 0)
          com.removeChild(com.firstChild);

        com.appendChild(a);

        var tot = 0;
        var formCom = \$(\"#formCom\")[0];
        var table = formCom.lastElementChild.childNodes;
        var tableEl = [];
        for (var i = 0; i < table.length; i++) {
          if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
        }
        var tot = 0;
        for (var i = 0; i < tableEl.length - 1; i++) {
          var a = tableEl[i].firstElementChild.firstElementChild;
          a = a.lastElementChild.value;
          var b = tableEl[i].lastElementChild.firstElementChild;
          b = b.firstElementChild.nextElementSibling.value;
          tot += a * b;
        }
        var c = tableEl[tableEl.length - 1].lastElementChild;
        c.value = tot;
        var i = table[table.length - 2];
        i.parentNode.removeChild(i);

        for (var i = \$(\".inCom div .moins\").length - 1; i >= 0; i--)
          \$(\".inCom div .moins\")[i].disabled = true;

        for (var i = \$(\".inCom div .plus\").length - 1; i >= 0; i--)
          \$(\".inCom div .plus\")[i].disabled = true;
        
        e.preventDefault();
      });
    </script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "default/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  286 => 168,  276 => 167,  114 => 13,  104 => 12,  90 => 6,  80 => 5,  61 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Hello DefaultController!{% endblock %}

{% block stylesheets %}
    <script src=\"js/jquery-3.4.1.min.js\"></script>
    <script src=\"js/popper.min.js\"></script>
    <link rel=\"stylesheet\" href=\"css/bootstrap.min.css\">
    <script src=\"js/bootstrap.min.js\"></script>
{% endblock %}

{% block body %}
<nav class=\"navbar navbar-dark bg-dark\">
      <a class=\"navbar-brand\" href=\"#\">Point K</a>
      </button>

      <!-- <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
        <ul class=\"navbar-nav mr-auto\">
          <li class=\"nav-item active\">
            <a class=\"nav-link\" href=\"#\">Home <span class=\"sr-only\">(current)</span></a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"#\">Achats <span class=\"sr-only\">(current)</span></a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"#\">Commandes <span class=\"sr-only\">(current)</span></a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"#\">Utilisateurs <span class=\"sr-only\">(current)</span></a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"#\">Historique achats <span class=\"sr-only\">(current)</span></a>
          </li>
          <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"#\">Compte <span class=\"sr-only\">(current)</span></a>
          </li>
        </ul>
      </div> -->
      <button class=\"btn btn-danger\">Déconnexion</button>
    </nav>

    <div class=\"container\">
      <div class=\"row\">
        <div class=\"col-md-6\">
          <div class=\"card m-4\">
            <div class=\"card-header\">Achats</div>
            <div class=\"card-body\" id=\"formHe\">
              <p class=\"card-text\">Produits disponibles :</p>
              <form method=\"post\" action=\"/\">
                <div class=\"form-row\">
                  <div class=\"col\">
                    <div class=\"input-group\">
                      <input class=\"form-control\" type=\"text\" value=\"Café\" readonly />
                      <input class=\"form-control tim\" type=\"text\" value=2 readonly />
                    </div>
                  </div>
                  <div class=\"col\">
                    <div class=\"input-group\">
                      <div class=\"input-group-prepend\">
                        <button class=\"btn btn-outline-danger moins\">-</button>
                      </div>
                      <input class=\"form-control nb\" type=\"text\" value=0 name=\"nCafe\" readonly />
                      <div class=\"input-group-append\">
                        <button class=\"btn btn-outline-success plus\">+</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class=\"form-row\">
                  <div class=\"col\">
                    <div class=\"input-group\">
                      <input class=\"form-control\" type=\"text\" value=\"Thé\" readonly />
                      <input class=\"form-control tim\" type=\"text\" value=0.5 readonly />
                    </div>
                  </div>
                  <div class=\"col\">
                    <div class=\"input-group\">
                      <div class=\"input-group-prepend\">
                        <button class=\"btn btn-outline-danger moins\">-</button>
                      </div>
                      <input class=\"form-control nb\" type=\"text\" value=0 name=\"nThe\" readonly />
                      <div class=\"input-group-append\">
                        <button class=\"btn btn-outline-success plus\">+</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class=\"input-group mt-3\">
                  <input class=\"form-control col\" type=\"text\" value=\"A payer\" readonly />
                  <input class=\"form-control col-3 total\" type=\"text\" value=0 readonly />
                </div>
                <center><input type=\"submit\" class=\"btn btn-primary mt-3\" value=\"Commander\" /></center>
              </form>
            </div>
          </div>
        </div>


        <div class=\"col-md-6\">
          <div class=\"card m-4\">
            <div class=\"card-header\">Commandes</div>
            <div class=\"card-body\" id=\"command\">
              <p class=\"card-text\">Commandes en cours :</p>
              <div class=\"input-group\">
                <input class=\"form-control\" type=\"text\" value=\"Commande 1\" disabled />
                <div class=\"input-group-append\">
                  <button class=\"btn btn-secondary modify\">Modifier</button>
                </div>
              </div>
              <div class=\"input-group\">
                <input class=\"form-control\" type=\"text\" value=\"Commande 2\" disabled />
                <div class=\"input-group-append\">
                  <button class=\"btn btn-secondary modify\">Modifier</button>
                </div>
              </div>

              <p class=\"card-text mt-4\">Commandes terminées :</p>
              <div class=\"input-group\">
                <input class=\"form-control\" type=\"text\" value=\"Commande 3\" disabled />
                <div class=\"input-group-append\">
                  <button class=\"btn btn-secondary affich\">Afficher</button>
                </div>
              </div>
              <div class=\"input-group\">
                <input class=\"form-control\" type=\"text\" value=\"Commande 4\" disabled />
                <div class=\"input-group-append\">
                  <button class=\"btn btn-secondary affich\">Afficher</button>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class=\"col-md-6\">
          <div class=\"card m-4\">
            <div class=\"card-header\">Utilisateur</div>
            <div class=\"card-body\">
              <div style=\"display: flex; justify-content: space-between;\" id=\"tab\">
                <div>Nom :</div>
                <div id=\"name\">Andy Swider</div>
              </div>
              <div style=\"display: flex; justify-content: space-between;\">
                <div>Compte restant :</div>
                <div style=\"color: green;\">3,50 Châtaignes</div>
              </div>

              <center><button class=\"btn btn-primary mt-3\" id=\"mod\">Modifier</button></center>
            </div>
          </div>
        </div>


        <div class=\"col-md-6\">
          <div class=\"card m-4\">
            <div class=\"card-header\">Four</div>
            <div class=\"card-body\">
              Find four
            </div>
          </div>
        </div>
      </div>
    </div>
{% endblock %}

{% block javascripts %}
    <script type=\"text/javascript\">
      var x = \$(\"#command\")[0].childNodes;
      var y = [];
      for (var i = 0; i < x.length; i++) {
        y.push(x[i].cloneNode(true));
      }
      const z = y;
      \$(\".moins\").click(function(e) {
        var targ = e.target.parentNode.nextElementSibling;
        if (targ.value > 0) targ.value--;
        var formHe = \$(\"#formHe\")[0];
        var table = formHe.lastElementChild.childNodes;
        var tableEl = [];
        for (var i = 0; i < table.length; i++) {
          if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
        }
        var tot = 0;
        for (var i = 0; i < tableEl.length - 1; i++) {
          var a = tableEl[i].firstElementChild.firstElementChild;
          a = a.lastElementChild.value;
          var b = tableEl[i].lastElementChild.firstElementChild;
          b = b.firstElementChild.nextElementSibling.value;
          tot += a * b;
        }
        var c = tableEl[tableEl.length - 1].lastElementChild;
        c.value = tot;
        e.preventDefault();
      });

      \$(\".plus\").click(function(e) {
        var targ = e.target.parentNode.previousElementSibling;
        targ.value++;
        var formHe = \$(\"#formHe\")[0];
        var table = formHe.lastElementChild.childNodes;
        var tableEl = [];
        for (var i = 0; i < table.length; i++) {
          if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
        }
        var tot = 0;
        for (var i = 0; i < tableEl.length - 1; i++) {
          var a = tableEl[i].firstElementChild.firstElementChild;
          a = a.lastElementChild.value;
          var b = tableEl[i].lastElementChild.firstElementChild;
          b = b.firstElementChild.nextElementSibling.value;
          tot += a * b;
        }
        var c = tableEl[tableEl.length - 1].lastElementChild;
        c.value = tot;
        e.preventDefault();
      });

      \$(\"#mod\").click(function() {
        var a, v;
        if (\$(\"#name\")[0].nodeName == 'DIV') {
          a = document.createElement('input');
          v = \$(\"#name\")[0].innerHTML;
          a.id = 'name';
          a.value = v;
          a.setAttribute('class', \"form-control col-sm-6\");
        } else {
          a = document.createElement('div');
          v = \$(\"#name\")[0].value;
          a.id = \"name\";
          a.innerHTML = v;
        }
        \$(\"#tab\")[0].removeChild(\$(\"#name\")[0]);
        \$(\"#tab\")[0].appendChild(a);
      });

      \$(\".modify\").click(function(e) {
        var targ = e.target.parentNode.previousElementSibling;
        var a = \$(\"#formHe\")[0].cloneNode(true);
        a.setAttribute('class', '')
        a.id = \"formCom\";
        a.firstElementChild.innerHTML = targ.value;
        var chil = a.lastElementChild.childNodes;
        var chilDiv = [];

        for (var i = 0; i < chil.length; i++)
          if (chil[i].nodeName == 'DIV') chilDiv.push(chil[i]);
        chilDiv.pop();

        var cha = {
          \"Commande 1\": [3, 1],
          \"Commande 2\": [2, 2],
        };
        
        for (var i = chilDiv.length - 1; i >= 0; i--) {
          var val = chilDiv[i].lastElementChild;
          val = val.firstElementChild;
          val.setAttribute('class', 'input-group inCom');
          val = val.firstElementChild.nextElementSibling;

          val.value = cha[targ.value][i];
        }

        var com = \$(\"#command\")[0];
        while (com.childNodes.length > 0)
          com.removeChild(com.firstChild);

        com.appendChild(a);

        var tot = 0;
        var formCom = \$(\"#formCom\")[0];
        var table = formCom.lastElementChild.childNodes;
        var tableEl = [];
        for (var i = 0; i < table.length; i++) {
          if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
        }
        var tot = 0;
        for (var i = 0; i < tableEl.length - 1; i++) {
          var a = tableEl[i].firstElementChild.firstElementChild;
          a = a.lastElementChild.value;
          var b = tableEl[i].lastElementChild.firstElementChild;
          b = b.firstElementChild.nextElementSibling.value;
          tot += a * b;
        }
        var c = tableEl[tableEl.length - 1].lastElementChild;
        c.value = tot;
        var i = table[table.length - 2].firstElementChild;
        i.value = \"Modifier\";

        \$(\".inCom div .moins\").click(function(e) {
          var targ = e.target.parentNode.nextElementSibling;
          if (targ.value > 0) targ.value--;
          var formCom = \$(\"#formCom\")[0];
          var table = formCom.lastElementChild.childNodes;
          var tableEl = [];
          for (var i = 0; i < table.length; i++) {
            if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
          }
          var tot = 0;
          for (var i = 0; i < tableEl.length - 1; i++) {
            var a = tableEl[i].firstElementChild.firstElementChild;
            a = a.lastElementChild.value;
            var b = tableEl[i].lastElementChild.firstElementChild;
            b = b.firstElementChild.nextElementSibling.value;
            tot += a * b;
          }
          var c = tableEl[tableEl.length - 1].lastElementChild;
          c.value = tot;
          e.preventDefault();
        });

        \$(\".inCom div .plus\").click(function(e) {
          var targ = e.target.parentNode.previousElementSibling;
          targ.value++;
          var formCom = \$(\"#formCom\")[0];
          var table = formCom.lastElementChild.childNodes;
          var tableEl = [];
          for (var i = 0; i < table.length; i++) {
            if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
          }
          var tot = 0;
          for (var i = 0; i < tableEl.length - 1; i++) {
            var a = tableEl[i].firstElementChild.firstElementChild;
            a = a.lastElementChild.value;
            var b = tableEl[i].lastElementChild.firstElementChild;
            b = b.firstElementChild.nextElementSibling.value;
            tot += a * b;
          }
          var c = tableEl[tableEl.length - 1].lastElementChild;
          c.value = tot;
          e.preventDefault();
        });

        e.preventDefault();
      });

      \$(\".affich\").click(function(e) {
        var targ = e.target.parentNode.previousElementSibling;
        var a = \$(\"#formHe\")[0].cloneNode(true);
        a.setAttribute('class', '')
        a.id = \"formCom\"
        a.firstElementChild.innerHTML = targ.value;
        var chil = a.lastElementChild.childNodes;
        var chilDiv = [];

        for (var i = 0; i < chil.length; i++)
          if (chil[i].nodeName == 'DIV') chilDiv.push(chil[i]);
        chilDiv.pop();

        var cha = {
          \"Commande 3\": [1, 3],
          \"Commande 4\": [2, 0],
        };
        
        for (var i = chilDiv.length - 1; i >= 0; i--) {
          var val = chilDiv[i].lastElementChild;
          val = val.firstElementChild;
          val.setAttribute('class', 'input-group inCom');
          val = val.firstElementChild.nextElementSibling;

          val.value = cha[targ.value][i];
        }

        var com = \$(\"#command\")[0];
        while (com.childNodes.length > 0)
          com.removeChild(com.firstChild);

        com.appendChild(a);

        var tot = 0;
        var formCom = \$(\"#formCom\")[0];
        var table = formCom.lastElementChild.childNodes;
        var tableEl = [];
        for (var i = 0; i < table.length; i++) {
          if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
        }
        var tot = 0;
        for (var i = 0; i < tableEl.length - 1; i++) {
          var a = tableEl[i].firstElementChild.firstElementChild;
          a = a.lastElementChild.value;
          var b = tableEl[i].lastElementChild.firstElementChild;
          b = b.firstElementChild.nextElementSibling.value;
          tot += a * b;
        }
        var c = tableEl[tableEl.length - 1].lastElementChild;
        c.value = tot;
        var i = table[table.length - 2];
        i.parentNode.removeChild(i);

        for (var i = \$(\".inCom div .moins\").length - 1; i >= 0; i--)
          \$(\".inCom div .moins\")[i].disabled = true;

        for (var i = \$(\".inCom div .plus\").length - 1; i >= 0; i--)
          \$(\".inCom div .plus\")[i].disabled = true;
        
        e.preventDefault();
      });
    </script>
{% endblock %}
", "default/index.html.twig", "C:\\wamp64\\www\\PointK\\templates\\default\\index.html.twig");
    }
}
