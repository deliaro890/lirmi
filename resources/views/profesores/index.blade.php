<!doctype html>

<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">  
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
        <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet"> 
        <script src="https:////cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"> </script>
        

        <link rel="stylesheet" href="/css/font-awesome.css"/>
        <link rel="stylesheet" href="/css/estilos.css"/>

        <title>Profesores</title>

        

    </head>

    <body>

       <h1 class="titleSection">Registro de Profesores</h1>

        <div class='tabla'>
            <div class="table-responsive">
                <table  class="table table-hover" id="myTable">
            
                    <thead>
            
                        <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Registrar</th>
                        </tr>

                    </thead>
                    <tbody>
                        @php ($contador=0)
                        @foreach($registros as $registro)
                            @php($contador ++) 
                            <tr>
                                <td>{{$contador}}</td>
                                <td>{{$registro->first_name}}</td>
                                <td>{{$registro->last_name}}</td>
                                <td>
                                    <i class="fa fa-edit btn-sm btn-success"  id="modal_Btn-{{$contador}}" data-target='{{$contador}}' onclick='set_id({{$contador}})'></i>
                                    <!-- Modal -->
                                    <div id="myModal-{{$contador}}" class="modal">
                                    
                                        <div class="modal-content">
                                            <span class="close" id='close-{{$contador}}'>&times;</span>
                                            <div class='contenido'>
                                                <div class='datos'>

                                                    <div class='avatar'><img src='{{$registro->avatar}}'></div>
                                                    <div class='info'>
                                                    {{csrf_field()}}
                                                    <input type="hidden" id='token' name="_token" value="{{csrf_token()}}"/>

                                                        <p class='nombre'>{{$registro->first_name}}</p>
                                                        <p class='apellido'>{{$registro->last_name}}</p>
                                                        <p class='email'>{{$registro->email}}</p>
                                                    </div>

                                                </div>
                                                
                                                <button class='boton' id='registrar-{{$contador}}' nombre='{{$registro->first_name}}' last_name='{{$registro->last_name}}' email='{{$registro->email}}'>Registrar</button>
                                                <p id='usuario-{{$contador}}' class='mensaje'></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!---->
                                </td>
                            </tr>
                        @endforeach    
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>Id</th>
                        
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <a href="{{route('lista')}}" class='link'>Usuarios registrados</a>

        <script>
            
            //**MODAL**//
            var cont = 0

            function set_id(id){
                cont = id
                //alert("modal_Btn-"+cont+"")
                var btn = document.getElementById('modal_Btn-'+cont+'');

                var modal = document.getElementById("myModal-"+cont+"");
                modal.style.display = "block";

                var span = document.getElementById("close-"+cont+"");

              
                span.onclick = function() {
                modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
                }

                var registrar = document.getElementById("registrar-"+cont+"");

                arreglo = []

                registrar.onclick = function(){

                    var token = document.getElementById('token').value
                  
 
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
 


                    profesor = []
                    var first_name = registrar.getAttribute('nombre')
                    var last_name = registrar.getAttribute('last_name')
                    var email = registrar.getAttribute('email')
                    profesor.push(first_name)
                    profesor.push(last_name)
                    profesor.push(email)

                    arreglo.push(profesor)

                    //alert(arreglo)
                    console.log(arreglo)
                    //ajax
                    $.ajax({
                        url:"{{route('insert')}}",
                        type: "Post",
                        headers: {'X-CSRF-TOKEN': token},
                        data: JSON.stringify(arreglo),
                        contentType: 'application/json; charset=utf-8',
                        success: function (data) {
                            
                            console.log(data)
                           
                            var usuario = document.getElementById('usuario-'+cont+'')
                            usuario.innerHTML='Usuario: '+data['name']+' registrado con éxito!'
            
                        },
                    
                        error: function (xhr, status, errorThrown) {
                            
                            var status = xhr.status
                            console.log(status)

                            if(status==500){

                                alert('En este momento no se ha podido realizar su solicitud, intente más tarde')

                            }else{

                                alert('su solicitud no fue procesada :c')

                            }
                        }
                    });//fin_ajax

                }

                



            }

            //**fin_MODAL**//
            
            $(document).ready(function() {
                
                $('#myTable tfoot th').each( function (i) {
                    var title = $('#myTable thead th').eq( $(this).index() ).text();
                    $(this).html( '<input type="text" placeholder="Search '+title+'" data-index="'+i+'" />' );
                } );
            
                var table = $('#myTable').DataTable( {

                    "lengthMenu": [[6, -1], [6, "All"]]
                } );
            
                // Filter 
                $( table.table().container() ).on( 'keyup', 'tfoot input', function () {
                    table
                        .column( $(this).data('index') )
                        .search( this.value )
                        .draw();
                });

   
            });

        </script>
    </body> 
</html>