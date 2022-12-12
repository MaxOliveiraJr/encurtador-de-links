<?php

namespace App\Http\Controllers;

use App\Models\Link;

class LinkRedirectionController extends Controller
{
    public function redirection($url)
    {

        $link = Link::where('url_to', $url)->first();

        if ($link) {

            return redirect()->away($link->url_from);

        } else {

            return response()->json([
                'message' => 'URL not found'
            ], 404);
        }
    }
}
