<?php

namespace App\Http\Controllers;

use App\Models\Link;

class LinkRedirectionController extends Controller
{
    public function redirection($url)
    {

        $link = Link::where('url_to', $url)->first();

        if ($link) {

            return $link;
        }

        return response()->json([
            'message' => 'URL not found'
        ],404 );
    }
}
