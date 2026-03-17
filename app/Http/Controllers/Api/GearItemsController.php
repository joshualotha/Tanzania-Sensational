<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GearItem;

class GearItemsController extends Controller
{
    public function index()
    {
        return response()->json(
            GearItem::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
        );
    }
}

