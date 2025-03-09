<?php

namespace Sajed13\Commodity\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CommodityController extends Controller
{
    public function fetchCommodities()
    {
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
        $table = $tables->item(0);

        if ($table) {
            $rows = $table->getElementsByTagName('tr');

            $data = [];

            foreach ($rows as $row) {
                $cols = $row->getElementsByTagName('td');

                if ($cols->length >= 3) {
                    $data[] = [
                        'name' => $this->cleanString($cols->item(0)->nodeValue),
                        'price' => $this->cleanString($cols->item(1)->nodeValue),
                        'day' => $this->cleanString($cols->item(2)->nodeValue),
                        'present' => $this->cleanString($cols->item(3)->nodeValue),
                        'weekly' => $this->cleanString($cols->item(4)->nodeValue),
                        'monthly' => $this->cleanString($cols->item(5)->nodeValue),
                        'date' => $this->cleanString($cols->item(6)->nodeValue),
                    ];
                }
            }

            return response()->json($data, 200, [], JSON_PRETTY_PRINT);
        } else {
            return response()->json(['error' => 'Table with class "table table-hover table-striped table-heatmap" not found.'], 404, [], JSON_PRETTY_PRINT);
        }
    }

    private function cleanString($string)
    {
        $string = trim($string);
        $string = preg_replace('/\s+/', ' ', $string);
        return $string;
    }
}
