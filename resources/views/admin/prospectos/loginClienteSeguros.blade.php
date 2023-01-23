<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Encuesta de satisfacción</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    
</head>
<style>
    .cardForm{
        border: 2px;
        border-style: none none none solid;
        border-color: #9e969a;
        box-shadow: 5px 5px lightslategray; 
    }
    .container{
        display: flex;
        align-items: center;
        min-height: 100vh;
    }
    body{
        background-image: url(img/fondo3.jpeg);
        background-blend-mode: multiply;
        background-position: center;
        background-size: cover;
        
        
    }
    body:before{
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        top: 0;
        background: rgba(0,0,0,0.29);
    }
    em{
        margin-top: 0;
        color: red;
        font-size: 13px;
    }
</style>
<body>
    <div class="container">
        <div class="card">
            @if (\Session::has('mensaje'))
                {{-- <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('mensaje') !!}</li>
                    </ul>
                </div> --}}
               
                <div class="card-body text-center">
                    <div class="row p-4 my-7 ml-5">
                        <div class="col-md-11">
                            <div class="card-body">
                            <div class="text-center">
                                <div class="flex">
                                    <img class="rounded-circle mx-auto d-block m-2 logo" style="width: 25%;" src="{{ asset('img/lobo1.jpg') }}" alt="Logo">
                                    <h5 class="card-title my-3">Registro Exitoso</h5>
                                </div>
                                <p class="card-text mx-5">Tus datos han sido enviado correctamente, pronto procederemos ha revisar tu solicitud y enviarte una respuesta</p>
                                <p class="card-text"><small class="text-muted">¡Gracias por confiar en CFOWOLF!</small></p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            @else
            <form id="form_solicitud" method="POST" action="#" data-action="{{ route('listadoEncuestas') }}" enctype="multipart/form-data"  autocomplete="off">
                @csrf
                <div class="row no-gutters">
                    <div class="col-md-6 ml-5" id="form1" style="display: block">
                        <div class="card p-2 my-5 cardForm">
                            <p>1.- ¿Cuál es tu nombre? *</p>
                            <input type="text" class="form-control text-uppercase" id="txt_nombre" name="txt_nombre" placeholder="Escribe aquí tu respuesta"><br>
                            <p>2.- ¿Cuál es tu apellido Paterno? *</p>
                            <input type="text" class="form-control text-uppercase" id="txt_apellido_paterno" name="txt_apellido_paterno" placeholder="Escribe aquí tu respuesta"><br>
                            <p>3.- ¿Cuál es tu apellido Materno? </p>
                            <input type="text" class="form-control text-uppercase" id="txt_apellido_materno" name="txt_apellido_materno" placeholder="Escribe aquí tu respuesta"><br>
                            <a href="#" type="button" class="btn btn-info text-white font-bold w-full rounded shadow p-1 mt-3 send" onclick="siguientePregunta('1')">Siguiente</a>
                        </div>
                    </div>
                    <div class="col-md-6 ml-5" id="form2" style="display: none">
                        <div class="card p-2 my-5 cardForm">
                            <p>4.- ¿Cuál es tu Fecha de Nacimiento? *</p>
                            <input type="hidden" id="txt_edad" name="txt_edad" value="">
                            <input type="text" id="txt_fecha_nac" name="txt_fecha_nac" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" placeholder="dd/mm/yyyy"><br>                            
                           
                            <p>5.- ¿Cuál es tu Genero? *</p>
                            <select name="txt_genero" id="txt_genero" class="custom-select" required>
                                <option value="x" selected disabled>ELIJA UNA OPCIÓN</option>
                                <option value="M">MASCULINO</option>
                                <option value="F">FEMENINO</option>
                                <option value="x">INDISTINTO</option>
                            </select>
                           
                            <a href="#" type="button" class="btn btn-info text-white font-bold w-full rounded shadow p-1 mt-3 send" onclick="siguientePregunta('2')">Siguiente</a>
                        </div>  
                    </div>
                    <div class="col-md-6 ml-5" id="form3" style="display: none">
                        <div class="card p-2 my-5 cardForm">
                            <p>6.- ¿Cuál es tu Estado de Nacimiento? *</p>
                            <select type="select" id="txt_estado_nacimiento" name="txt_estado_nacimiento" class="form-control @error('state') is-invalid @enderror" required onchange="btGenCurp(this.form, '3');">
                                <option value="">Selecciona</option>
                                @foreach($estados_nac as $estados)
                                    <option {{ old('txt_estado_nacimiento') == $estados->clave ? 'selected' : '' }} value="{{$estados->clave}}">{{$estados->nombre}}</option>
                                @endforeach
                            </select><br>

                            <p>7.- ¿Cuál es tu Curp? *</p>
                            <input type="text" id="txt_curp" name="txt_curp" class="form-control text-uppercase" placeholder="Escribe aquí tu respuesta" maxlength="18"><br>                            
                            <p>8.- ¿Cuál es tu Teléfono? *</p>
                            <input type="text" id="txt_celular" name="txt_celular" class="form-control" placeholder="(999) 999-9999" data-inputmask='"mask": "(999) 999-9999"' data-mask><br>
                            <a href="#" type="button" class="btn btn-info text-white font-bold w-full rounded shadow p-1 mt-3 send" onclick="siguientePregunta('3')">Siguiente</a>
                        </div>  
                    </div>
                    <div class="col-md-6 ml-5" id="form4" style="display: none">
                        <div class="card p-2 my-5 cardForm">
                            <p>9.- ¿Cuál es tu Dirección? *</p>
                            <input type="text" class="form-control text-uppercase" id="direccion" name="direccion" placeholder="Escribe aquí tu respuesta"><br>
                            <p>10.- ¿Fecha Visa? *</p>
                            <input type="date" id="txt_fecha_visa" name="txt_fecha_visa" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" placeholder="dd/mm/yyyy"><br>                            
                            
                            <p>11.- Nacionalidad *</p>
                            <input type="text" class="form-control text-uppercase" id="nacionalidad" name="nacionalidad" placeholder="Escribe aquí tu respuesta"><br>
                            
                            <a href="#" type="button" class="btn btn-info text-white font-bold w-full rounded shadow p-1 mt-3 send" onclick="siguientePregunta('4')">Siguiente</a>
                        </div>  
                    </div>
                    <div class="col-md-6 ml-5" id="form5" style="display: none">
                        <div class="card p-2 my-5 cardForm">
                            <p>12.- ¿Cuál es tu Codigo Postal? *</p>
                            <input type="text" id="txt_codigo_postal" name="txt_codigo_postal" class="form-control" placeholder="Codigo Postal"><br>
                            <p>13.- Elige tu Colonia *</p>
                            <select name="txt_colonia" id="txt_colonia" class="form-control text-uppercase theSuburbs" required>
                                <option value=""> - </option>
                            </select><br>
                            <p>14.- Elige tu supervisor *</p>
                            <select type="select" id="txt_supervisor" name="txt_supervisor" class="form-control select2 " required>
                                <option value="">Selecciona</option>
                                @foreach($personals as $person)
                                    <option {{ old('txt_supervisor') == $person->id ? 'selected' : '' }} value="{{$person->id}}">{{$person->getFullname()}}</option>
                                @endforeach
                            </select><br>
                            <input type="hidden" id="txt_ciudad" name="txt_ciudad" value="">
                            <input type="hidden" id="txt_estado" name="txt_estado" value="">
                            <a href="#" type="button" class="btn btn-info text-white font-bold w-full rounded shadow p-1 mt-3 send" onclick="siguientePregunta('5')">Siguiente</a>

                        </div>  
                    </div>
                    <div class="col-md-6 ml-5" id="form6" style="display: none">
                        <div class="card p-2 my-5 cardForm">
                            <h6>DATOS DEL BENEFICIARIO </h6>
                            <p>15.- ¿Cual es su nombre? *</p>
                            <input type="text" id="nombre_beneficiario" name="nombre_beneficiario" class="form-control text-uppercase" placeholder="Nombre(s)"><br>
                            <p>16.- ¿Cual es su apellido paterno? *</p>
                            <input type="text" id="apellido_pat_bene" name="apellido_pat_bene" class="form-control text-uppercase" placeholder="Apellido Paterno"><br>
                            <p>17.- ¿Cual es su apellido materno? *</p>
                            <input type="text" id="apellido_mat_bene" name="apellido_mat_bene" class="form-control text-uppercase" placeholder="Apellido Materno"><br>
                            <p>18.- Parentesco *</p>
                            <select class="form-control" id="txt_parentesco_ref" name="txt_parentesco_ref">
                                <option>-- Elíge --</option>
                                <option>HIJO(A)</option>
                                <option>PADRE</option>
                                <option>MADRE</option>
                                <option>ESPOSO(A)</option>
                                <option>HERMANO(A)</option>
                                <option>ABUELO(A)</option>
                                <option>NIETO(A)</option>
                                <option>SOBRINO(A)</option>
                                <option>YERNO</option>
                                <option>NUERA</option>
                                <option>CUÑADO(A)</option>
                                <option>TIO(A)</option>
                                <option>PRIMO(A)</option>
                                <option>CONOCIDO(A)</option>
                            </select><br>
                           
                            <button type="submit" class="btn btn-info text-white font-bold w-full rounded shadow p-1 mt-3 send">Terminar</button>
                        </div>  
                    </div>
                    <div class="col-md-5">
                        <div class="card-body">
                        <div class="text-center">
                            <div class="flex">
                                <img class="rounded-circle mx-auto d-block m-2 logo" style="width: 25%;" src="{{ asset('img/lobo1.jpg') }}" alt="Logo">
                                <h5 class="card-title my-3">BIENVENIDO</h5>
                            </div>
                            <p class="card-text mx-5">Con el fin de mejorar nuestra atención, podras realizar tu solicitud por este medio, esperamos que puedas responderla de la manera más sincera posible.</p>
                            <p class="card-text"><small class="text-muted">¡Gracias por confiar en RED DE APOYO BINACIONAL!</small></p>
                        </div>
                        </div>
                    </div>
                </div>
            </form>
            
            @endif
        </div>
    </div>
