<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PointsMallController extends BaseController
{
    public function index(Request $request)
    {
        $products = get_products(['category' => 221, 'tag' => $request->input('tag')]);
        $tags = ['Keychain', 'APPAREL', 'Rubber', 'Chain', 'Pencil Sharpener', 'Collectible Card', 'Doll Figurine', 'Gift Box', 'Lunch Box'];
        return view('web.points-mall', compact('products', 'tags'));
    }
}
