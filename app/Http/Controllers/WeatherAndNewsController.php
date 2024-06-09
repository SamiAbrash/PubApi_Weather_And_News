<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherAndNewsController extends Controller
{
    public function getFunction(Request $request)
    {
        $weatherKey = env('WEATHER_API_KEY');
        $newsKey = env('NEWS_API_KEY');

        $city = $request->query('city','Beirut');

        $weatherUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$weatherKey}&units=metric";

        $weatherRes = Http::get($weatherUrl);

        if (!$weatherRes->successful())
        {
            return response()->json(['error','Error retrieving weather data']);
        }
        $weatherData = $weatherRes->json();
        $weatherCondition = $weatherData['weather'][0]['main']; // e.g., Rain, Clear, Snow

        $newsUrl = "https://newsapi.org/v2/everything?q={$weatherCondition}&apiKey={$newsKey}";
        $newsRes = Http::get($newsUrl);

        if (!$weatherRes->successful())
        {
            return response()->json(['error','error retreiving news data']);
        }
        $newsData = $newsRes->json();

        return response()->json([
            'WEATHER' => $weatherData,
            'NEWS' => $newsData,
        ]);
    }
}
