{% extends "layouts/default.volt" %}

{% block title %}{{ "Signup"|i18n }}{% endblock %}

{% block content %}
<div class="container main-container">
    <div class="span12">
        <div class="row-fluid">
            {{ form.render() }}
        </div>
        <!--/row-->
    </div><!--/span-->
</div>
{% endblock %}