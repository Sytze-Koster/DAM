<div class="submenu">
    <div class="container">
        <h2>Projecten</h2>
        <ul>
            <li><a href="{{ URL::action('ProjectController@index') }}" class="{{ Active::isControllerAction('ProjectController', 'index') }}">Overzicht</a></li>
            <li><a href="{{ URL::action('ProjectController@create') }}"  class="{{ Active::isControllerAction('ProjectController', 'create') }}">Nieuw project</a></li>
        </ul>
        <ul class="right">
            <li><a href="#" class="button"><i class="fa fa-add"></i> New project</a></li>
        </ul>
    </div>
</div>
