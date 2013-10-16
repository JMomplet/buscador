{{ form('index', 'method': 'post') }}
<label>Busqueda</label>
{{ text_field("search","size":120) }}
{{ submit_button('Buscar') }}
</form>

{% if tipo == "equipo" %}
    <h1>{{ equipo.nombre }}</h1>
    <p>{{ equipo.descripcion }}</p>
{% elseif tipo == "partidos" %}
    <ul>
        {% if partidos is iterable %}
            {% for partido in partidos %}
                {# Comprobamos cual de los 2 es el local #}
                {% if partido.local_id == equipo1.id %}
                    <li>{{ equipo1.nombre }} {{ partido.goles_local }}
                        - {{ partido.goles_visitante }} {{ equipo2.nombre }}</li>
                {% else %}
                    <li>{{ equipo2.nombre }} {{ partido.goles_local }}
                        - {{ partido.goles_visitante }} {{ equipo1.nombre }}</li>
                {% endif %}
            {% endfor %}
        {% endif %}
    </ul>
{% else %}
<h1>Sin resultados</h1>
{% endif %}