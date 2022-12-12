<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkShortenerController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'url' => 'required'
        ]);

        try {
            $link = new Link();
            $link->url_from = $request->url;
            $link->url_to = (string) Str::uuid();
            $link->validity_until = date('Y-m-d h:m:s', strtotime('+7 days'));
            $link->save();
            return $link;
        } catch (\Exception $e) {

            return $e;
        }
    }
}
