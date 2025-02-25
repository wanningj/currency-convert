<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Currency;

class CurrencyContoller extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'base_currency' => 'required|string',
            'convert_currency' => 'required|string',
            'rate' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $currency = Currency::create([
            'base_currency' => $request->base_currency,
            'convert_currency' => $request->convert_currency,
            'rate' => $request->rate
        ]);

        return response()->json($currency, 201);
    }

    public function currency()
    {
        //取得所有資料
        $currencies = Currency::all();

        //根據base_currency分組
        $group = $currencies->groupBy('base_currency');

        //整理格式
        $result = $group->map(function ($item, $base) {
            return [
                'base_currency' => $base,
                'last_updated' => $item->max('updated_at'),
                'rates' => $item->pluck('rate', 'convert_currency')->map(fn($rate) => round($rate, 5))
            ];
        })->values();

        return response()->json($result, 200);
    }

    public function convert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_currency' => 'required|string',
            'to_currency' => 'required|string',
            'amount' => 'required|int|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //查詢匯率
        $rate = Currency::where('base_currency', $request->from_currency)
            ->where('convert_currency', $request->to_currency)
            ->value('rate');

        if(!$rate){
            return response()->json(['error' => 'Currency conversion not found.'], 404);
        }

        //計算金額
        $convert_amount = $request->amount * $rate;

        //整理格式
        $result = [
            'from_currency' => $request->from_currency,
            'to_currency' => $request->to_currency,
            'amount' => (int) $request->amount,
            'converted_amount' => $convert_amount,
            'rate' => round($rate, 5)
        ];

        return response()->json($result, 200);
    }
}
