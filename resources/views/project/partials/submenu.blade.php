<div class="submenu">
    <div class="container">
        @if(Active::isControllerAction('ProjectController', 'show') || Active::isControllerAction('TimesheetController', 'index'))
            <h2>{{ $project->name }}</h2>
        @else
            <h2>{{ trans('dam.project.projects') }}</h2>
        @endif
        <ul class="menu">
            @if(Active::isControllerAction('ProjectController', 'show') || Active::isControllerAction('TimesheetController', 'index'))
                <li><a href="{{ URL::action('ProjectController@show', $project->id) }}" class="{{ Active::isControllerAction('ProjectController', 'show') }}">{{ trans('dam.general.overview') }}</a></li>
                <li><a href="{{ URL::action('TimesheetController@index', $project->id) }}" class="{{ Active::isControllerAction('TimesheetController', 'index') }}">{{ trans('dam.timesheet.timesheet') }}</a></li>
            @else
                <li><a href="{{ URL::action('ProjectController@index') }}" class="{{ Active::isControllerAction('ProjectController', 'index') }}">{{ trans('dam.general.overview') }}</a></li>
                <li><a href="{{ URL::action('ProjectController@archivedProjects')}}" class="{{ Active::isControllerAction('ProjectController', 'archivedProjects') }}">{{ trans('dam.general.archived') }}</a></li>
            @endif
        </ul>
        @if(Active::isControllerAction('ProjectController', 'index'))
        <ul class="right">
            <li><a href="{{ URL::action('ProjectController@create') }}" class="button -add">{{ trans('dam.project.new') }}</a></li>
        </ul>
        @elseif(Active::isControllerAction('ProjectController', 'show'))
        <ul class="right">
            @if($project->ongoing)
                <li><a href="#archive" class="button -archive" data-turbolinks="false">{{ trans('dam.project.archive') }}</a></li>
                <li><a href="{{ URL::action('ProjectController@edit', $project->id) }}" class="button -edit">{{ trans('dam.project.edit') }}</a></li>
            @endif
            <li><a href="#destroy" class="button -delete" data-turbolinks="false">{{ trans('dam.project.destroy') }}</a></li>
        </ul>
        @endif
    </div>
</div>
