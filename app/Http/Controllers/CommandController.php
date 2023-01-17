<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\CommandProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Array_;

class CommandController extends Controller
{
    
    public function show($id)
    {
        return Command::with('sizes')->find($id);
    }
    public function store (Request $request)
    {
        $command = new Command();
        $command->user_id =1; 
        $product_id = $request->product_id;
        if($command->save())
        {
            foreach($request->products as $product)
            {
                $commandProduct = new CommandProduct();
                $commandProduct->command_id = $command->id;
                $commandProduct->product_id=$product_id; 
                $commandProduct->size_id = $product['size_id'];
                try {
                    $commandProduct->save();
                } catch (\Throwable $th) {
                    return response('Erreur qlq par',412);
                }
            }
            return response("Command Added Succesfuly",201);
        }
        else
            return response("command cannot be saved",412);
    }
}
