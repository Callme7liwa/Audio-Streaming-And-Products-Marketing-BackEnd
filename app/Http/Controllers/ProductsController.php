<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Photo ;
use App\Models\ProductPicture;
use App\Models\ProductsCategories;
use App\Models\ProductSize;
use App\Models\Produit_User_Like;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //pour que puisse proceder au filtrage par categorie
        return Product::with('categories')->get();
    }

    // cette fonction utile lorsqu'on veut afficher tous les produits dans la partie super-admin
    public function getProductsInDataBase ()
    {
        return Product::all();
    }

    public function getProductWithCategoriesAndSizes()
    {
        return Product::with('categories')->with('sizes')->with('photos')->get();
    }
                   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate aa\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product =  new Product();
        $product->name=$request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->photo=$request->photo->store('products');
        $product->user_id=Auth::user()->id;
       if($product->save()) 
       {
            foreach($request->sizes as $size)
            {     
                $productSize = new ProductSize();
                $productSize->product_id=$product->id ; 
                $productSize->size_id=$size;
                $productSize->save();
            }
         
           foreach($request->categories as $category)
           {
                   $productCategory = new ProductsCategories();
                   $productCategory->product_id=$product->id ; 
                   $productCategory->category_id=$category;
                   $productCategory->save();
           }
            foreach($request->file as $photo)
            {
                $productPhoto = new  ProductPicture();
                $productPhoto['file_photo']=$photo->store('products');
                $productPhoto['product_id']=$product->id;
                $productPhoto->save();
            }
           $response = [
               'product'=>Product::with('sizes')->with('categories')->find($product->id ),
               'message'=>'product has been added sucessefuly'
           ];
           return response($response,201);
       }
       else
           return response($message='erreur',500);
 }

    
    public function show($id)
    {
        return Product::with('sizes')->with('categories')->with('photos')->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       return   Product::destroy($id) ; 
    }

    public function search($name)
    {
       return   Product::where('name','like','%d'.$name.'%d')->get(); 
    }

    //faire une j'aime
    public function postLike ($id,$product_id)
    {
        $produit_user = new  Produit_User_Like();
        $produit_user->user_id=Auth::user()->id;
        $produit_user->product_id=$product_id;
        return $produit_user->save();
    }

    //produit aimé par ? 

    public function productLikedBy($id)
    {
        $produit  = Product::find($id)->get();
            if($produit !=null)
                return $produit->likedBy();
            return null;
    }

    public function accepte($id)
    {
        if(Auth::user()->is_admin)
        {
            $product = Product::find($id);
            $product->etat=1 ; 
            $product->save();
            return response  ([
                'product' => $product,
                'message' => 'Product has been accepted succesfuly ',
                'HTTP_RESPONSE'=> 402
            ]);
        }
        else
        {
            return response  ([
                'message' => " you're not authorized to do it" ,
                'HTTP_RESPONSE'=> 412
            ]);
        }
        
    }

    public function deleteProduct($id)
    { 
        $product = Product::find($id);
        if($product->etat==0 || $product->etat==1)
        {
            $response = [
            'message'=>'product has been deleted sucessefuly'
            ];
            $product->etat=-1 ; 
            if($product->save())
            return response($response,201); 
            else
            return response("Erreur qlq par", 412) ;
        }
        else
        {
            $response = [
                'message'=>'This product is already deleted'
            ];
            return response($response,500);  
        } 
      }
    
    //   Des le chargement de la page dash-main-products , 
    public function myProduct()
    {
        if(Auth::user()->is_admin)
        {
            return Product::all();
        }
        return Auth::user()->products;
    }

    public function ProductQueue()
    {
        if(Auth::user()->is_admin)
        {
            return Product::all()->where('etat', 0);
        }
        return Auth::user()->Products->where('etat',0);
    }

    public function ProductAccepted()
    {
        if(Auth::user()->is_admin)
        {
            return Product::all()->where('etat', 1);
        }
        return Auth::user()->Products->where('etat',1);
    }

    public function getProductsOfUsersWichImFollowing()
    {
        $follows = Auth::user()->following->pluck('id');
        $products = Product::whereIn('user_id',$follows)
                      ->where("etat",1)
                      ->with('user')
                      ->latest()
                      ->limit(10)
                      ->orderBy('created_at')
                      ->get();

        return $products;
    }

    public function addSizes(Request $request,$id)
    {
        $product = Product::find($id);
        foreach($request->sizes as $size)
        {
            $productSize = new ProductSize();
            $productSize->product_id=$product->id ; 
            $productSize->size_id=$size;
            try {
                $productSize->save();
            } catch (\Throwable $th) {
                return response("erreur qlq part",500);
            }
        }
        return response("Sizes added succesfuly",201);
    }

    public function addCategories(Request $request,$id)
    { 
        $product = Product::find($id);
        foreach($request->categories as $category)
        {
            $productCategory = new ProductsCategories();
            $productCategory->product_id=$product->id ; 
            $productCategory->category_id=$category;
            try {
                $productCategory->save();
            } catch (\Throwable $th) {
                return response("erreur qlq part",500);
            }
        }
        return response("Categories added succesfuly",201);
    }

    //pour que on puisse faire le filtrage between categories products
    public function getProducts()
    {
        $products=DB::select("select  c.id as categoryId ,p.*  from products p , products_categories pc , categories c where pc.category_id=c.id and pc.product_id=p.id");
            return $products;
    }
    public function ProductsOfTheSameCategory ($id) {
        
        //Get the product 
        $product = Product::find($id);
        //Get the categories
        $categories= $product->categories->pluck('id');
        $i=0;
        //get products of the categories
        foreach($categories as $categorie)
        {
            $products[$i]= DB::select("select * from products P , products_categories pc where p.id=pc.product_id  and pc.category_id = ".$categorie." and p.id!=".$id);
            $i++;
        }
        $k=0;
        // Convert to format adequat === table 
        for($i=0 ; $i<sizeof($products) ; $i++)
        {
            if(sizeof($products[$i]))
            {
                for($j=0 ; $j<sizeof($products[$i]);$j++)
                {
                    $MyFinalArray[$k]=$products[$i][$j];
                    $k++;
                }
            }
        }

    //   delete repeated items 
        $size = sizeof($MyFinalArray);
        for($i=0 ; $i<$size-1;$i++)
        {
            for($j=$i+1 ; $j<$size;$j++)
            {
                if($MyFinalArray[$i]->id==$MyFinalArray[$j]->id)
                    {
                        for($k=$j;$k<$size-1;$k++)
                            $MyFinalArray[$k]=$MyFinalArray[$k+1];
                        
                        $size--;
                    }
            }
        }
        // resize table
        for($i=0  ; $i<$size;$i++)
        {
            $lastArray[$i]=$MyFinalArray[$i];
        }
        $user = $product->user()->get();
        $collection = collect([
           'productsSameCategory'=>$lastArray,
           'productsSameSeller' => User::find($user[0]->id)->Products()->limit(3)->get()
        ]);
        
        return $collection;
    }


}
