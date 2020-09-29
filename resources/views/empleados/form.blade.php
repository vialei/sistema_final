
<div class="from-group">
<label for="Nombre" class="control-label">{{'Nombre'}}</label>
<input type="text" class="form-control {{$errors->has('Nombre')?' is-invalid':''}} "name="Nombre" id="Nombre" value="{{isset($empleado->Nombre)?$empleado->Nombre:old('Nombre')}}">
{!! $errors->first('Nombre','<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="from-group">
<label for="ApellidoPaterno" class="control-label">{{'Apellido Paterno'}}</label>
<input type="text" class="form-control {{$errors->has('ApellidoPaterno')?' is-invalid':''}}" name="ApellidoPaterno" id="ApellidoPaterno" value="{{isset($empleado->ApellidoPaterno)?$empleado->ApellidoPaterno:old('ApellidoPaterno')}}">
{!! $errors->first('ApellidoPaterno','<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="from-group">
<label for="ApellidoMaterno" class="control-label">{{'Apellido Materno'}}</label>
<input type="text" class="form-control {{$errors->has('ApellidoMaterno')?' is-invalid':''}}" name="ApellidoMaterno" id="ApellidoMaterno" value="{{isset($empleado->ApellidoMaterno)?$empleado->ApellidoMaterno:old('ApellidoMaterno')}}">
{!! $errors->first('ApellidoMaterno','<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="from-group">
<label for="Correo" class="control-label">{{'Correo'}}</label>
<input type="email" class="form-control {{$errors->has('Correo')?' is-invalid':''}}" name="Correo" id="Correo" value="{{isset($empleado->Correo)?$empleado->Correo:old('Correo')}}">
{!! $errors->first('Correo','<div class="invalid-feedback">:message</div>') !!}
</div>

<div class="from-group">
<label for="Foto" class="control-label">{{'Foto'}}</label>
<br/r>
@if(isset($empleado->Foto))
<img class="img-thumbnail img-fluid border-warning" src="{{ asset('storage').'/'.$empleado->Foto}}" alt="" width="200">   
@endif

<input class="form-control {{$errors->has('Foto')?' is-invalid':''}}" type="file"   name="Foto" id="Foto" value="">
{!! $errors->first('Foto','<div class="invalid-feedback">:message</div>') !!}
</div>
<br/r>
<input type="submit" class="btn btn-success" value="{{$Modo=='crear'?'Agregar empleado':'Modificar'}}">
<a  class="btn btn-primary" href="{{url('empleados')}}">Regresar</a>

