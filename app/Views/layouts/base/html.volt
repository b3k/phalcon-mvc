<!DOCTYPE html>
<html>
	<head>
		<title>{% block title %}{% endblock %}</title>
		<link href="//netdna.bootstrapcdn.com/bootswatch/2.3.1/united/bootstrap.min.css" rel="stylesheet">
		{{ stylesheet_link('css/style.css') }}
                {{ assets.outputCss() }}
	</head>
	<body>
                <!-- header begin -->
                {% block header %}{% endblock %}
                <!-- header end -->

                <!-- content begin -->
		{% block content %}{% endblock %}
                <!-- content end -->

                <!-- footer begin -->
                {% block footer %}{% endblock %}
                <!-- footer end -->

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
	</body>
</html>