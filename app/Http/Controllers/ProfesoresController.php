<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Profesor;

class ProfesoresController extends Controller
{
    public function show(){

        $client = new Client();
        //dd($client);
        $request = $client->get('https://reqres.in/api/users?page=1');
        $request_ = $client->get('https://reqres.in/api/users?page=2');
        //dd($request,$request_);
        $data = json_decode($request->getBody()->getContents());
        $data_ = json_decode($request_->getBody()->getContents());
        //dd($data->data); 
        $datos = $data->data;
        $datos_ = $data_->data;
        //dd($datos,$datos_);
        
        $registros=array();
       
        foreach($datos as $dato){
            array_push($registros,$dato);
        }
        foreach($datos_ as $dato){
            array_push($registros,$dato);
        }
        //dd($registros);

        //dd(gettype($datos));
        //dd($datos[0]->id);
    	return view('profesores.index',compact('registros'));
    }

    public function insert(Request $request){

        $first_name = $request[0][0];
        $last_name = $request[0][1];
        $email = $request[0][2];

        $new = new Profesor;
        $new->name = $first_name;
        $new->last_name = $last_name;
        $new->email = $email;
        $new->save();

        return $new;
    }

    public function lista(){
        $registros = Profesor::all();
        return view('profesores.lista',compact('registros'));
    }

    public function delete(Request $request){

        $id = $request;
     
        $i = gettype($id[0]);
        //return $id[0];
        //return $id;

        $id_user = (int)$id[0];

        $u = Profesor::where('id',$id_user)->get();

        $c = Profesor::where('id',$id_user)->delete(); 

        $exito = Profesor::where('id',$id_user)->get();

        $existe = count($exito);

        $datos = [

            'nombre'=>$u[0]->name,
            'exito'=>$existe

        ];

        return $datos; 

    }
}
