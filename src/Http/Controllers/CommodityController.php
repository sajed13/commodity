<?php

namespace Sajed13\Commodity\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Sajed13\Commodity\Models\Commodity;
use Illuminate\Support\Facades\Validator;
class CommodityController extends Controller
{
    public function fetchCommodities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => ['required','string','max:255']
        ]);
        if($validator->fails()) {
            return response()->json([
                'error' => 'validation failed',
                'message' => $validator->errors()
            ], 422);
        }
        $value = $request->value ? $request->value : 0;
        $client = new Client();
        $response = $client->request('GET', 'https://tradingeconomics.com/commodities', [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
            ],
        ]);

        $html = $response->getBody()->getContents();

        $dom = new \DOMDocument();
        @$dom->loadHTML($html);

        $xpath = new \DOMXPath($dom);
        $tables = $xpath->query("//table[contains(@class, 'table table-hover table-striped table-heatmap')]");
        $table = $tables->item($value);

        if ($table) {
            $rows = $table->getElementsByTagName('tr');

            $data = [];
            try{
                foreach ($rows as $row) {
                    $cols = $row->getElementsByTagName('td');

                    if ($cols->length >= 6) {
                    
                            Commodity::create([
                                'name' => $this->cleanString($cols->item(0)->nodeValue),
                                'price' => $this->cleanString($cols->item(1)->nodeValue),
                                'day' => $this->cleanString($cols->item(2)->nodeValue),
                                'present' => $this->cleanString($cols->item(3)->nodeValue),
                                'weekly' => $this->cleanString($cols->item(4)->nodeValue),
                                'monthly' => $this->cleanString($cols->item(5)->nodeValue),
                                'date' => $this->cleanString($cols->item(6)->nodeValue),
                            ]);
                        
                    }
                }
                return response()->json(['message' => 'Data saved successfully'], 200);
            } catch(\Exception $error) {
                return response()->json([
                    'error' => 'failed to save data',
                    'message' => $error->getMessage()
                ], 500);
            }
        } else {
            return response()->json(['error' => 'not found.'], 404);
        }
    }

    private function cleanString($string)
    {
        $string = trim($string);
        $string = preg_replace('/\s+/', ' ', $string);
        return $string;
    }
}
