
{{Form::open(array('url'=>'users','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-label']) }}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter User Name'),'required'=>'required'))}}
                @error('name')
                <small class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('email',__('Email'),['class'=>'form-label'])}}
                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email'),'required'=>'required'))}}
                @error('email')
                <small class="invalid-email" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        @if(\Auth::user()->type != 'super admin')
            <div class="form-group col-md-6">
                {{ Form::label('role', __('User Role'),['class'=>'form-label']) }}
                {!! Form::select('role', $roles, null,array('class' => 'form-control select2','required'=>'required')) !!}
                @error('role')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>+
                </small>
                @enderror
            </div>
        @elseif(\Auth::user()->type == 'super admin')
            {!! Form::hidden('role', 'company', null,array('class' => 'form-control select2','required'=>'required')) !!}
        @endif
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('password',__('Password'),['class'=>'form-label'])}}
                {{Form::password('password',array('class'=>'form-control','placeholder'=>__('Enter User Password'),'required'=>'required','minlength'=>"6"))}}
                @error('password')
                <small class="invalid-password" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        @if(!$customFields->isEmpty())
            <div class="col-md-6">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    @include('customFields.formBuilder')
                </div>
            </div>
        @endif
        @if(\Auth::user()->type == 'super admin')

        <div  class="col-md-6 ">
            <div class="form-group ">
                {!! Form::label('gender', __('¿Qué desea crear?'),['class'=>'form-label']) !!}
                <div class="d-flex radio-check mt-2">
                    <div class="form-check form-check-inline form-group">
                        <input type="radio" id="yes" value="yes" name="gender" class="form-check-input">
                        <label class="form-check-label" for="yes">{{__('Crear usuario')}}</label>
                    </div>
                    <div class="form-check form-check-inline form-group">
                        <input type="radio" id="no" value="no" name="gender" class="form-check-input">
                        <label class="form-check-label" for="no">{{__('Crear empresa')}}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 form-group select">

        <!--<div class="col-md-6 " >-->
            <!--<div class="form-group">-->
                {{ Form::label('companies', __('Users'),['class'=>'form-label','id'=>'my-input']) }}

                <select  class="form-control select2" id="ms"  multiple name="companies[]" style="background:#6fd943 !important;" >
                    @foreach($companies as $company)
                        <option value="{{$company->name.'-'.$company->id}}">{{$company->name}}</option>
                    @endforeach
                </select>
                @error('companies')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            <!--</div>-->
        </div>
        @endif
    </div>

</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

<script>
    $(document).ready(function(){
        console.log('holaaaaaaaaaaaa');
        $(".select").hide();
        $("#yes").on("click",function(){
            $(".select").show();
            //$("#ms").attr("required","required"); 
        });
        $("#no").on("click",function(){
            $(".select").hide();
            //$("#ms").attr("required",""); 
        });
    });
</script>

