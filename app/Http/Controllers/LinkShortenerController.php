<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
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
                    "url" => $request->url,
                    "code" => hash('crc32b', $request->url),
                    "validity_until" => date('Y-m-d H:i:s.u', strtotime('+7 days'))
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
            'code' => 'required|string',
            'status' => 'required|boolean'

        ]);

        if ($validator->fails()) {

            return response()->json(["message" => "The status and code field is required"], 422);
        }

        try {

            $link = Link::where('code', $request->code)->update(
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
            'code' => 'required|string',
        ]);

        if ($validator->fails()) {

            return response()->json(["message" => "The code field is required"], 422);
        }

        $link = Link::where("code", $request->code)->first();


        if ($link) {

            if ($link->validity_until >= now() && $link->status) {
                return $link;
            }
        }

        return response()->json([
            "message" => "URL not found"
        ], 404);
    }
}
