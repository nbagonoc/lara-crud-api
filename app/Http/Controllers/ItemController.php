<?php

namespace App\Http\Controllers;

use App\Http\Resources\Item as ItemResource;
use App\Item;
use Illuminate\Http\Request;
use Validator;

class ItemController extends Controller
{

    public function items()
    {
        $items = Item::orderBy('id', 'desc')->take(10)->paginate(10);
        return ItemResource::collection($items);
    }

    public function item($id)
    {
        $item = Item::find($id);

        if (is_null($item)) {
            // item not found
            return response()->json('Item not found', 404);
        } else {
            // show item
            return new ItemResource($item);
        }
    }

    public function create(Request $request)
    {
        $validation = [
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string|min:3|max:10000',
        ];
        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            // validation failed
            return response()->json($validator->errors(), 400);
        } else {
            // validation success
            $item = new Item;
            $item->title = $request->input('title');
            $item->body = $request->input('body');

            if ($item->save()) {
                // success
                return response()->json(['message' => 'Item saved'], 200);
            } else {
                // failed
                return response()->json(['message' => 'Something went wrong'], 500);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (is_null($item)) {
            // item not found
            return response()->json(['message' => 'Item not found'], 404);
        } else {
            // item found
            $validation = [
                'title' => 'required|string|min:3|max:255',
                'body' => 'required|string|min:3|max:10000',
            ];
            $validator = Validator::make($request->all(), $validation);

            if ($validator->fails()) {
                // validation failed
                return response()->json($validator->errors(), 400);
            } else {
                // validation success
                $item->title = $request->input('title');
                $item->body = $request->input('body');

                if ($item->update()) {
                    // success
                    return response()->json(['message' => 'Item updated'], 200);
                } else {
                    // failed
                    return response()->json(['message' => 'Something went wrong'], 500);
                }
            }
        }
    }

    public function delete($id)
    {
        $item = Item::find($id);

        if (is_null($item)) {
            // item not found
            return response()->json(['message' => 'Item not found'], 404);
        } else {
            // item found
            if ($item->delete()) {
                // success
                return response()->json(['message' => 'Item deleted'], 200);
            } else {
                // failed
                return response()->json(['message' => 'Something went wrong'], 500);
            }
        }

    }
}
