<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display the specified category.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // In a real application, you would retrieve the category from the database
        // For now, we'll just pass the ID to the view
        return view('client.category', compact('id'));
    }
}