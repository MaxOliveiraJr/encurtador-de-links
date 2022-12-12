<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class LinkShortenerController extends Controller
{
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [

            'url' => 'required|url'
        ]);

        if ($validator->fails()) {

            return response()->json(["message" => "The url field is required and in URL format"], 422);
        }


        try {

            $link = Link::create(
                [
                    "url_from" => $request->url,
                    "url_to" => (string) Str::uuid(),
                    "validity_until" => date('Y-m-d h:m:s.u', strtotime('+7 days'))
                ]
            );

            return $link;
        } catch (\Exception $e) {

            return response()->json(["message" => $e], 500);
        }
    }
}
