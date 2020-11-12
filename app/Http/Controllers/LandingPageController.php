<?php
namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$products = Product::where('featured', true)->take(8)->inRandomOrder()->get();
        $client = new Client(); //GuzzleHttp\Client
        $url ="https://fakestoreapi.com/products?limit=12";
        $api_url = $url ;
        $headers = ""; //Ususall pass API Tokens or AUTH Credentials
        $response = $client->request ('GET', $api_url, [ ]);
        $products = json_decode ((string)$response->getBody ());
        return view('landing-page')->with('products', $products);
    }
}
