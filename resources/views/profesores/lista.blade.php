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

        <title class="titleSection">Registrados</title>
    </head>

    <body>

       <h1 class="titleSection">Profesores Registrados</h1>

       @php($c=count($registros))
       @if($c==0)

       <h1 class="subtitleSection">No existen usuarios registrados</h1>
       @else

        <div class='tabla'>
            <div class="table-responsive">
                <table  class="table table-hover" id="myTable">
            
                    <thead>
            
                        <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Eliminar</th>
                        </tr>

                    </thead>
                    <tbody>
                        @php ($contador=0)
                        @foreach($registros as $registro)
                            @php($contador ++) 
                            <tr>
                                {{csrf_field()}}
                                <input type="hidden" id='token' name="_token" value="{{csrf_token()}}"/>
                                
                                <td>{{$registro->id}}</td>
                                <td>{{$registro->name}}</td>
                                <td>{{$registro->last_name}}</td>
                                <td>{{$registro->email}}</td>
                                <td>
                                    <i class="fa fa-trash btn-sm btn-success"  id="modal_Btn-{{$contador}}" data-id='{{$registro->id}}' onclick='set_id({{$contador}})'></i>
                                </td>
                            </tr>
                        @endforeach    
                    </tbody>

                </table>
            </div>
        </div>

        <!-- Modal -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" id='cerrar'>&times;</span>
                <div class='contenido'>
                    <div class='datos'>                             
                        <p id='eliminado' class='eliminar'></p>
                    </div>
                </div>
            </div>
        </div>
        <!---->
        @endif

        <script>
            
            //**MODAL**//
        
            var modal = document.getElementById("myModal");
            var span = document.getElementById("cerrar");
            var eliminado = document.getElementById('eliminado')

            span.onclick = function() {
                //modal.style.display = "none";
                //location.href = "http://localhost:8001/registro"
                location.href = "{{route('registro')}}"
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }


            var cont = 0

            function set_id(id){

                cont = id
               
                var token = document.getElementById('token').value  
                var id_user = document.getElementById('modal_Btn-'+cont+'').getAttribute('data-id')

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
 
                console.log(id_user)
                   
                $.ajax({
                        url:"{{route('delete')}}",
                        type: "Post",
                        headers: {'X-CSRF-TOKEN': token},
                        data: JSON.stringify(id_user),
                        contentType: 'application/json; charset=utf-8',
                        success: function (data) {
                            
                            console.log(data)
                
                            modal.style.display='block'
                        
                            var nombre = data['nombre']
                            var exito = data['exito']
                            console.log(nombre,exito)

                            if(exito=='0'){

                               eliminado.innerHTML= 'Usuario  '+nombre+' eliminado con exito'

                            }else{

                                eliminado.innerHTML='Ocurrió un error :c'
                            }
                        },
                    
                        error: function (xhr, status, errorThrown) {

                            var status = xhr.status
                            console.log(status)
                            modal.style.display='block'

                            if(status==500){          
                                eliminado.innerHTML = 'En este momento no se ha podido realizar su solicitud, intente más tarde'            
                            }else{ 
                                eliminado.innerHTML = 'su solicitud no fue procesada :c'      
                            }
                        }
                    });//fin_ajax
            }

            //**fin_MODAL**//
            
            $(document).ready(function() {
                
                var table = $('#myTable').DataTable({
                    "lengthMenu": [[6, -1], [6, "todos"]],
                    searching:false,
                    "language": {
                        "lengthMenu": "ver _MENU_ registros por página",
                        "zeroRecords": "Usuario no encontrado",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "No existen usuarios registrados",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        "paginate": {
                            "previous": "página previa",
                            "next":"página siguiente"
                        }
                    }
                });

            });

        </script>
    </body> 
</html>

