<?php

namespace App\Http\Controllers;

use App\Models\Link;

class LinkRedirectionController extends Controller
{
    public function redirection($code)
    {

        $link = Link::where('code', $code)->first();

        if ($link) {

            return redirect()->away($link->url);
        }

        return response('404', [

            'message' => 'URL not found'
        ]);
    }
}
