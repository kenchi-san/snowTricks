{% extends 'base.html.twig' %}

{% block title %}Hello FigureController!{% endblock %}

{% block body %}

{{ form_start(form) }}
{{ form_row(form) }}
<input class="btn btn-primary" type="submit" value="Valider">

{{ form_end(form) }}
{% endblock %}
