  <div class="field">
    {{ Form::label('name', trans('dam.project.name')) }}
    {{ Form::text('name', null, ['placeholder' => trans('dam.project.name')]) }}
  </div>

  <div class="field">
    {{ Form::label('description', trans('dam.project.description')) }}
    {{ Form::text('description', null, ['placeholder' => trans('dam.project.description')]) }}
  </div>

  <div class="field">
    {{ Form::label('customer', trans('dam.project.customer')) }}
    {{ Form::select('customer_id', $customers, null, ['placeholder' => trans('dam.project.customer')])}}
  </div>

  <div class="field">
    {{ Form::label('notify_after', trans('dam.project.notify_after')) }}
    {{ Form::text('notify_after', null, ['placeholder' => trans('dam.project.notify_after')]) }}
  </div>

  {{ Form::button($buttonText, ['class' => 'button -go -right', 'type' => 'submit']) }}