</body>
</html>

{{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script> --}}
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="{{ asset('scripts/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('scripts/js/curp.js') }}"></script>

<script>


// function saveResp(){
//     var datos = $("#form_solicitud").serialize();
//     $.ajax({
//         url: "{{ asset('encuesta-de-satisfaccion') }}",
//         type: "post",
//         data: datos,
//         cache: false,
//         processData: false,
//         beforeSend: function (){
//             // $("#rsulbusqueda").hide();
//             // $("#loading").html("Procesando, espere por favor... <img src='public/img/loader.gif'>");
//         },
//         success: function(data){
//              console.log(data);
            
//              alert('sii entra aqui');

//             // if(data->step == 'step1' ){
//             //     $("#step1").hide(1000);
//             //     $("#step2").slideDown('slow');

//             // }
//         }
//     });
    
// }
    

$('[data-mask]').inputmask();
$('#txt_fecha_nac').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
$('#txt_fecha_visa').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })

$(function(){
    $('#txt_fecha_nac').on('change', calcularEdad);
});
        
function calcularEdad(){
    var fecha=document.getElementById("txt_fecha_nac").value;
    var values=fecha.split("/");
    var dia = values[0];
    var mes = values[1];
    var ano = values[2];
    fecha=	dia+"/"+mes	+"/"+ano;
    var values=fecha.split("/");
    var dia = values[0];
    var mes = values[1];
    var ano = values[2];
    var fecha_hoy = new Date();
    var ahora_ano = fecha_hoy.getYear();
    var ahora_mes = fecha_hoy.getMonth();
    var ahora_dia = fecha_hoy.getDate();

    // realizamos el calculo
    var edad = (ahora_ano + 1900) - ano;

    if ( ahora_mes < (mes - 1)){
        edad--;
    }
    if (((mes - 1) == ahora_mes) && (ahora_dia < dia)){
        edad--;
    }
    if (edad > 1900){
        edad -= 1900;
    }
    $('#txt_edad').val(edad);
}

