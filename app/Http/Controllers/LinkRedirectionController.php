<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkRedirectionController extends Controller
{
    public function redirection($url)
    {

        $link = Link::where('url_to', $url)->first();

        if ($link) {

            return redirect()->away($link->url_from);
        }

        return response('404', [

            'message' => 'URL not found'
        ]);
    }
}
