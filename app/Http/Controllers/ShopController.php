<?php

namespace App\Http\Controllers;

use App\Product;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagination = 9;
        $categories = ['men clothing','jewelery','electronics','women clothing'];

        if (request()->category) {
             
            $client = new Client(); //GuzzleHttp\Client
            $url ="https://fakestoreapi.com/products/category/".request()->category;
            $api_url = $url ;
            $response = $client->request ('GET', $api_url, [ ]);
            $products = json_decode ((string)$response->getBody ());
            $categoryName = request()->category;
        }
        else {
            $client = new Client(); //GuzzleHttp\Client
            $url ="https://fakestoreapi.com/products?sort=asc";
            $api_url = $url ;
            $response = $client->request ('GET', $api_url, [ ]);
            $products = json_decode ((string)$response->getBody ());
            $categoryName='All';
             
        }

        return view('shop')->with([
            'products' => $products,
            'categories' => $categories,
            'categoryName' => $categoryName,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $client = new Client(); //GuzzleHttp\Client
        $url ="https://fakestoreapi.com/products/".$slug;
        $api_url = $url ;
        $response = $client->request ('GET', $api_url, [ ]);
        $product = json_decode ((string)$response->getBody ());
         
            
        $url ="https://fakestoreapi.com/products/category/".$product->category;
        $api_url = $url ;
        $response = $client->request ('GET', $api_url, [ ]);
        $mightAlsoLike = json_decode ((string)$response->getBody ());

        $stockLevel = 100;

        return view('product')->with([
            'product' => $product,
            'stockLevel' => $stockLevel,
            'mightAlsoLike' => $mightAlsoLike,
            'notproduct'=>$product->id
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|min:3',
        ]);

        $query = $request->input('query');

        // $products = Product::where('name', 'like', "%$query%")
        //                    ->orWhere('details', 'like', "%$query%")
        //                    ->orWhere('description', 'like', "%$query%")
        //                    ->paginate(10);

        $products = Product::search($query)->paginate(10);

        return view('search-results')->with('products', $products);
    }

    public function searchAlgolia(Request $request)
    {
        return view('search-results-algolia');
    }
}