function siguientePregunta(step) {
    if(step == "1"){
        document.getElementById('form1').style.display='none'; ///ocultar
        document.getElementById('form2').style.display='block'; ///mostrar
        document.getElementById('form3').style.display='none'; ///ocultar
        document.getElementById('form4').style.display='none'; ///ocultar
        document.getElementById('form5').style.display='none'; ///ocultar
        document.getElementById('form6').style.display='none'; ///ocultar
    }
    if(step == "2"){
        document.getElementById('form1').style.display='none';
        document.getElementById('form2').style.display='none';
        document.getElementById('form3').style.display='block';
        document.getElementById('form4').style.display='none';
        document.getElementById('form5').style.display='none';
        document.getElementById('form6').style.display='none';
    }
    if(step == "3"){
        document.getElementById('form1').style.display='none';
        document.getElementById('form2').style.display='none';
        document.getElementById('form3').style.display='none';
        document.getElementById('form4').style.display='block';
        document.getElementById('form5').style.display='none';
        document.getElementById('form6').style.display='none';

    }
    if(step == "4"){
        document.getElementById('form1').style.display='none';
        document.getElementById('form2').style.display='none';
        document.getElementById('form3').style.display='none';
        document.getElementById('form4').style.display='none';
        document.getElementById('form5').style.display='block';
        document.getElementById('form6').style.display='none';

    }

    if(step == "5"){
        document.getElementById('form1').style.display='none';
        document.getElementById('form2').style.display='none';
        document.getElementById('form3').style.display='none';
        document.getElementById('form4').style.display='none';
        document.getElementById('form5').style.display='none';
        document.getElementById('form6').style.display='block';

    }
}


