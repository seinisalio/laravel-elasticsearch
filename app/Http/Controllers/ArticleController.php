<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Redirect,File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Article;
use Response;

class ArticleController extends Controller
{
    public function search(Request $request){
 		if ($request->ajax()) {
 			$data = Article::where('title','like','%'.$request->search.'%')
 							 ->orwhere('montant',$request->search)
 							 ->orwhere('details','like','%'.$request->search.'%')->get();
 			$output = '';
 			if (count($data) > 0) {
 				foreach ($data as $row) {
                    $path = asset('storage/'.$row->url_photo);
                    $output .='
                    <div class="col-lg-4" style="background-color: white;border-radius: 5px; margin: 2px 2px 2px 2px;">
                        <div class="row" style=" margin: 10px 2px 2px 2px;">
                            <div class="col-lg-8">
                                <h6 class="" style="color: purple; font-weight: bold; font-size: 0.85em;"> <strong > Nom : </strong>'.$row->title.' </h6>
                                <br>
                                <p style="text-align: center; font-weight: bold;color: red; font-size: 1em;"> Montant : '.$row->montant.'f </p>
                                        
                            </div>
                            <div class="col-lg-4">
                                <img src="'.$path.'" width="80" height="100">
                            </div>
                        </div>
                        <div class="row" style=" margin: 10px 2px 2px 2px;">
                            <div class="col-lg-12">

                                <p > 
                                    <strong style="font-size: 1em; ">Publié le :</strong>
                                    <span style="font-weight: bold; font-size: 0.9em; "> ' .$row->created_at.'</span>
                                </p>
                                <p > 
                                    <strong>Détails :</strong>
                                </p>
                                <p > 
                                    '.$row->details.'
                                </p>
                                        
                            </div>
                        </div>
                    </div>';
                }
 			}else{
 				$output .= 'Aucun resultat';
 			}
            return Response()->json([
                "output" => $output,
                "number" => count($data)
            ]);
 		}	
 	}
 	public function index(){
 		//Article::addAllToIndex();
 		//$data = Article::search($request->search)->toArray();
    	return view('welcome');
    	//$data = Article::search('ga');
    	//dd($data);
 	}
 	public function addDocument(Request $request){
        $title = request('title');
        $montant = request('montant');
        $details = request('details');
        $image = $request->file('photo');

        if($title == "" || $montant == "" || $details == "" || empty($image)){
            $data = '<p style="text-align: center; color: red">Documment non enregistré, renseignez tous les champs</p>';
            
        }else{

            $repertoire = "Articles";
            $path_image =  Storage::disk('public')->putFile($repertoire, $image);

            $article = Article::create([
                'title' => $title,
                'montant' => $montant,
                'details' => $details,
                'url_photo' => $path_image,
            ]);
            $article->addToIndex();
            $data = '<p style="text-align: center; color: green">Documment ajouté avec succès</p>';
        }
        return $data;
 		
 	}
 	
}
