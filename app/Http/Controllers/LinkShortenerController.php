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


            $register =  Link::where('url_to', $request->url);

            $link = Link::create(
                [
                    "url_from" => $request->url,
                    "url_to" => (string) Str::uuid(),
                    "validity_until" => date('Y-m-d H:S:s.u', strtotime('+7 days'))
                ]
            );

            return $link;
        } catch (\Exception $e) {

            return response()->json(["message" => $e], 500);
        }
    }


    public function edit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'hash' => 'required|string',
            'status' => 'required|boolean'

        ]);

        if ($validator->fails()) {

            return response()->json(["message" => "The status and hash field is required"], 422);
        }

        try {

            $link = Link::where('url_to', $request->hash)->update(
                [
                    "status" => $request->status,
                ]
            );

            return $link;
        } catch (\Exception $e) {

            return response()->json(["message" => $e], 500);
        }
    }

    public function show(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'hash' => 'required|string',
        ]);

        if ($validator->fails()) {

            return response()->json(["message" => "The hash field is required"], 422);
        }

        $link = Link::where("url_to", $request->hash)->first();

        if ($link) {

            if($link->validity_until >= now()){
                return $link;
            }
        }

        return response()->json([
            "message" => "URL not found"
        ], 404);
    }
}