$("#txt_codigo_postal").focusout(function() {
        cp = $('#txt_codigo_postal').val();
        if(cp.length == 5){
            $.ajax({
                type: "POST",
                url: "{{ url('/api/checkCp') }}",
                data: {
                    cp : cp
                },
                success:function(data){
                    $(".theSuburbs").empty().trigger('change');
                    if(data != 'Resultado no encontrado'){
                        cpError = 0;
                        $('#txt_codigo_postal').removeClass('is-invalid');
                        $('#txt_codigo_postal').addClass('is-valid');
                        $('#cpError').remove();
                        $('#txt_ciudad').val(data.Ciudad);
                        $('#txt_estado').val(data.Estado);
                        let theSuburbs = data.Asentamiento;
                        var data = {};

                        theSuburbs.forEach(function(theCurrentSuburb){
                            data.id = theCurrentSuburb;
                            data.text = theCurrentSuburb;
                            var newOption = new Option(data.text, data.id, false, false);
                            $('#txt_colonia').append(newOption).trigger('change');
                        });
                    }
                    else {
                        cpError = 1;
                        $('#txt_codigo_postal').addClass('is-invalid');
                        $('#cpError').remove();
                        $('#theCp').append('<span class="invalid-feedback" id="cpError" role="alert"><strong>No se ha encontrado ese C.P.</strong></span>');
                    }
                }
            });
        }
        else {
            $('#txt_codigo_postal').addClass('is-invalid');
            $('#cpError').remove();
            $('#theCp').append('<span class="invalid-feedback" id="cpError" role="alert"><strong>El código postal debe contener 5 números.</strong></span>');
        }
    });
</script>
